<?php

include('../php/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'disable') {
    $freelancerId = $_POST['freelancer_id'];
    $updateSql = "UPDATE tb_freelancers SET Status = 'Disabled' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('i', $freelancerId);

    if ($stmt->execute()) {
        header("Location: ../Admin/admin_freelancer_module.php?success=freelancer Disabled.");

    } else {
        header("Location: ../Admin/admin_freelancer_module.php?error=something went wrong try again");
    }
    
    $stmt->close();

}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'enable') {
    $freelancerId = $_POST['freelancer_id'];
    $updateSql = "UPDATE tb_freelancers SET Status = 'Active' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('i', $freelancerId);

    if ($stmt->execute()) {
        header("Location: ../Admin/admin_freelancer_module.php?success=freelancer account Enabled.");

    } else {
        header("Location: ../Admin/admin_freelancer_module.php?error=something went wrong try again");
    }
    
    $stmt->close();

}