<?php

   include("../php/connection.php");


if (isset($_POST["updatePpic"])) {
    $userId = $_SESSION['id']; 
    $updateProfile = $_FILES["updateProfilePic"]["name"];
    $fileSizeImage = $_FILES["updateProfilePic"]["size"];
    $tempNameImage = $_FILES["updateProfilePic"]["tmp_name"];
    $validImageExtensions = ['jpg', 'jpeg', 'png'];
    $imageExtensionImage = pathinfo($updateProfile, PATHINFO_EXTENSION);

    if (!in_array(strtolower($imageExtensionImage), $validImageExtensions)) {
        echo "Invalid image file format";
    } else if ($fileSizeImage > 10000000) {
        echo "<script>alert('Image file size is too large')</script>";
    } else {
        $newImageName = uniqid() . '.' . $imageExtensionImage;
        if (move_uploaded_file($tempNameImage, '../img/' . $newImageName)) {
            $query = "UPDATE tb_freelancers SET profile = '$newImageName' WHERE id = '$userId'";

            if (mysqli_query($con, $query)) {
                header("Location: ./myportfolio.php?success=Profile Image Updated SuccessFully ");
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            header("Location: ./myportfolio.php?error=something Went Wrong   ");
        }
    }
}





if(isset($_POST['click_view_btn'])){
    $albumID = $_POST['album_id'];

    if (isset($_POST['submit'])) {
        $totalFiles = count($_FILES['fileImg']['name']);
        $newFilesArray = [];

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES["fileImg"]["name"][$i];
            $tmpName = $_FILES["fileImg"]["tmp_name"][$i];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExtension;

            if (!is_dir('../uploads')) {
                mkdir('../uploads', 0755, true);
            }

            move_uploaded_file($tmpName, '../uploads/' . $newFileName);
            $newFilesArray[] = $newFileName;
        }

        $sql = "SELECT image FROM tb_images WHERE id = '$albumID' LIMIT 1";
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) > 0){
            $imgRow = mysqli_fetch_assoc($result);
            $currentImages = json_decode($imgRow['image'], true) ?? [];
        } else {
            $currentImages = [];
        }

        $allFiles = array_merge($currentImages, $newFilesArray);
        $allFilesJson = json_encode($allFiles);
        $query = "UPDATE tb_images SET image = '$allFilesJson' WHERE id = '$albumID'";
        mysqli_query($con, $query);
        header("location:gallery.php?success=image inserted successfully");
    }

    // Retrieve the album details after any updates
    $sql = "SELECT image, name FROM tb_images WHERE id = '$albumID' LIMIT 1";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0){
        $imgRow = mysqli_fetch_assoc($result);
        $currentImages = json_decode($imgRow['image'], true) ?? [];
        $imageName = $imgRow['name'];
    
        echo '<div class="ghead">
            <section class="albumName">
                <h2>' . htmlspecialchars($imageName) . '</h2>
            </section>
            <section class="addimage">
                <form action="" method="post" enctype="multipart/form-data">
                    Files:
                    <input type="file" name="fileImg[]" accept=".jpg, .jpeg, .png, .mp4, .gif" required multiple>
                    <button type="submit" name="submit">Submit</button>
                    <input type="hidden" name="album_id" value="' . htmlspecialchars($albumID) . '">
                    <input type="hidden" name="click_view_btn" value="true">
                </form>
            </section>
        </div>
        <div class="containerg" id="galleryContainer">
            <div class="photo-gallery">
                <div class="column">';
    
        if (!empty($currentImages)) {
            foreach ($currentImages as $index => $image) {
                echo '<div class="portfolio-gallery" style="position: relative; display: inline-block;">
                        <img src="../uploads/' . htmlspecialchars($image) . '" width="200" onclick="openPopup(' . $index . ')">
                        <span style="position:absolute; top:5px; right:5px; cursor:pointer; color:red; font-weight:bold;" 
                              onclick="deleteImage(' . $index . ', \'' . htmlspecialchars($image) . '\', \'' . htmlspecialchars($albumID) . '\')">X</span>
                      </div>';
            }
        } else {
            echo '<p>No images available</p>';
        }
    
        echo '      </div>
                    </div>
                </div>';
    } else {
        echo 'No record';
    }
}


