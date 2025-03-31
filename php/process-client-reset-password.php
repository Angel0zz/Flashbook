<?php


$token = $_POST['token'];

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

if(strlen($_POST['password'])< 8){
    die("PASSWORD must be atleast 8 characters");
}
if(!preg_match('/[a-z]/i',$_POST['password'])){
    die('PASSWORD must contain atleast one number');
}
$password_hash = password_hash($_POST['password'],PASSWORD_DEFAULT);

$sql = 'UPDATE tb_clientusers 
        SET password = ?,
            reset_token_hash =NULL,
            reset_token_expire_at = NULL
            where id =?';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password,$user['id']);
$stmt->execute();

header("Location: ../index.php?success=Passwords Reset Successfully you can now login.");
