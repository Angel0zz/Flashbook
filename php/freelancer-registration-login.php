<?php
session_start();
include("../php/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signUp'){
    $name = $_POST["name"];
    $Mname = $_POST["Mname"];
    $Lname = $_POST["Lname"];
    $email =$_POST['Email'];
    $contact = $_POST['areaCode'].$_POST['number'];
    $link = $_POST ['Link'];
    $role = $_POST ['role'];
    $about =$_POST['about'];
    $password = $_POST["passwordreg"];
    $region =$_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
         // check if username exist query
        $sql_check_username = "SELECT * FROM tb_freelancers WHERE Freelancer_email = '$email'";
        $result = mysqli_query($con, $sql_check_username);
 
        if(empty($name) || empty($Mname || empty($Lname)) ){
            echo "please enter your Full Name .";
        }

            //check username
        elseif(empty($email) || mysqli_num_rows($result) > 0){
            if(empty($email)){
                echo "Username field empty";
            }
            elseif(mysqli_num_rows($result) > 0) {
                echo "Username already exists. Please choose a different username.";
            }
     
        }
            //CHECK password
        elseif(strlen($password) < 8) {
            echo "Password must be at least 8 characters long.";
        }
     
        //check location
        elseif (empty($region) || empty($province)|| empty($city) ) {
            echo "please complete Location field";
        }
     
        //check if the files-field is empty
        elseif(!isset($_FILES["image"]) || !isset($_FILES["profile"]) ||
           $_FILES["image"]["error"] === 4 || $_FILES["profile"]["error"] === 4 ){
            echo "<script>alert('Please upload both an image and a profile')</script>";
        }
     
        else{
            // Process image file
            if(isset($_FILES["image"])) {
                $fileNameImage = $_FILES["image"]["name"];
                $fileSizeImage = $_FILES["image"]["size"];
                $tempNameImage = $_FILES["image"]["tmp_name"];
                $validImageExtensions = ['jpg', 'jpeg', 'png'];
                $imageExtensionImage = pathinfo($fileNameImage, PATHINFO_EXTENSION);
     
                if(!in_array(strtolower($imageExtensionImage), $validImageExtensions)){
                    echo "Invalid image file format";
                }
                else if($fileSizeImage > 10000000){
                    echo "<script>alert('Image file size is too large')</script>";
                }
            }
    
            if(isset($_FILES["profile"])) {
                $fileNameProfile = $_FILES["profile"]["name"];
                $fileSizeProfile = $_FILES["profile"]["size"];
                $tempNameProfile = $_FILES["profile"]["tmp_name"];
     
                $validImageExtensions = ['jpg', 'jpeg', 'png'];
                $imageExtensionProfile = pathinfo($fileNameProfile, PATHINFO_EXTENSION);
     
                if(!in_array(strtolower($imageExtensionProfile), $validImageExtensions)){
               
                    echo "<script>alert('Invalid profile file format')</script>";
                }
                else if($fileSizeProfile > 10000000){
                    echo "<script>alert('Profile file size is too large')</script>";
                }
     
                else{
                    $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
     
                    $newImageName = uniqid() . '.' . $imageExtensionImage;
                    move_uploaded_file($tempNameImage, '../img/' . $newImageName);
     
                    $newProfileName = uniqid() . '.' . $imageExtensionProfile;
                    move_uploaded_file($tempNameProfile, '../img/' . $newProfileName);
                    $chatID = rand(100000, 999999);
                    $query = "INSERT INTO tb_freelancers (fname, middle_name, last_name,ContactNum,region,province,city,link, role,about, Freelancer_email, password, image, profile,FchatId,Status)
                    VALUES ('$name', '$Mname', '$Lname',$contact,'$region','$province','$city', '$link','$role', '$about','$email', '$hashedpassword', '$newImageName', '$newProfileName','$chatID','Pending')";
     
                    if (mysqli_query($con, $query) ) {
            
                        header('location:../Freelancers/?success="Registration Submitted Successfully And waiting For Approval"');
                    } else {
                        // Handle any errors
                        echo "Error: " . mysqli_error($con);
                    }
                }
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && $_POST['login'] === 'login') {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = $_POST['password'];
    
        $result = mysqli_query($con, "SELECT * FROM tb_freelancers WHERE Freelancer_email='$email'");
        
        // Check if query executed successfully
        if (!$result) {
            die("Query Error: " . mysqli_error($con));
        }
    
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            if (password_verify($password, $row['password'])) {
                if ($row['Status'] === 'Active') {
                    $_SESSION['Freelancer_email'] = $row['Freelancer_email'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['valid'] = true;
                    $_SESSION['FchatId'] = $row['FchatId'];
                    header("Location: ../Freelancers/myportfolio.php");
                    exit();
                } else {
                    // Handle different statuses
                    switch ($row['Status']) {
                        case 'Pending':
                            header('location:../Freelancers/?error="Your account is pending approval. Please Check Your Email."');
                            break;
                        case 'Rejected':
                            header('location:../Freelancers/?error="Your account has been rejected. Try again later."');
                            break;
                        case 'Disabled':
                            header('location:../Freelancers/?error="Your account is disabled. Please contact admin."');
                            break;
                    }
                }
            } else {
                header('location:../Freelancers/?error="Invalid user or password"');
            }
        } else {
            header('location:../Freelancers/?error="Invalid user or password"');
        }
    }
    