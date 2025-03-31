<?php
   include("../php/connection.php");
   session_start();
   include("./regfunct.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Fstyles/freelancer-style.css">
    <Link rel="stylesheet" href="./Fstyles/pploginstyle.css">
    <link rel="icon" href="../assets/logo2.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Flashbook | Freelancers</title>
</head>
<body>

<nav >
        <section>
            <a href="./"><img src="../assets/logo2.png" alt=""></a>
        </section>
        <div class="menu" >
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <section class="links">
            <button>login</button>
        
        </section> 
</nav>

<?php
    if (isset($_GET['success'])) {
        $msg = $_GET['success'];
        echo "
    <div class='successContainer' id='successContainer' >
        <p>$msg</p>
        <button onclick='closeSuccess()' class='closeError' >&times</button>
    </div>
    ";
      }else  if (isset($_GET['error'])) {
        $msg = $_GET['error'];
        echo "
        <div class='errorContainer' id='errorContainer' >
             <p>$msg</p>
            <button onclick='closeError()' class='closeError' >&times</button>
        </div>
        ";

    } 
?>

<?php
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = $_POST['password'];


        $result = mysqli_query($con, "SELECT * FROM tb_freelancers WHERE Freelancer_email='$email'") or die("Select Error");
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['Freelancer_email'] = $row['Freelancer_email']; 
            $_SESSION['id'] = $row['id']; 
            $_SESSION['valid'] = true;
            $_SESSION['FchatId'] = $row['FchatId']; 
            header("Location: ./myportfolio.php"); 
            exit(); 
        } else {

            echo "<script> alert('Invalid user or password'); </script>";
        }
    }
?>
    <main>

