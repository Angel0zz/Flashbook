<?php
include('../php/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize input
    session_start();

    $adminEmail = mysqli_real_escape_string($con, $_POST['Addemail']);
    $adminPassword = mysqli_real_escape_string($con, $_POST['Addpassword']);
    $passKey = mysqli_real_escape_string($con, $_POST['passKey']);

    if (!isset($_SESSION['adminEmail'])) {
        
        echo "<script>alert('Session expired. Please log in again.'); window.location.href='login.php';</script>";
        exit();
    }

    $currentAdminEmail = $_SESSION['adminEmail'];
    $passKeyQuery = "SELECT adminKey FROM tb_admin WHERE adminEmail = '$currentAdminEmail'";
    $passKeyResult = mysqli_query($con, $passKeyQuery);

    if (!$passKeyResult || mysqli_num_rows($passKeyResult) == 0) {
        echo "<script>alert('Admin not found. Please log in again.'); window.location.href='login.php';</script>";
        exit();
    }

    $row = mysqli_fetch_assoc($passKeyResult);
    $storedPassKey = $row['adminKey']; 

    // Validate the passKey
    if ($passKey !== $storedPassKey) {
        header("Location: ../Admin/admin_admins_module.php?error=Wrong Admin Key.");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM tb_admin WHERE adminEmail = '$adminEmail'";
    $result = mysqli_query($con, $checkEmailQuery);

    if (!$result) {
        header("Location: ../Admin/admin_admins_module.php?error=checking email. Please try again.");
        exit();
    }

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../Admin/admin_admins_module.php?error= Email already exists. Please use a different email.");
        exit();
    }

    // Insert new admin into tb_admin
    $insertQuery = "INSERT INTO tb_admin (adminEmail, adminPassword, role) VALUES ('$adminEmail', '$hashedPassword', 'admin')";
    
    if (mysqli_query($con, $insertQuery)) {
        header("Location: ../Admin/admin_admins_module.php?success=new admin added.");
    } else {
        header("Location: ../Admin/admin_admins_module.php?error=Something went Wrong.");
    }
}
?>
