<div class="popup-cont" id="viewusermodal">
        <div class="create-album">
            <div class="create-album-head">
                <p><span>&#43;</span> Create New Album</Button></p>
            </div>

            <form action="" method="POST">
                <label for=""><p>Album Name</p></label>
                <input type="text" name="album" id="album" >
                <button type="submit" name="create" class ="create">Create</button>
                <button type="button" name="cancel" class="cancel" onclick="CloseAlbum()">Cancel</button>
            </form> 
            
        </div>
        <div class="Gallery" id="Gallery"></div>

        <div class="logout-box">      
            Are you Sure you want to <span style ="color:#8b49f5; font-weight: 700;" >Logout?</span><br>
            <a href="../php/FreelancerLogout.php"><button class ="create accept">Logout</button></a>
            <button type="button" name="cancel" class="cancel delete" onclick="CloseLogoutBox()">Cancel</button>
        </div>

        <div class="create-video-album create-album">
            <div class="create-album-head">
                <p><span>&#43;</span> Create New Video Album</Button></p>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="my_video">
                <label for=""><p>Video tittle </p></label>
                <input type="text" name="videotitle" id="videotitle" >
                <div class="btn-group">
                <button type="submit" name="create-video-album" class ="create-video-album">Save</button>
                <button type="button" name="cancel" class="cancel" onclick="CloseAlbum()">Cancel</button>
                </div>
                
            </form> 
        </div>
</div>

<div id="imagePopup" class="popup">
    <span class="close" onclick="closePopup()">&times;</span>
    <div class="carousel">
        <?php foreach ($currentImages as $index => $image) : ?>
                <img src="../uploads/<?php echo htmlspecialchars($image); ?>" id="carouselImage<?php echo $index; ?>">
        <?php endforeach; ?>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>
</div>
    

