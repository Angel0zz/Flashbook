<div class="popup-cont">

<div class="albumgroup">
        <ul>
            <li class ="imgAlbum"  id="imgAlbum" onclick="OpenImgAlbum()">
                Image Album 
            </li>
            <li class ="vidAlbum" id="vidAlbum" onclick="OpenVidAlbum()">
                Video Album
            </li>
        </ul>
</div>

<div class="albums" id="albums">
        <div class="image-albums active ">
            <div class="gallery-head">
                Image Albums
            </div>


            <div class="album-container">
            <?php while($row = mysqli_fetch_assoc($album_run)){ ?>
            <div class="album-card" onclick="OpenAlbum()">
                <a href="#"  class ="view_data">
                    <section class="image-cont">
                        <?php 
                            // Assuming $row['images'] contains a JSON-encoded array of image filenames
                            $currentImages = json_decode($row['image'], true); 
                            
                            if (!empty($currentImages)) {
                                $image = $currentImages[0]; // Fetch the first image
                                echo '<img src="../uploads/' . htmlspecialchars($image) . '" alt="" >';
                            } else {
                                echo '<p>No images available</p>';
                            }
                        ?>
                    </section>
                    
                    <section class="album-title">
                        <table>
                        <tr>
                        <td class ="albumID" style='display:none;'> <?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        </tr>
                        </table>
                    
                    </section> 
                </a> 
            </div>
            <?php } ?>

            </div>
        </div>


        <div class="video-album">
        <div class="gallery-head">
                Video Album
            </div>

  
<div class="album-container">

    <?php
    if (mysqli_num_rows($vid_album_run2) > 0) {
        while ($video = mysqli_fetch_assoc($vid_album_run2)) { 
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
                                <td><?=$video['name']?></td>
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

</div><!--albums close-->

<div class="gallery Gallery" id="Gallery"></div>
</div>


<div id="imagePopup" class="popup" style="display:none;">
<span class="close" onclick="closePopup()">&times;</span>
<div class="carousel"></div> <!-- Carousel container for dynamic images -->

<!--logout -->

