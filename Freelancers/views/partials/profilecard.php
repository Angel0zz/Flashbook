<div class="freelancer-card-cont" id="freelancer-card-cont">
        <div class="freelancer-card">
        <span id="closeCard" class="close-card">&times;</span>
            <div class="freelancer-card-img">
                <div class="hero">
                    <img src="../img/<?php echo $profile?>" alt="">
                </div>
              
              <form action="" method='POST' enctype="multipart/form-data">
                <input type="file" name="updateProfilePic" id="updateProfilePic">
                <button type='submit' name='updatePpic' id='updatePpic'>update profile picture</button>
              </form>
            </div>
           
            <div class="freelancer-card-info">
                <form action="" method="POST">
                    <section class="name">
                        <label for=""><span>Name </span> (First Name /  Middle Name / Last Name)</label><br>
                        <input type="text" name ="updatename" id="updatename" value="<?php echo $firstname ?>">
                        <input type="text" name="updatemiddlename" id ="updatemiddlename" value="<?php echo $middlename ?>">
                        <input type="text" name ="updatelastname" id ="updatelastname" value="<?php echo $lastname ?>">
                    </section>

                    <section>
                        <label for=""><span>Email:</span></label> 
                        <input type="email" name="updateEmail" id="updateEmail"value="<?php echo $email ?>"><br>

                        <label for=""><span>Contact / Gcash Number</span></label>
                        <input type="text" name="updateNumber" id="updateNumber" value="<?php echo $contact ?>">
                        <br>
                        <label for=""><span>Location:</span></label>
                        <?php echo $location?>
                    </section>
                    <section><span>Occupation:</span> <?php echo $role ?></section>
                        <label for=""><span>About me</span></label>
                        <textarea id="updateAbout" name="updateAbout" rows="6" cols="60" style="width: 427px; height: 87px; padding-inline:5px;" ><?php echo $about ?></textarea>
                    <button name="update" id="update">Save changes</button>
                </form>
                
            </div>
        </div>
    </div>
</div>   

    <script>
        document.getElementById('showFreelancerCard').addEventListener('click', function() {
            document.getElementById('freelancer-card-cont').classList.add('active');
        });
        
        document.querySelectorAll('#closeCard').forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            document.querySelectorAll('#freelancer-card-cont').forEach(function(card) {
                card.classList.remove('active');
            });
    });
});
        
    </script>