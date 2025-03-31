<?php 
   session_start();
   include("../php/connection.php");
   if(!isset($_SESSION['valid'])){
    header("Location:./index.php");
   }

   $userId = $_SESSION['id'];

    // Fetch user data from the database
    $query = "SELECT * FROM tb_freelancers WHERE id='$userId'";
    $result = mysqli_query($con, $query) or die("Query Error");
    $userData = mysqli_fetch_assoc($result);
    include('./js/fetchCalendar.php');
    // Check if user data is retrieved
    if ($userData) {
        $firstname =$userData['fname'];
        $middlename =$userData['middle_name'];
        $lastname =$userData['last_name'];
        $contact =$userData['ContactNum'];
        $fullName = $userData['fname'] . ' ' . $userData['middle_name'] . ' ' . $userData['last_name'];
        $location = $userData['region'] . ' , ' . $userData['province'] . ' , ' . $userData['city'];
        $profile = $userData ['profile'];
        $email = $userData['Freelancer_email'];
        $role = $userData ['role'];
        $about =$userData ['about'];

        // Display user data or use it as needed
    } else {
        // Handle error or display message
        echo "Error retrieving user data.";
    }


    $email = $_SESSION['Freelancer_email'];
            $sql = "SELECT * FROM tb_freelancers WHERE Freelancer_email = '$email'";
            $result = mysqli_query($con, $sql);
            
        if(isset($_POST["update"])){
                $updateName = $_POST['updatename'];
                $updateMname =$_POST['updatemiddlename'];
                $updateLname =$_POST['updatelastname'];
                $updateEmail =$_POST['updatelastname'];
                $updateContactNum =$_POST['updateNumber'];
                $updateAbout =$_POST['updateAbout'];
                
               $sql =  "UPDATE `tb_freelancers` SET `fname`='$updateName',`middle_name`='$updateMname',`last_name`='$updateLname',`ContactNum`='$updateContactNum',`about`='$updateAbout' WHERE id =$userId";
                
               $result = mysqli_query($con,$sql);
               if($result){
                echo("update successfull");
               }
               else{
                echo("update failed");
               }
            }
            include('./regfunct.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Fstyles/freelancer-style.css">
    <link rel="stylesheet" href="Fstyles/gallery-style.css">
    <link rel="stylesheet" href="Fstyles/profilecard.css">
    <Link rel="stylesheet" href="Fstyles/pploginstyle.css">
    <Link rel="stylesheet" href="Fstyles/messagepage.css">

    <link rel="icon" href="../assets/logo2.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/notif.js"></script>
    <title>Flashbook | Freelancers</title>
</head>
<body>