<?php
ob_start(); // Start output buffering

require_once("../php/connection.php"); // Include your DB connection
session_start();
if (isset($_POST['RequestBook'])) {
    $UserId = $_SESSION['id']; // Ensure UserId is set from session
    $Fname = $_POST['Fname'];
    $Mname = $_POST['Mname'];
    $Lname = $_POST['Lname'];
    $areaCode = $_POST['areaCode'];
    $contact = $_POST['areaCode'] . $_POST['contactnum'];
    $email = $_POST['email']; 
    $location = $_POST['region'] . ' , ' . $_POST['province'] . ' , ' . $_POST['city'];
    $eventPlaceAddress = $_POST['blk'] . ' , ' . $_POST['lot'] . ' , ' . $_POST['street'];
    $venue = $_POST['venue']; 
    $freelancer = $_POST['freelancer']; 
    $package = $_POST['package']; 
    $date = $_POST['date']; 
    $time  = $_POST['time'];
    $timeFormatted = date("g:i A", strtotime($time));
    $eventType = $_POST['eventType'];
    $details = $_POST['details']; 
    $status = "pending";
    $paymentstatus = "Unpaid";

    // Notification messages
    $title = 'Appointment Request Submitted';
    $message = 'Your request has been submitted and is waiting for approval.'; 
    $ftitle = 'New Booking Request';
    $fmessage = 'New booking request. Check your Appointment page.';

    // Validate input
    if (empty($Fname) || empty($contact) || empty($email) || empty($location) || empty($freelancer) || empty($date)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Please fill up all fields"));
        exit();
    } elseif (!is_numeric($contact) || strlen($contact) !== 13) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Contact must be a valid 10-digit number"));
        exit();
    } else {
        // Insert into tb_appointment
        $sql = "INSERT INTO `tb_appointment` (`userID`, `FreelancerID`, `PackageID`, `Fname`, `Mname`, `Lname`, `Client_email`, `contactNum`, `location`,`EventPlaceAddress`,`Venue`, `date`, `Event_Time`, `Event_type`, `details`, `status`, `Payment_Status`) 
                VALUES ('$UserId', '$freelancer', '$package', '$Fname', '$Mname', '$Lname', '$email', '$contact', '$location','$eventPlaceAddress','$venue','$date', '$timeFormatted', '$eventType', '$details', '$status', '$paymentstatus')";
        
        if (mysqli_query($con, $sql)) {
            // Insert notification
            $queryMessage = "INSERT INTO testing_notification (notif_Title, notif_content, clientID, freelancer_notif_title, freelancer_notif_content, freelancerID) 
                             VALUES ('$title', '$message', '$UserId', '$ftitle', '$fmessage', '$freelancer')";
            mysqli_query($con, $queryMessage);

            header("Location: " . $_SERVER['PHP_SELF'] . "?success=" . urlencode("Form submitted successfully"));
            exit();
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Error in submitting the form. Please try again."));
            exit();
        }
    }
}
ob_end_flush();
?>
