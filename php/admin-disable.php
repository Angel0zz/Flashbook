<?php
include('../php/connection.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'disable') {
    // Sanitize and retrieve the admin ID
    $adminId = mysqli_real_escape_string($con, $_POST['admin_id']);

    // Check if the connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update query to disable the admin
    $updateQuery = "UPDATE tb_admin SET Status = 1 WHERE adminID = '$adminId'";

    // Execute the query
    if (mysqli_query($con, $updateQuery)) {
        header("Location: ../Admin/admin_admins_module.php?success=Admin disabled successfully.");
    } else {
        error_log("SQL Error: " . mysqli_error($con)); // Log the error
        header("Location: ../Admin/admin_admins_module.php?error=Error disabling admin.");
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enable') {
    // Sanitize and retrieve the admin ID
    $adminId = mysqli_real_escape_string($con, $_POST['admin_id']);

    // Check if the connection is successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update query to disable the admin
    $updateQuery = "UPDATE tb_admin SET Status = 0 WHERE adminID = '$adminId'";

    // Execute the query
    if (mysqli_query($con, $updateQuery)) {
        header("Location: ../Admin/admin_admins_module.php?success=Admin enabled successfully.");
    } else {
        error_log("SQL Error: " . mysqli_error($con)); // Log the error
        header("Location: ../Admin/admin_admins_module.php?error=Error disabling admin.");
    }
}

// Close the database connection
mysqli_close($con);
?>
