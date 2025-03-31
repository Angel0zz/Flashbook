<?php
include('../php/connection.php');
    
 //user login   
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $result = mysqli_query($con,"SELECT * FROM userstesting WHERE Email='$email' AND Password='$password' ") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if(is_array($row) && !empty($row)){
        $_SESSION['valid'] = $row['Email'];
        $_SESSION['username'] = $row['Username'];
        $_SESSION['age'] = $row['Age'];
        $_SESSION['id'] = $row['Id'];
    }
    else{
      echo"<script> alert('invalid user or password'); </script>";
      }
    if(isset($_SESSION['valid'])){
          header("Location:.././User-home.php");
    }
  }
  //end of user login


  if(isset($_POST['signUp'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    //verify if unique or unused email
    $verify_query = mysqli_query($con,"SELECT Email FROM userstesting WHERE Email ='$email'");

    if(mysqli_num_rows($verify_query) != 0){
        echo"<script> alert('Email already used. used another one please'); </script>";
     }else{
        mysqli_query($con,"INSERT INTO userstesting(Username,Email,ContactNum,Age,Password)VALUES('$username','$email','$number','$age','$password')") or die("ERROR");
                echo"<script>alert('Registered successfully');
                history.back();</script>";

        }
    }
?>
 