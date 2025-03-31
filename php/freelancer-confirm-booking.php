<?php

include('../php/connection.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $id = $_POST['id'];
    $clientID = $_POST['clientID'];
    $title = 'Appointment Request Accepted';
    $message = 'Your request has been accepted. Check the appointment page and pay a to confirm the booking.';

    $ftitle = 'You Accepted A Request';
    $fmessage = 'Accepted a request. ';

    $queryMessage = "INSERT INTO testing_notification (notif_Title, notif_content, clientID,freelancer_notif_title,freelancer_notif_content,freelancerID) VALUES ('$title', '$message', '$clientID','$ftitle','$fmessage','$userId')";
    mysqli_query($con, $queryMessage);

    // Update the status in tb_appointment
    $updateQuery = "UPDATE tb_appointment SET status = 'Accepted' WHERE id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, 'i', $id);

    // Execute the update statement
    if (!mysqli_stmt_execute($updateStmt)) {
        die("Error updating status: " . mysqli_error($con));
    }
    header("Location: ./dashboard.php?success=Appointment request accepted ");
    // Optionally, you can add a success message here or redirect
}