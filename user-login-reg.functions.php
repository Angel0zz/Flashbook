<?php

//google login
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo=[
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];

  $sql = "SELECT * FROM tb_clientusers WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($con,$sql);

  if(mysqli_num_rows($result) > 0){
    $userdata = mysqli_fetch_assoc($result);
        
    $_SESSION['valid'] = $userdata['email'];
    $_SESSION['id'] = $userdata['id'];
    $_SESSION['UchatId'] = $userdata['UchatId'];

    header("Location: index.php?success=login Successfully. Please wait ");
    exit();
  }
    else{
    $chatID = rand(100000, 999999);
    $sql = "INSERT INTO `tb_clientusers` (`email`, `first_name`, `last_name`, `gender`, `full_name`, `picture`, `verifiedEmail`, `token`,`UchatId`) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}' , '$chatID ')";

    $result = mysqli_query($con, $sql);
    if($result){
        header("Location: index.php?registerSuccess=Registered Successfully. You can now Login");
        exit();
    }else{
        header("Location: index.php?error=something went wrong . Please try again.");
        exit();
    }
  }


}
function handleLogin($con, $email, $password) {
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);


    $query = "SELECT * FROM tb_clientusers WHERE email='$email'";
    $result = mysqli_query($con, $query);


    if (!$result) {
        die("Select Error: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    if (is_array($row) && !empty($row)) {
        if (password_verify($password, $row['password'])) {

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['valid'] = $row['email'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['UchatId'] = $row['UchatId'];

            header("Location: index.php?success=login Successfully. Please wait ");
            exit();
        } else {
            header("Location: index.php?error=Wrong password. Please try again.");
            exit();
        }
    } else {
        header("Location: index.php?error=User Not Found. Please try again or Register First.");
        exit();
    }
}

if (isset($_POST['login'])) {

    handleLogin($con, $_POST['email'], $_POST['password']);
}



function registerUser($con,$firstName,$lastName, $email, $number, $areaCode, $password, $Confirmpassword) {
    $firstName = mysqli_real_escape_string($con, $firstName);
    $lastName = mysqli_real_escape_string($con, $lastName);
    $email = mysqli_real_escape_string($con, $email);
    $number = mysqli_real_escape_string($con, $number);
    $areaCode = mysqli_real_escape_string($con, $areaCode);
    $Fullnum = mysqli_real_escape_string($con, $areaCode . $number);
    $password = mysqli_real_escape_string($con, $password);
    $Confirmpassword = mysqli_real_escape_string($con, $Confirmpassword);
    

    $verify_query = mysqli_query($con, "SELECT email FROM tb_clientusers WHERE email='$email'");

    if (mysqli_num_rows($verify_query) > 0) {
        header("Location: index.php?error=Email already used. Please use another one.");
        exit();
    } elseif (empty($email) || empty($number) || empty($password) || empty($Confirmpassword)) {
        header("Location: index.php?error=Please fill up all input fields.");
        exit();
    } elseif (strlen($password) < 8) {
        header("Location: index.php?error=Password must be at least 8 characters long.");
        exit();
    } elseif ($password !== $Confirmpassword) {
        header("Location: index.php?error=Passwords do not match.");
        exit();
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $chatID = rand(100000, 999999);

        $insert_query = "INSERT INTO tb_clientusers (first_name,last_name,email, Client_number, password, UchatId) VALUES ('$firstName','$lastName','$email', '$Fullnum', '$hashedPassword','$chatID')";
        $resultreg = mysqli_query($con, $insert_query);

        if (!$resultreg) {
            die("Error: " . mysqli_error($con));
        }

        header("Location: index.php?registerSuccess=Registered Successfully. You can now Login");
        exit();
    }
}
if (isset($_POST['signUp'])) {
    registerUser(
        $con,
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['number'],
        $_POST['areaCode'],
        $_POST['passwordreg'],
        $_POST['Confirmpassword']
    );
}

$GSignup = $client->createAuthUrl();