if(isset($_POST['create'])){
    $album = $_POST['album'];
    if(empty($album)){
        echo "Input album name first";
    } else {
        // Insert the album with the logged-in user's freelancer ID
        $query = "INSERT INTO tb_images (name, freelancerID) VALUES ('$album', '$userId')";
        if(mysqli_query($con, $query)){
            header("Location: gallery.php?success=Album created successfully");
            exit();
        } else {
            die("Error: " . mysqli_error($con));
        }
    }
};

//create Video  Album
if (isset($_POST['create-video-album'])) {
    $video_name = $_FILES['my_video']['name'];
    $tmp_name = $_FILES['my_video']['tmp_name'];
    $error = $_FILES['my_video']['error'];
    $video_size = $_FILES['my_video']['size']; // Get the file size

    $title = $_POST['videotitle'];
    
    // Maximum file size: 1GB (in bytes)
    $max_file_size = 1024 * 1024 * 1024; // 1GB in bytes

    if ($error === 0) {
        if ($video_size > $max_file_size) {
            $em = "The file is too large. Maximum file size is 1GB.";
            header("Location: gallery.php?error=" . urlencode($em));
            exit();
        }

        $video_ex = pathinfo($video_name, PATHINFO_EXTENSION);
        $video_ex_lc = strtolower($video_ex);
        $allowed_exs = array("mp4", 'webm', 'avi', 'flv');

        if (in_array($video_ex_lc, $allowed_exs)) {
            $new_video_name = uniqid("video-", true) . '.' . $video_ex_lc;
            $video_upload_path = '../uploads/' . $new_video_name;
            move_uploaded_file($tmp_name, $video_upload_path);

            // Now let's insert the video path into the database
            $query = "INSERT INTO tb_videos (name, video, freelancerID) VALUES ('$title', '$new_video_name', '$userId')";
            mysqli_query($con, $query);
            header("Location: gallery.php?success=Album created successfully");
            exit();
        } else {
            $em = "You can't upload files of this type";
            header("Location: gallery.php?error=" . urlencode($em));
            exit();
        }
    } else {
        $em = "An error occurred during file upload.";
        header("Location: gallery.php?error=" . urlencode($em));
        exit();
    }
}


//detele video

if (isset($_POST['action']) && $_POST['action'] === 'delete-video') {
    if (isset($_POST['video_id'])) {
        $video_id = mysqli_real_escape_string($con, $_POST['video_id']);

        // Fetch video details to get the file path
        $query = "SELECT video FROM tb_videos WHERE id = '$video_id'";
        $result = mysqli_query($con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $video = mysqli_fetch_assoc($result);
            $video_path = '../uploads/' . $video['video'];

            // Delete the video file from the server
            if (file_exists($video_path)) {
                unlink($video_path);
            }

            // Delete the video record from the database
            $delete_query = "DELETE FROM tb_videos WHERE id = '$video_id'";
            mysqli_query($con, $delete_query);
        }

        // Redirect to the previous page or another page
        header("Location: gallery.php?msg=video deleted successfully");
        exit();
    }
}

//archive Image Album
if (isset($_POST['Archive_Album'])){
    $userId = $_SESSION['id']; 
    $imageAlbum =$_POST['Albumid'];
    $query = "UPDATE tb_images SET Archived = 1 WHERE id = $imageAlbum AND freelancerID = $userId";
    $result = mysqli_query($con, $query);


     if ($result) {
        // Optionally: Redirect or provide a success message
        header("Location: ./myportfolio.php?success=Album archived successfully.");
        exit();
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($con);
    }

}
//retrtive archive
if (isset($_POST['retrive'])){
    $userId = $_SESSION['id']; 
    $imageAlbum =$_POST['Albumid'];
    $query = "UPDATE tb_images SET Archived = 0 WHERE id = $imageAlbum AND freelancerID = $userId";
    $result = mysqli_query($con, $query);


     if ($result) {
        // Optionally: Redirect or provide a success message
        header("Location: ./myportfolio.php?success=Album archived successfully.");
        exit();
    } else {
        // Handle the error
        echo "Error: " . mysqli_error($con);
    }

}



//popup dashboard 
function generateDataAttributes($row, $fields) {
    $attributes = '';
    foreach ($fields as $field => $label) {
        $value = htmlspecialchars($row[$field] ?? '', ENT_QUOTES, 'UTF-8');
        $attributes .= "data-$label=\"$value\" ";
    }
    return trim($attributes);
}

$fields = [
    'id' => 'id',
    'name' => 'name',
    'contactNum' => 'contact',
    'email' => 'email',
    'location' => 'location',
    'head' => 'package',
    'price' => 'package',
    'date' => 'date',
    'details' => 'details'
];