<div class="Container">
    <div class="frm-container">
      <div class="close-btn" onclick="closeLogin()">&times;</div>

             <div class="form login-form active">
                <form action="../php/freelancer-registration-login.php" method="POST">
                    <div class="googleCont"><h2>Freelancer LogIn</h2></div>
     
                    <div class="inputBox">
                        <label>Email</label>
                        <input type="email" name="email" id="email" autocomplete ="off" placeholder="Email" required>
                    </div>
                    <div class="inputBox">
                        <label>Password</label>
                        <input type="password" name="password" id="password" autocomplete ="off" placeholder="password" required>
                    </div><br>
                    <button type="submit" name="login" value='login'> Login</button>
                    <div class="googleCont">
                        Wan't to be a Freelancer? 
                        <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                        

                        <div style ='display:flex; justify-content:space-between;'>
                        <section class ='forgetPassCont' onclick=Forgetpassword()>Forget Password</section>
                        <section><span onclick="Signup()" style="color:#8b49f5;  cursor:pointer;"> Register As Freelancer</span></section>
                    

                        </div>
                    </div>  
                </form>
                
            </div>      


            <div class="form signup-form">
              <form action="../php/freelancer-registration-login.php" method="POST" onsubmit="return validatePasswords() && validateForm();"enctype="multipart/form-data">
                    <div class="googleCont"><h2>Join and Become a Freelancer!</h2>
                    <p>"Join our team and showcase your talents."</p></div><br>
                    <div class="inputBox" >
                    <label for="">Name (First Name | Middle Name | Last Name)</label>
                      <section style='display:flex; gap:10px;'>
                        <input type="text" name="name" id="name"  autocomplete ="off" placeholder="First Name" required>

                        <input type="text" name="Mname" id="Mname"  autocomplete ="off" placeholder="Middle Name" required>

                        <input type="text" name="Lname" id="Lname"  autocomplete ="off" placeholder="Last Name" required>
                      </section>

                    </div>
                    <div class="inputBox" style='display:flex; gap:10px;'>
                        <div>
                            <label for="">Email</label>
                            <input type="text" name="Email" id="Email" autocomplete ="off" placeholder="Email" required >
                        </div>
                      
                        <div>
                            <section>
                            <label >Contact Number <span style='font-size:10px;color:#696969; line-height:110%;'>Note:This will serve as your Gcash Account Number</span> </label>
                            </section>
                            <div style="display:flex; align-items:center;">
                                <input type="text" name="areaCode_display" id="areaCode" style="padding:0; width:30px;" value="+63" readonly disabled>
                                <input type="hidden" name="areaCode" value="+63" readonly>
                                <input type="text" name="number" id="number" oninput="limitInput(this)" maxlength="10"   required >
                            </div>
                       
                        </div>
                          
                    </div>

                   
                        
                    <div class="inputBox">
                        <label >Role</label>
                        <Select name = "role" id ="role"> 
                            <option value="Photographer">Photographer</option>
                            <option value="Videographer"> Videographer</option>
                            <option value="Photographer / Videographer">Photographer / Videographer</option>
                        </Select>
                    </div>

                    <div class="inputBox" style ='display:flex;'>
                            <div>
                            <label > Select Region</label>
                                <select name="region" id="region" require >
                                    <option disabled selected >select Location</option>
                                    <?php  $sql = "SELECT * FROM region";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?php echo $row['region_name']; ?>"><?php echo $row['region_name']; ?></option>
                                    <?php } ?>
                    
                                </select>
                            </div>
                            <div> 
                                <label > Select Province</label>
                                <select name="province" id="province" require>
                                    <option  >select province</option>
                                </select>
                            </div>
                            <div>
                            <label > Select City</label>
                                <select name="city" id="city"require>
                                    <option >select city</option>
                                </select>
                            </div>
                        
                    </div>
                    
                    <div class="inputBox">
                        <label for="Link">Upload your sample portfolio Link here</label>
                        <input type="Link" name="Link" autocomplete ="off" placeholder="portfolio Link" required>
                    </div>


                    <div class="inputBox">
                     <label for="About_you">About you: 
                        <span style ='font-style:8px; color:#696969;'>*tell details About Yourself this will e display on you account </span>
                     </label>
                     <textarea id="about" name="about" style="height: 107px; width: 100%; padding-inline:5px; box-sizing: border-box;"></textarea> 
                     </div>
                    <div class="inputBox">
                        <label for="profile-picture">Upload profile picture</label>
                        <input type="file" name="profile" id="profile">
                    </div>
                    <div class="inputBox">
                        <label for="Id-picture">Upload valid id for verification</label>
                        <input type="file" name="image" id="image">
                    </div>


                    <div class="inputBox">
                    <label for="">Password</label>
                        <input type="password" name="passwordreg" id="passwordreg" autocomplete ="off" placeholder=" password" required>
                    </div>   

                    <div class="inputBox">
                    <label for="">Confirm Password</label>
                      <input type="password" name="Confirmpassword" id="checkPassword" autocomplete ="off" placeholder=" Confirm password" required>
                    </div> 
                     
                    <span id="error-message" style="color: red; font-size: 12px; display: none;">Passwords do not match</span>  
                        
                    <div>
                      <input type="checkbox" id="terms" name="terms" required>
                      <label for="terms">I have read and agree to the <a href="#" onclick="openModal()">Terms and Conditions</a></label>
                    </div>

                    <div class="googleCont">
                        <button type="submit" name="action" value='signUp'> Submit</button>
                        
                    </div>
      
                    <div class  ="googleCont">
                      already have an account?
                      <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                      <div style ='display:flex; justify-content:space-between;'>
                        <section class ='forgetPassCont' onclick=Forgetpassword()>Forget Password</section><section>  <span onclick="Login()" style="color:#8b49f5;  cursor:pointer;">Login as Freelancer </span></section>
                      </div>
                    
                    </div>
                </form>
  
            </div>


            <div class="form Forget-password-form ">
                <form action="../php/send-freelancer-password-reset.php" method="POST">
                    <div class="googleCont"><h2> Forget Password</h2></div>
     
                    <div class="inputBox">
                        <label>Email</label>
                        <input type="email" name="Forgetemail" id="Forgetemail" autocomplete ="off" placeholder="Email" required>
                    </div><br>
                    <button type="submit" name="forgetPass"> submit</button>
                    <div class="googleCont">
                        <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                        already have an account?<span onclick="Login()"  style="color:#8b49f5;  cursor:pointer;"> Login</span>
                    </div>  
                </form>
            </div>  


    </div>

