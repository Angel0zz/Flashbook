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

    //limit the contact number input 
    
    function initValue() {
        const numberInput = document.getElementById('number');
        // If the input value does not start with "+63 ", initialize it
        if (numberInput.value === "+63") {
            numberInput.value = "+63 "; // Add the space after +63
        }
    }

    function restrictInput() {
        const numberInput = document.getElementById('number');
        // Ensure that the input always starts with "+63 " and only allows numbers after it
        if (!numberInput.value.startsWith("+63 ")) {
            numberInput.value = "+63 ";
        }
        // Remove any non-numeric characters after "+63 "
        numberInput.value = numberInput.value.replace(/(\+63 )\D+/g, "$1");
    }
    </script>
</body>
</html>