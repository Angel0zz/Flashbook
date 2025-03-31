<?php

include('../php/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'confirm') {
    $bookingID = $_POST['bookingID'];

    $updateSql = "UPDATE tb_appointment SET Payment_Status = 'Confirmed' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('i', $bookingID);
    
    if ($stmt->execute()) {
        header("Location: ../Admin/admin_dashboard.php?success=Payment Confirmed.");

    } else {
        echo "Error updating status.";
    }
    
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'partial') {
    $bookingID = $_POST['bookingID'];
    
    // Update the status to 'Confirmed'
    $updateSql = "UPDATE tb_appointment SET Payment_Status = 'PartiallyPaid ' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('i', $bookingID);
    
    if ($stmt->execute()) {
        header("Location: ../Admin/admin_dashboard.php?success=Payment Confirmed.");

    } else {
        echo "Error updating status.";
    }
    
    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'invalid') {
    $bookingID = $_POST['bookingID'];
    

    $updateSql = "UPDATE tb_appointment SET Payment_Status = 'Invalid ' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('i', $bookingID);
    
    if ($stmt->execute()) {
        header("Location: ../Admin/admin_dashboard.php?error=Payment marked as Invalid.");

    } else {
        echo "Error updating status.";
    }
    
    $stmt->close();
}

?>