<?php

$token = $_GET['token'];

$token_hash = hash('sha256',$token);

$mysqli = require __DIR__ . "/connection.php";

$sql = "SELECT * FROM tb_clientusers WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result =$stmt->get_result();
$user = $result ->fetch_assoc();

if($user === null){
    die('token not found');
}

if(strtotime($user['reset_token_expire_at']) <= time()){
    die('token  hasnt Expired');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo2.png" type="image/png">
 <title>Flashbook | RESET PASSWORD</title>
</head>
<style>
    {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
        }
        html{
        scroll-behavior: smooth;
        }

        body{
            margin: 0;
            font-family:'Poppins', Times, serif;
            
        }
        button{
        padding: 9px 25px;
        background-color: #172141;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition:  all 0.3s ease;
        color: #fff;
        font-weight: 700;
        }
        /*navigation bar css */
        nav{
            position: sticky;
            z-index: 1000; 
            top: 0;
            background-color: #10182f;
            box-shadow: 3px 3px 5px rgba(172, 172, 172, 0.1);
            width: 100%;
            height: 3.5em;
            display: flex;
            justify-content: space-between;
        }
        nav section{
            margin-inline: 2em;
        }
        nav section img{
            position: absolute;
            height: 100%;
            width: 95px;
            object-fit: contain;
        }
        nav a{
            text-decoration: none;
            color: #fff;
            width: 130px;
            text-align: center;
            justify-content: center;
        }
        nav section a:hover{
        color: #b8f2e6;
        }
        nav section.links button{
        background-color: #c8e4f6;
        color: #10182f;
        }

        nav section.links{
            display: flex;
            align-items: center;
            height: 100%;
            justify-content: flex-end;
            margin: 0;

        } 
        section.nav-menu{
        margin: 0;
        }
        section.links  .nav-menu a{
            margin-right: 1em;
        }
    div{
        display:flex;
        flex-direction:column;
        width:250px;
        border:1px solid;
        padding:20px;
        margin:auto;
        margin-top:5em;
    }
    div form{
        display:flex;
        flex-direction:column;
        
    }
    div form input{

        font-size:30px;
    }
    div form button{
        margin-top:20px;
    }
</style>
<body>
<nav>
        <section>
            <a href="#nav"><img src="../assets/logo2.png" alt=""></a>
        </section>
       
    </nav>

    <div>
        <h3>Reset Password</h3>

        <form method="post" action="process-client-reset-password.php" onsubmit=validatePasswords()>

        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New password</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Repeat password</label>
        <span id="error-message" style="color: red; font-size: 12px; display: none;">Passwords do not match</span>  
                        
        <input type="password" id="password_confirmation"
            name="password_confirmation">

        <button>Send</button>
    </div>
<script>
    const passwordInput = document.getElementById('password');
    const checkPasswordInput = document.getElementById('password_confirmation');
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

    passwordInput.addEventListener('input', validatePasswords);
    checkPasswordInput.addEventListener('input', validatePasswords);
</script>
</form>
</body>
</html>


