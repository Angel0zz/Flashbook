const loginFrm = document.querySelector(' .login-form');
    const signupFrm = document.querySelector('.signup-form');
    const Forgetpasswordfrm = document.querySelector('.Forget-password-form');

    function Login(){

        loginFrm.classList.add("active");
        signupFrm.classList.remove("active");

        Forgetpasswordfrm.classList.remove('active');
        document.querySelector('.frm-container').style.maxWidth = '320px';
      }

      function Signup(){
        loginFrm.classList.remove("active");
        signupFrm.classList.add("active");
        
        Forgetpasswordfrm.classList.remove('active');
        document.querySelector('.frm-container').style.maxWidth = '780px';
      }

      //check password
      function Forgetpassword(){
        Forgetpasswordfrm.classList.add('active');
        loginFrm.classList.remove("active");
      signupFrm.classList.remove("active");
    }
