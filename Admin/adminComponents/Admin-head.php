
<?php
include("../php/connection.php");
session_start(); 

if (!isset($_SESSION['adminEmail'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}
if (isset($_SESSION['adminID'])) {
    $id = $_SESSION['adminID']; // Get the admin role from the session
} else {
    $id = 'ID not set'; // Debugging: fallback message
}

if (isset($_SESSION['role'])) {
    $adminRole = $_SESSION['role']; // Get the admin role from the session
} else {
    $adminRole = 'Role not set'; // Debugging: fallback message
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./adminCss/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo2.png" type="image/png">
    <title>Flashbook | Admin</title>
</head>
<body>
<nav>
        <section>
            <a href="#nav"><img src="../assets/logo2.png" alt=""></a>
        </section>
        <section class='role'>
        <a href="../php/FreelancerLogout.php"><button>Logout</button></a>

        </section>
    </nav>

    <?php
    if (isset($_GET['success'])) {
        $msg = $_GET['success'];
        echo "
    <div class='successContainer' id='successContainer'>
        <section>
            <img src='../assets/footer-logo.png' alt=''> <button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
    <p>$msg</p>

    </div>
    ";
      }else  if (isset($_GET['error'])) {
        $msg = $_GET['error'];
        echo "
        <div class='errorContainer' id='errorContainer'>
        <section>
            <img src='../assets/footer-logo.png' alt=''> <button onclick='closeSuccess()' class='closeError'>&times;</button>
        </section>
        <p>$msg</p>
        
    </div>
        ";

    } 
?>
