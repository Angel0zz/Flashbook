<?php 
ob_start();
 include('./fetch.php');

   include("../php/connection.php");
   if(!isset($_SESSION['valid'])){
    header("Location:../index.php");
   }
   if (!isset($_SESSION['UchatId'])) {
    // Redirect to login or handle accordingly
    die("User Chat ID not set. Please log in.");
}

//photographer list 
 include('./UserFunctions.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/user-styles.css">
    <link rel="stylesheet" href="styles/freelancerProfile.css">
    <link rel="stylesheet" href="styles/bookfrm.css">
    <link rel="stylesheet" href="styles/popup.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/messagepage.css">
    <link rel="icon" href="../assets/logo2.png" type="image/png">
    <script src="../Jscript/animationsScriptHome.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Flashbook</title>
</head>
<body>