<?php
require 'config.php';

if(isset($_POST['click_view_btn'])){
    $albumID = $_POST['album_id']; // renamed $id to $albumID for clarity

    // Check if the form to submit new images has been submitted
    if (isset($_POST['submit'])) {
        $totalFiles = count($_FILES['fileImg']['name']);
        $newFilesArray = [];

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES["fileImg"]["name"][$i];
            $tmpName = $_FILES["fileImg"]["tmp_name"][$i];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExtension;

            // Ensure the uploads directory exists
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            move_uploaded_file($tmpName, 'uploads/' . $newFileName);
            $newFilesArray[] = $newFileName;
        }

        // Retrieve existing images
        $sql = "SELECT image FROM tb_images WHERE id = '$albumID' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $imgRow = mysqli_fetch_assoc($result);
            $currentImages = json_decode($imgRow['image'], true) ?? [];
        } else {
            $currentImages = [];
        }

        // Append new files to existing files
        $allFiles = array_merge($currentImages, $newFilesArray);
        $allFilesJson = json_encode($allFiles);

        // Update the database with the new list of files
        $query = "UPDATE tb_images SET image = '$allFilesJson' WHERE id = '$albumID'";
        mysqli_query($conn, $query);

        // Display success message
        header("location:upload.php?msg=image inserted successfully");
    }

    // Retrieve the album details after any updates
    $sql = "SELECT image, name FROM tb_images WHERE id = '$albumID' LIMIT 1";
    $result = mysqli_query($conn, $sql);

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
                echo '<div class="portfolio-gallery">
                        <img src="uploads/' . htmlspecialchars($image) . '" width="200" onclick="openPopup(' . $index . ')">
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
?>
