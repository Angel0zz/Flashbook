<?php
include('../php/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();

    $ClientId = mysqli_real_escape_string($con, $_POST['id']);
    $ClientNewEmail = mysqli_real_escape_string($con, $_POST['Newemail']);
    $CLientNewFname =mysqli_real_escape_string($con, $_POST['Newfirst_name']);
    $ClientNewLname =mysqli_real_escape_string($con, $_POST['Newlast_name']);
    $ClientNewContactNum =mysqli_real_escape_string($con, $_POST['Newcontact_number']);
    $ClientNewPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
    $adminKey = mysqli_real_escape_string($con, $_POST['adminKey']);

    if(!isset($_SESSION['adminEmail'])){
        echo "<script>alert('Session expired. Please log in again.'); window.location.href='login.php';</script>";
        exit();
    }

    $Admin = $_SESSION['adminEmail'];
    $passKeyQuery = "SELECT adminKey FROM tb_admin WHERE adminEmail = '$Admin'";
    $passKeyResult = mysqli_query($con, $passKeyQuery);

    if (!$passKeyResult || mysqli_num_rows($passKeyResult) == 0) {
        echo "<script>alert('Admin not found. Please log in again.'); window.location.href='login.php';</script>";
        exit();
    }
    
    $row = mysqli_fetch_assoc($passKeyResult);
    $storedPassKey = $row['adminKey']; 

    // Validate the passKey
    if ($adminKey !== $storedPassKey) {
        header("Location: ../Admin/admin_user_module.php?error=Wrong Admin Key.");
        exit();
    }

    $hashedPassword = password_hash($ClientNewPassword, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE tb_clientusers 
    SET email = '$ClientNewEmail', 
        first_name = '$CLientNewFname', 
        last_name = '$ClientNewLname', 
        Client_number = '$ClientNewContactNum', 
        password = '$hashedPassword' 
    WHERE id = '$ClientId'";

if (mysqli_query($con, $updateQuery)) {
    header("Location: ../Admin/admin_user_module.php?success=user details updated.");
} else {
    header("Location: ../Admin/admin_user_module.php?error=Something went Wrong.");
}
}