</div>
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Terms and Conditions for Photography and Videography Services </h2>Effective Date: October 2024 
        <p>These Terms and Conditions govern the use of the “FLASHBOOK” website booking system by both Clients and Freelancers (photographers and/or videographers). By using this Website, all users agree to comply with and be bound by these Terms and Conditions. </p>
        <h4>1. Definitions </h4>
        <p>1.1. Client: A user who books photography or videography services through the Website</p>
        <p>1.2. Freelancers: A photographer and/or videographer offering their services via the Website. </p>
        <h4>2. Booking Process  </h4>
        <p>2.1. Clients can book services by selecting a Freelancers, package, service, date, and time through the Website. </p>
        <p>2.2. Upon booking confirmation, Clients must pay first a non-refundable deposit of 50% of the total service fee through the Website. </p>
        <p>2.3. And the remaining 50% of the service fee shall be paid directly to the Freelancers after the service is rendered. </p>
        <h4>3. Payment Terms </h4>
        <p>3.1. Payments can be made through the online payment methods provided on the Website. Including Gcash and Paymaya.  </p>
        <p>3.2. All payments are in Philippine Peso (PHP).</p>
        <p>3.3. Failure to pay the remaining balance on the service date may result in the Freelancers withholding services until payment is made. </p>
        <h4>4. Responsibilities of Clients </h4>
        <p>4.1. Clients must provide accurate booking information and details about the service required. </p>
        <p>4.2. Clients are responsible for ensuring that the Freelancers has access to the location where the service will take place. </p>
        <p>4.3. Clients must communicate any specific requirements or preferences in advance. </p>
        <h4>5. Responsibilities of Freelancers </h4>
        <p>5.1. Freelancers must deliver the services as agreed upon in the booking confirmation. </p>
        <p>5.2. Freelancers are responsible for their own equipment and ensuring they are adequately prepared for the service. </p>
        <p>5.3. Freelancers must maintain a professional standard and comply with all applicable laws and regulations while providing services. </p>
        <p>5.4. Freelancers are required to adhere to the designated service package as specified in the agreement. </p>
        <h4>6. Cancellation and Refund Policy </h4>
        <p>6.1. Cancellations must be made in writing via email and message through end-to-end messaging in the</p>
        <p>6.2. The 50% deposit is non-refundable upon cancellation. </p>
        <p>6.3. If a Client cancels less than 3 days before the scheduled service, they will be responsible for paying the full-service fee. </p>
        <h4>7. Liability </h4>
        <p>7.1. The “FLASHBOOK” serves as an intermediary between Clients and Freelancers and is not liable for any damages or losses incurred due to services rendered. </p>
        <p>7.2. Both Clients and Freelancers agree to indemnify and hold the Website harmless from any claims arising from their interactions. </p>
        <h4>8. Governing Law </h4>
        <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the Republic of the Philippines under Republic Act No. 7394 “THE CONSUMER ACT OF THE PHILIPPINES”, including but not limited to the Civil Code of the Philippines and applicable laws regarding contracts, obligations, and consumer rights. </p>
        <h4>9. Amendments </h4>
        <p>The Website reserves the right to amend these Terms and Conditions at any time. Any changes will take effect immediately upon posting on the Website. Continued use of the Website constitutes acceptance of the revised Terms and Conditions. </p>
        <h4>10. Contact Information </h4>
        <p>For inquiries or concerns regarding these Terms and Conditions, please contact us at: 

          Flashbook.2023@gmail.com </p>
        <div>
            <input type="checkbox" id="modalTerms" required>
            <label for="modalTerms">I have read and agree to the Terms and Conditions.</label>
        </div>
        <button onclick="closeModal()">Close</button>
    </div>
</div>
    </main>
    <script src="./js/popupfrm.js"></script>
          <script>
            const passwordInput = document.getElementById('passwordreg');
                const checkPasswordInput = document.getElementById('checkPassword');
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
                $(document).ready(function(){
                    $('#region').change(function(){
                        var regionId = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: '../php/fetchprovince.php',
                            data: { id: regionId },
                            success: function(data) {
                                $('#province').html(data);
                            },
                            error: function() {
                                alert('Error fetching provinces.');
                            }
                        });
                    });

                    $('#province').change(function(){
                        var provinceId = $(this).val();
                        $.ajax({
                            type: 'POST',
                            url: '../php/fetchcity.php',
                            data: { id: provinceId },
                            success: function(data) {
                                $('#city').html(data);
                            },
                            error: function() {
                                alert('Error fetching cities.');
                            }
                        });
                    });
                });



        //checking terms 
        function openModal() {
        document.getElementById('termsModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('termsModal').style.display = "none";
    }

    function validateForm() {
        const termsCheckbox = document.getElementById('terms');
        const modalTermsCheckbox = document.getElementById('modalTerms');
        if (!termsCheckbox.checked || !modalTermsCheckbox.checked) {
            alert('You must agree to the Terms and Conditions before signing up.');
            return false;
        }
        return true;
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('termsModal')) {
            closeModal();
        }
    }

    function closeError() {
    document.getElementById('errorContainer').style.display = 'none';
}
function closeSuccess() {
    document.getElementById('successContainer').style.display = 'none';
}
        </script>

<?php require('./views/partials/footer.php')?>