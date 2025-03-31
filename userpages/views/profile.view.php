<?php include('./views/partials/head.php')?>
    <?php include('./views/partials/nav.php')?>

<main>
    <div class="userProfileContainer">
        <div class="userProfileCard">
                <span>My Profile</span>

            <div class="Fcont">
                <div class="imgCont">
                    <img id="profile-pic" src="../img/<?php echo $UserProfilepic; ?>" alt="">
                </div>
            </div>
            <div class="Scont">
                <form action="../php/updateClientProfile.php" method='POST' enctype="multipart/form-data"  onsubmit="return validatePasswords()";>
                    <div>
                        <label for="file-upload" class="custom-label">Change Profile Picture</label>
                        <input name='updateProfilePic' id="file-upload" type="file" style="display: none;" accept="image/*">
                    </div>
                    <div style='display:flex;gap:80px;font-size:10px; text-align:left;  '> 
                    <span>First Name</span> <span>Middle Name</span>
                    <span>Last Name</span>
                    </div>
                    <div>

                        <input type="text" name='updateFirstName' value='<?php echo $UserFname; ?>'>
                        <input type="text" name="updateMiddleName" id="" value='<?php echo $UserMname; ?>'>
                        <input type="text" name="updateLastName" id="" value='<?php echo $UserLname; ?>'>
                    </div>
                    <div style='display:flex;gap:115px; font-size:10px; text-align:right; '> 

                        <span>Contact Number</span> 


                        <span> Email Address</span>

                    
                    </div>
                    <div>
                        <input type="number" name='updateContactDetail'oninput="limitInput(this)" maxlength="10" value='<?php echo $UserContact; ?>' placeholder='Contact Number'>
                        <input type="text" name="updateEmail" id="" value='<?php echo $email; ?>' disabled>
                    </div>
                    <span style='font-size:10px; margin:0;'>Change password</span>
                    <div>
                        
                        <input type="password" name="UpdatePassword" id="UpdatePassword" placeholder='New Password'  >
                    </div>
                    <div>
                        <input type="password" name="UpdatePasswordConfirmation" id="UpdatePasswordConfirmation"  placeholder='Confirm New Password' >
                    </div>
                    <span id="error-message" style="color: red; font-size: 12px; display: none;">Passwords do not match</span>  
                    <div>
                         <button type="submit" name="submit" value="save">Save Changes</button>
                    </div>

                    <div>
                        <button class ='deleteAccButton' type="submit" name="submit" value="delete">Delete Account</button>
                    </div>

                </form>

               
            </div>
            
        </div>

    </div>
</main>

<script>
    const fileInput = document.getElementById('file-upload');
    const profilePic = document.getElementById('profile-pic');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePic.src = e.target.result; 
            };
            reader.readAsDataURL(file); 
        }
    });
</script>

<script>
     const passwordInput = document.getElementById('UpdatePassword');
    const checkPasswordInput = document.getElementById('UpdatePasswordConfirmation');
    const errorMessage = document.getElementById('error-message');

    function validatePasswords() {
        if (passwordInput.value !== checkPasswordInput.value) {
            checkPasswordInput.classList.add('mismatch'); // Add mismatch class for styling
            errorMessage.style.display = 'inline'; // Show error message
            return false; // Prevent form submission
        }
        checkPasswordInput.classList.remove('mismatch'); // Remove mismatch class
        errorMessage.style.display = 'none'; // Hide error message
        return true; // Allow form submission
        
      }
      function limitInput(input) {
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
    if (input.value < 9) {
        input.value = 9;
    }
}

  passwordInput.addEventListener('input', validatePasswords);
  checkPasswordInput.addEventListener('input', validatePasswords);
 
</script>

<?php include('./views/partials/footer.php')?>