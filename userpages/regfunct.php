<?php 
   include("../php/connection.php");
   
if(isset($_POST['click_view_btn'])){
    $albumID = $_POST['album_id']; 

    $sql = "SELECT image, name FROM tb_images WHERE id = '$albumID' LIMIT 1";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        $imgRow = mysqli_fetch_assoc($result);
        $currentImages = json_decode($imgRow['image'], true) ?? [];
        $imageName = $imgRow['name'];

        echo '
         <div class="gallery-head">
                           '. htmlspecialchars($imageName) .' 
                    </div>
        <div class="containerg" id="galleryContainer">
            <div class="photo-gallery">
                <div class="column">';

                if (!empty($currentImages)) {
                    foreach ($currentImages as $index => $image) {
                        // Passing image list as a JSON-encoded array to the openPopup() function
                        echo '<div class="portfolio-gallery">
                                <img src="../uploads/' . htmlspecialchars($image) . '" width="200" onclick="openPopup(' . $index . ', ' . htmlspecialchars(json_encode($currentImages)) . ')">
                              </div>';
                    }
                } else {
                    echo '<div class="portfolio-gallery">
                    <img src="../uploads/' . htmlspecialchars($image) . '" width="200" onclick="openPopup(' . $index . ', ' . htmlspecialchars(json_encode($currentImages)) . ')">
                  </div>';
                }

        echo '      </div>
                </div>
            </div>';
    } else {
        echo 'No record';
    }
}


