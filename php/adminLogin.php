<?php
include('../php/connection.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Ensure to select the role along with email and password
$verify_query = mysqli_query($con, "SELECT adminID, adminEmail, adminPassword, role FROM tb_admin WHERE adminEmail ='$email'");

if (mysqli_num_rows($verify_query) == 0) {
    echo "<script>alert('You are not an admin');</script>";
} else {
    $row = mysqli_fetch_assoc($verify_query);
    $hashed_password = $row['adminPassword'];

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['adminEmail'] = $email;  // Store email in session
        $_SESSION['role'] = $row['role']; 
        $_SESSION['adminID'] = $row['adminID']; // Store role in session
        header("Location: ../Admin/admin_dashboard.php?success=login successfully.");
    } else {
        echo "<script>alert('Incorrect password. Please try again.'); history.back();</script>";
    }
}
?>
