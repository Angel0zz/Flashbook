<?php require('./views/partials/head.php')?>
    <?php require('./views/partials/nav.php');

    $album = "SELECT * FROM tb_images WHERE freelancerID = '$userId' AND Archived  = 0";
    $album_run = mysqli_query($con,  $album);

    $archives = "SELECT * FROM tb_images WHERE freelancerID = '$userId' AND Archived  = 1";
    $archives_run = mysqli_query($con,  $archives);



    $vid_album = "SELECT * FROM tb_videos WHERE freelancerID = '$userId'";
    $vid_album_run = mysqli_query($con,  $vid_album);
    ?>
    <div class="albumgroup">
        <ul>
            <li class ="imgAlbum"  id="imgAlbum" onclick="OpenImgAlbum()">
                Image Album 
            </li>
            <li class ="vidAlbum" id="vidAlbum" onclick="OpenVidAlbum()">
                Video Album
            </li>
            <li class ="ArchivesBut" id="Archives" onclick="OpenArchives()">
                Archives
            </li>
        </ul>
    </div>

    <div class="image-Album active">
        <div class="gallery-head">
            <section><h2>Image Albums</h2></section>
            <section><Button onclick="CreateAlbum()"><span>&#43;</span> Add New Album</Button></section>
        </div>

        <div class="album-container">
            <?php while($row = mysqli_fetch_assoc($album_run)){ ?>

                    <div class="album-card" >
                        <a href="#" class ="view_data" onclick="OpenGallery()">
                            <section class="image-cont">
                                <?php 
                                    // Assuming $row['images'] contains a JSON-encoded array of image filenames
                                    $currentImages = json_decode($row['image'], true); 
                                    
                                    if (!empty($currentImages)) {
                                        $image = $currentImages[0]; // Fetch the first image
                                        echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="" onclick ="CloseGallery()">';
                                    } else {
                                        echo '<p>No images available</p>';
                                    }
                                ?>
                            </section>
                        </a> 
                            <section class="album-title">
                                <table>
                                    <tr>
                                        <td class ="albumID" > <h4><?php echo htmlspecialchars($row["id"]); ?></h4></td>
                                        <td style='width:180px;  transform: translate(10%, -150%);  background-color: rgba(165, 42, 42, 0.7);  color:white; text-align:center; font-size:23px;'><h4><?php echo htmlspecialchars($row["name"]); ?></h4></td>
                                
                                            <td class ="delete-vid">
                                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to remove this Album?');">
                                            <input type="hidden" name="Albumid" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                            <button type="submit" name="Archive_Album" value="archive-video">Remove</button>

                                        </form>
                                    </td>
                                    </tr>
                                </table>                                                  
                            </section> 
                    
                    </div>
    

            <?php } ?>

        </div>

    </div>

    <div class="video-Album">
        <div class="gallery-head">
            <section><h2>Video Album</h2></section>
            <section><Button  onclick="CreateVidAlbum()"><span>&#43;</span> Add New Video</Button></section>
        </div>

          
        <div class="album-container">

            <?php
            if (mysqli_num_rows($vid_album_run) > 0) {
                while ($video = mysqli_fetch_assoc($vid_album_run)) { 
            ?>
                    <div class="album-card">
                      
                            <section class="image-cont">
                            <video src="../uploads/<?=$video['video']?>" autoplay muted controls>
                                Your browser does not support the video tag.
                            </video>

                            </section>
                            
                            <section class="album-title">
                                <table>
                                    <tr>
                                        <td class="albumID"><h4><?=$video['id'] ?></h4></td>
                                        <td><h4>.<?=$video['name']?></h4></td>

                                        <td class ="delete-vid"><form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                    <input type="hidden" name="video_id" value="<?=$video['id']?>">
                                    <button type="submit" name="action" value="delete-video">Delete</button>
                                </form></td>
                                    </tr>
                                </table>
                            </section> 
                    </div>
            <?php
                }
            } else {
            ?>
                <div class="album-card">
                    <section class="image-cont">
                        <p>No videos available</p>
                    </section>
                    
                    <section class="album-title">
                        <table>
                            <tr>
                                <td><h4>No videos to display</h4></td>
                            </tr>
                        </table>

                    </section> 
                </div>
            <?php
            }
            ?>
        </div>

    </div>

    <div class="Archives ">
        <div class="gallery-head">
            <section><h2>Image Albums</h2></section>
            <section><Button onclick="CreateAlbum()"><span>&#43;</span> Add New Album</Button></section>
        </div>

        <div class="album-container">
            <?php while($row = mysqli_fetch_assoc($archives_run)){ ?>
            <div class="album-card" >
                <a href="#" class ="view_data" onclick="OpenGallery()">
                    <section class="image-cont">
                        <?php 
                            // Assuming $row['images'] contains a JSON-encoded array of image filenames
                            $currentImages = json_decode($row['image'], true); 
                            
                            if (!empty($currentImages)) {
                                $image = $currentImages[0]; // Fetch the first image
                                echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="" onclick ="CloseGallery()">';
                            } else {
                                echo '<p>No images available</p>';
                            }
                        ?>
                    </section>
                </a> 
                    <section class="album-title">
                        <table>
                            <tr>
                                <td class ="albumID" > <h4><?php echo htmlspecialchars($row["id"]); ?></h4></td>
                                <td><h4><?php echo htmlspecialchars($row["name"]); ?></h4></td>
                        
                                    <td class ="delete-vid">
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to remove this Album?');">
                                    <input type="hidden" name="Albumid" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                    <button type="submit" name="retrive" value="retrive">Retrive</button>

                                </form>
                            </td>
                            </tr>
                        </table>
                      
                        
                    
                    </section> 
              
            </div>
            <?php } ?>

        </div>

    </div>
   <script>
    function deleteImage(index, image, albumID) {
        if (confirm("Are you sure you want to delete this image?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../php/delete_image.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        alert("Image deleted successfully.");
                        location.reload(); // Refresh the page to see the changes
                    } else {
                        console.error("Error deleting image:", xhr.responseText);
                        alert("An error occurred while deleting the image.");
                    }
                }
            };

            // Send image and album ID
            xhr.send("image=" + encodeURIComponent(image) + "&album_id=" + encodeURIComponent(albumID));
        }
    }
</script>

<?php require('./views/partials/popups.php')?>
<?php require('./views/partials/footer.php')?>