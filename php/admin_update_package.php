<?php
include('../php/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the package data from the form
    $id = intval($_POST['id']);
    $head = trim($_POST['head']);
    $price = floatval($_POST['price']);
    $features = trim($_POST['features']);

    // Prepare the SQL statement to update the package
    $sql = "UPDATE tb_offeredpackages SET head = ?, price = ?, feature = ? WHERE id = ?";
    
    // Initialize the statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sdsi", $head, $price, $features, $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Successfully updated the package
            header("Location: ../Admin/admin_packages_module.php?success=Package updated successfully");
            exit();
        } else {
            // Error executing the statement
            echo "Error updating package: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the statement
        echo "Error preparing statement: " . $con->error;
    }
}

// Close the database connection
$con->close();

?>