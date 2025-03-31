<?php 
include('./php/cannection.index.php');
session_start();
include('user-login-reg.functions.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/pploginstyle.css">
    <link rel="icon" href="./assets/logo2.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="./Jscript/burger.js"></script>
    <script src="./Jscript/animationsScriptHome.js"></script>
    <title>Flashbook</title>
</head>
<body>  
    <!--Navigation bar-->
    <nav>
        <section>
            <a href="#nav"><img src="./assets/logo2.png" alt=""></a>
        </section>
        <div class="menu" >
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <section class="links">
            <section class="nav-menu">
            <a href="#About">About Us</a>
            <a href="#faq">FAQ</a>
             <Button  onclick="Login()">Login</Button>
            </section>
        </section> 
    </nav>

   
    <!-- End of Navigation bar-->
    <?php
    if (isset($_GET['success'])) {
        $msg = $_GET['success'];
        echo "
    <div class='successContainer' id='successContainer' >
     <section>
            <img src='./assets/footer-logo.png' alt=''> <button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
        <p>$msg</p>
        <script>
        setTimeout(function() {
            window.location.href = './userpages/';
        }, 3000); // Wait for 2 seconds
    </script>
    </div>
    ";
      }else  if (isset($_GET['error'])) {
        $msg = $_GET['error'];
        echo "
        <div class='errorContainer' id='errorContainer'>
            <section>
                    <img src='./assets/footer-logo.png' alt=''> <button onclick='closeSuccess()' class='closeError'>&times;</button>
                </section>
                <p>$msg</p>
            </div>
        ";

    } else  if (isset($_GET['registerSuccess'])) {
        $msg = $_GET['registerSuccess'];
        echo "
        <div class='successContainer' id='successContainer' >
        <section>
            <img src='./assets/footer-logo.png' alt=''> <button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
             <p>$msg</p>
    
        </div>
        ";

    } 

?>
     <main>
        <div class="FContainer">
 
            <section class="txtCont">
                <p ><span >Book your Photographer with ease,</span>  <span style ="color:#99CCFF; font-size:200%;">Cherish Moments Forever.</span></p>
                <p>Flashbook makes it easier than ever to book your photographer or Videographer, capture The Important Moments of your life. choose and book your prefered Photographers/ videographers with us! </p> 
            </section>
            <section class="imgCont">

                <div class="wrapper">
                    <div class="itemLeft item1"><img src="./design-assets/kosuni1.png" alt=""></div>
                    <div class="itemLeft item2"><img src="./design-assets/kosuni2.jpg" alt=""></div>
                    <div class="itemLeft item3"><img src="./design-assets/kosuni4.jpg" alt=""></div>
                    <div class="itemLeft item4"><img src="./design-assets/kosuni3.JPG" alt=""></div>
                    <div class="itemLeft item5"><img src="./design-assets/kosuni5.jpg" alt=""></div>
                    <div class="itemLeft item6"><img src="./design-assets/kosuni6.jpg" alt=""></div>
                    <div class="itemLeft item7"><img src="./design-assets/ObraNiJuanImg25.png" alt=""></div>
                    <div class="itemLeft item8"><img src="./design-assets/ObraNiJuanImg27.png" alt=""></div>
                </div>
                  <div class="wrapper">
                    <div class="itemRight item1"><img src="./design-assets/ObraNiJuanImg17.png" alt=""></div>
                    <div class="itemRight item2"><img src="./design-assets/ObraNiJuanImg18.png" alt=""></div>
                    <div class="itemRight item3"><img src="./design-assets/ObraNiJuanImg19.png" alt=""></div>
                    <div class="itemRight item4"><img src="./design-assets/ObraNiJuanImg20.png" alt=""></div>
                    <div class="itemRight item5"><img src="./design-assets/ObraNiJuanImg21.png" alt=""></div>
                    <div class="itemRight item6"><img src="./design-assets/ObraNiJuanImg22.png" alt=""></div>
                    <div class="itemRight item7"><img src="./design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemRight item8"><img src="./design-assets/ObraNiJuanImg7.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemLeft item1"><img src="./design-assets/ObraNiJuanImg1.png" alt=""></div>
                    <div class="itemLeft item2"><img src="./design-assets/ObraNiJuanImg3.png" alt=""></div>
                    <div class="itemLeft item3"><img src="./design-assets/ObraNiJuanImg4.png" alt=""></div>
                    <div class="itemLeft item4"><img src="./design-assets/ObraNiJuanImg2.png" alt=""></div>
                    <div class="itemLeft item5"><img src="./design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemLeft item6"><img src="./design-assets/ObraNiJuanImg6.png" alt=""></div>
                    <div class="itemLeft item7"><img src="./design-assets/ObraNiJuanImg7.png" alt=""></div>
                    <div class="itemLeft item8"><img src="./design-assets/ObraNiJuanImg8.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemRight item1"><img src="./design-assets/ObraNiJuanImg17.png" alt=""></div>
                    <div class="itemRight item2"><img src="./design-assets/ObraNiJuanImg18.png" alt=""></div>
                    <div class="itemRight item3"><img src="./design-assets/ObraNiJuanImg19.png" alt=""></div>
                    <div class="itemRight item4"><img src="./design-assets/ObraNiJuanImg20.png" alt=""></div>
                    <div class="itemRight item5"><img src="./design-assets/ObraNiJuanImg21.png" alt=""></div>
                    <div class="itemRight item6"><img src="./design-assets/ObraNiJuanImg22.png" alt=""></div>
                    <div class="itemRight item7"><img src="./design-assets/ObraNiJuanImg5.png" alt=""></div>
                    <div class="itemRight item8"><img src="./design-assets/ObraNiJuanImg7.png" alt=""></div>
                  </div>
                  <div class="wrapper">
                    <div class="itemLeft item1"><img src="./design-assets/ObraNiJuanImg10.png" alt=""></div>
                    <div class="itemLeft item2"><img src="./design-assets/ObraNiJuanImg9.png" alt=""></div>
                    <div class="itemLeft item3"><img src="./design-assets/ObraNiJuanImg11.png" alt=""></div>
                    <div class="itemLeft item4"><img src="./design-assets/ObraNiJuanImg12.png" alt=""></div>
                    <div class="itemLeft item5"><img src="./design-assets/ObraNiJuanImg13.png" alt=""></div>
                    <div class="itemLeft item6"><img src="./design-assets/ObraNiJuanImg14.png" alt=""></div>
                    <div class="itemLeft item7"><img src="./design-assets/ObraNiJuanImg15.png" alt=""></div>
                    <div class="itemLeft item8"><img src="./design-assets/ObraNiJuanImg16.png" alt=""></div>
                  </div>
            </section>
        </div>


        <div class="Preview-Container">
        <?php
            $vid_album = "
                SELECT v.*, f.fname 
                FROM tb_videos v 
                JOIN tb_freelancers f ON v.freelancerID = f.id"; 
    
            $vid_album_run = mysqli_query($con, $vid_album);
            if (mysqli_num_rows($vid_album_run) > 0) {
                $videos = [];
                while ($video = mysqli_fetch_assoc($vid_album_run)) {
                    $videos[] = $video;
                }
    
                shuffle($videos);
    
                $main_video = $videos[0]; 
                ?>
            <section class="vidCont">
                <video src="./uploads/<?=$main_video['video']?>" class="slider" autoplay controls muted></video>
                <p>Captured by: <?=$main_video['fname']?></p>
            </section>
            <?php
        }
        ?>


            <section class="txtCont">
                <p class="head">Hire a Local <span>Freelancers</span> , Anywhere in the <span>Philippines!</span></p>
                <p class="content">Capture stunning moments through photography and videography. Whether you’re planning a wedding, an event, or a promotional shoot, you can connect with talented professionals who know the best locations and have an eye for detail. 
                    Enjoy personalized service and unique perspectives that highlight the beauty of your special moments while supporting local creatives in the thriving Filipino photography and videography scene!</p>
            </section>
        </div>

        <div class="SContainer">
            <h1 id="howItWorksHeading">How it Works</h1>
            <div class="HowtoContainer">
            
              <section class="steps-part-one">
                <ul>
                  <li>
                    <div> <i class="fa-regular fa-calendar-check"></i></div>
                    <div><span>1.Browse and Select Freelancer for your Shoot</span><p>Find a Freelancer in your Chosen Destination, Check their availability</p></div>
                  </li>
                  <li>
                    <div> <i class="fa-regular fa-bookmark"></i></div>
                    <div><span>2.Select a Freelancer , Request Your Date and Book your Shoot
                    </span><p>whithin 24-48 hours, you'll be notified if your Photographer or videographer accepted your Booking request. if not, we can help you fine another. Once accepted , you can pay the Downpayment for Security fee and Officially Confirm your booking and Reserve you Shoot</p>
                    </div>
                  </li>
                </ul>
              </section>
              <section class="steps-part-two">
                <ul>
                  <li>
                    <div><i class="fa-sharp fa-solid fa-camera"></i></div>
                    <div><span>3.Photo Shoot Day!</span><p>Meet up with your Photographer or Videographer and then it's all about having fun on you session!</p>
                    </div>
                  </li>
                  <li>
                    <div><i class="fa-regular fa-folder-open"></i></div>
                    <div><span>4.Recieve Your Photos</span><p>Within five days after your shoot, you will receive your beautiful gallery in your Email. </p>
                    </div>
                  </li>
                </ul>
              </section>
            
            </div>
            <div class="wrapper">
                <div class="itemLeft item1"><img src="./design-assets/kosuni1.png" alt=""></div>
                <div class="itemLeft item2"><img src="./design-assets/kosuni2.jpg" alt=""></div>
                <div class="itemLeft item3"><img src="./design-assets/kosuni4.jpg" alt=""></div>
                <div class="itemLeft item4"><img src="./design-assets/kosuni3.JPG" alt=""></div>
                <div class="itemLeft item5"><img src="./design-assets/kosuni5.jpg" alt=""></div>
                <div class="itemLeft item6"><img src="./design-assets/kosuni6.jpg" alt=""></div>
                <div class="itemLeft item7"><img src="./design-assets/ObraNiJuanImg25.png" alt=""></div>
                <div class="itemLeft item8"><img src="./design-assets/ObraNiJuanImg27.png" alt=""></div>
            </div>
        </div>
            <div class='aboutAnchor' id="About"></div>

        <div class="AboutUsContainer" >
                <section class="head">
                  <span style="font-size:25px;font-weight: 400; color:#80B3FF;">About Us</span>
                  <p>FlashBook, a centralized cloud-based booking system with portfolio customization for photographers and videographers.
                  FlashBook is here to give you a seamless booking system and to search your chosen professionals.</p>
                </section>
                <section class="body">
                  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 
                  <dotlottie-player class="lottie" src="https://lottie.host/6d51a7e3-bf89-4ef2-ad9a-cc285d3c7559/HWgIrIPKNm.json" 
                  background="transparent" speed="1" style="width: 120%; height: 120%; position: relative; right: 20%;" loop autoplay></dotlottie-player>    
                </section>
        </div>
        
        <div class="FaqContainer" id="faq">
            <section class="head">
              <dotlottie-player src="https://lottie.host/c1f39f30-cde8-48d4-8cf0-c848b6849099/wUrFxLqJB2.json"
               background="transparent" speed="1" style="width: 120%; height: 120%;position: relative; top: -20%; left:-5%;" loop autoplay></dotlottie-player>
              </section>
            <section class="body">
              
              <div class="faq-section">
                <span style="font-size:25px;font-weight: 400; color:#437fbb;">Frequently Asked Questions</span>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        What is Flashbook?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Flashbook is a centralized cloud-based booking system that you can use to book professionals and see their works from our website.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        How to book professionals?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Just pick what kind of professional you need, review their profile and portfolio, and choose the events you need them for. Each place has professionals available for you.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        How to make payment on your website?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">When the professional accepts your booking, you will be notified by the admin and the professional. You need to pay 50% as a down payment, and the remaining balance should be given to the professional you booked.</div>
                </div>
                <div class="faq" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        Is there any penalty for rescheduling or cancelling?
                        <span class="dropdown-arrow">▼</span>
                    </div>
                    <div class="faq-answer">Rescheduling the event has no penalty, but if you cancel the booking, there is no refund on your first payment.</div>
                </div>
              </div> 
            </section>
        </div>   

    </main>
  
<div class="Login-modal-container">
    <div class="frm-container">
      <div class="close-btn" onclick="closeLogin()">&times;</div>

             <div class="form login-form active">
                <form action="" method="POST">
                    <div class="googleCont"><h2> Login as Client</h2></div>
     
                    <div class="inputBox">
                        <label>Email</label>
                        <input type="email" name="email" id="email" autocomplete ="off" placeholder="Email" required>
                    </div>
                    <div class="inputBox">
                        <label>Password</label>
                        <input type="password" name="password" id="password" autocomplete ="off" placeholder="password" required>
                    </div>

                    <div class="loginLinks">
                        <section><a href="./Freelancers">Login as Freelancer</a></section>
                        <section><a href="./Admin">Login as Admin</a></section>
                    </div>
                    <button type="submit" name="login"> Login</button>
                    <div class="googleCont">
                        Don't have an Account yet?
                        <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                        

                        <div style ='display:flex; justify-content:space-between;'>
                        <section class ='forgetPassCont' onclick=Forgetpassword()>Forget Password</section>
                        <section><span onclick="Signup()" style="color:#8b49f5;  cursor:pointer;"> Signup As Client</span></section>
                    

                        </div>
                    </div>  
                </form>
                
            </div>      


            <div class="form signup-form">
              <form action="#" method="POST" onsubmit="return validatePasswords() && validateForm();">
                    <div class="googleCont"><h2> Signup as Client</h2></div>
                    <div class="inputBox" >
                    <label for="">Name (First Name | Last Name)</label>
                      <section style='display:flex; gap:10px;'>
                      <input type="text" name="first_name" id="first_name" autocomplete ="off" placeholder="Fist Name" required >
                      <input type="text" name="last_name" id="last_name" autocomplete ="off" placeholder="Last Name" required >
                      </section>

                    </div>
                    <div class="inputBox">
                    <label for="">Email</label>
                        <input type="text" name="email" id="email" autocomplete ="off" placeholder="Email" required >
                    </div>

                    <label >Contact Number</label>
                    <div class="inputBox" style="display:flex; align-items:center;">
                          <input type="text" name="areaCode_display" id="areaCode" style="padding:0; width:30px;" value="+63" readonly disabled>
                          <input type="hidden" name="areaCode" value="+63" readonly>
                          <input type="text" name="number" id="number" oninput="limitInput(this)" maxlength="10"   required >
                    </div>
                        
                    <div class="inputBox">
                    <label for="">Password</label>
                        <input type="password" name="passwordreg" id="passwordreg" autocomplete ="off" placeholder=" password" required>
                    </div>   

                    <div class="inputBox">
                    <label for="">Confirm Password</label>
                      <input type="password" name="Confirmpassword" id="checkPassword" autocomplete ="off" placeholder=" Confirm password" required>
       
                    </div> 

                    <div>
                      <input type="checkbox" id="terms" name="terms" required>
                      <label for="terms">I have read and agree to the <a href="#" onclick="openModal()">Terms and Conditions</a></label>
                    </div>

                    <span id="error-message" style="color: red; font-size: 12px; display: none;">Passwords do not match</span>  
                        
                    <div class="googleCont">
                        <button type="submit" name="signUp"> Submit</button>
                        
                    </div>
      
                    <div class  ="googleCont">
                      already have an account?
                      <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                      <div style ='display:flex; justify-content:space-between;'>
                        <section class ='forgetPassCont' onclick=Forgetpassword()>Forget Password</section><section>  <span onclick="Login()" style="color:#8b49f5;  cursor:pointer;">Login as Client </span></section>
                      </div>
                    
                    </div>
                </form>
  
            </div>


            <div class="form Forget-password-form ">
                <form action="./php/send-password-reset.php" method="POST">
                    <div class="googleCont"><h2> Forget Password</h2></div>
     
                    <div class="inputBox">
                        <label>Email</label>
                        <input type="email" name="Forgetemail" id="Forgetemail" autocomplete ="off" placeholder="Email" required>
                    </div><br>
                    <button type="submit" name="forgetPass"> submit</button>
                    <div class="googleCont">
                        <a href="<?=$GSignup?>"><img src="./assets/google.png" alt=""></a>
                        already have an account?<span onclick="Login()"  style="color:#8b49f5;  cursor:pointer;"> Login as Client</span>
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
</script>
 <!--Footer-->
 <footer>
<div>
    <img src="./assets/logo2.png" alt="">

</div>
<p>2024 © All rights reserved,FlashBook</p>

</footer>

<!--End of Footer-->

<script>
      /*FAQ js function dropdown*/
   

    const loginModal =  document.querySelector('.Login-modal-container');
    const loginFrm = document.querySelector(' .login-form');
    const signupFrm = document.querySelector('.signup-form');
    const Forgetpasswordfrm = document.querySelector('.Forget-password-form');
    
    function Login(){
      loginModal.style.display='flex'; 
      loginFrm.classList.add("active");
      signupFrm.classList.remove("active");
      
      Forgetpasswordfrm.classList.remove('active');
    }
     function closeLogin(){
      loginModal.style.display='none'; 
     }
    function Signup(){
      loginFrm.classList.remove("active");
      signupFrm.classList.add("active");
      
      Forgetpasswordfrm.classList.remove('active');
    }
    function Forgetpassword(){
        Forgetpasswordfrm.classList.add('active');
        loginFrm.classList.remove("active");
      signupFrm.classList.remove("active");
    }
    function closeError() {
        document.getElementById('errorContainer').style.display = 'none';
    }
    function closeSuccess() {
        document.getElementById('successContainer').style.display = 'none';
    }
    
    function initValue() {
        const numberInput = document.getElementById('number');
        if (numberInput.value === "+63") {
            numberInput.value = "+63 ";
        }
    }

    function restrictInput() {
        const numberInput = document.getElementById('number');
        if (!numberInput.value.startsWith("+63 ")) {
            numberInput.value = "+63 ";
        }
        numberInput.value = numberInput.value.replace(/(\+63 )\D+/g, "$1");
    }
    </script>
</body>
</html>

