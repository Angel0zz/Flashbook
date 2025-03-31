<?php
session_start(); // Start session

include 'connection.php'; // Ensure this file connects to the database

// Check if user is logged in and files are set
if (isset($_SESSION['email']) && isset($_FILES['fileImg']['name'])) {
    $totalFiles = count($_FILES['fileImg']['name']);
    $filesArray = array();

    // Allowed file extensions
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'mp4');

    // Get logged-in user's email from session
    $email = $_SESSION['email'];

    // Fetch user details from the database
    $stmt = $con->prepare("SELECT * FROM tb_upload WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['id']; // Assuming user_id is the primary key of tb_upload table
        $existingFiles = json_decode($row['Pf'], true) ?: array(); // Decode existing files array or initialize to an empty array
    } else {
        echo "User not found in database.";
        exit();
    }

    for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = $_FILES['fileImg']['name'][$i];
        $tmpName = $_FILES['fileImg']['tmp_name'][$i];
        $error = $_FILES['fileImg']['error'][$i];

        // Check for file upload errors
        if ($error !== UPLOAD_ERR_OK) {
            echo "Error uploading file $imageName. Error code: $error.<br>";
            continue;
        }

        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageExtension = strtolower($imageExtension);

        // Validate file extension
        if (in_array($imageExtension, $allowedExtensions)) {
            $name = pathinfo($imageName, PATHINFO_FILENAME);
            $newImageName = $name . " - " . uniqid() . '.' . $imageExtension;

            // Check if the file already exists in the database
            if (!in_array($newImageName, $existingFiles)) {
                // Move uploaded file to destination folder
                if (move_uploaded_file($tmpName, '../img/' . $newImageName)) {
                    $filesArray[] = $newImageName;
                } else {
                    echo "Failed to move file $imageName.<br>";
                }
            } else {
                echo "File already exists: $imageName. Skipping upload.<br>";
            }
        } else {
            echo "Invalid file format: $imageName. Only JPG, JPEG, PNG, GIF, MP4 files are allowed.<br>";
        }
    }

    if (!empty($filesArray)) {
        // Merge new files with existing files
        $updatedFiles = array_merge($existingFiles, $filesArray);

        // Encode files array as JSON
        $updatedFilesJson = json_encode($updatedFiles);

        // Update files information in database for the logged-in user
        $stmt = $con->prepare("UPDATE tb_upload SET Pf = ? WHERE id = ?");
        $stmt->bind_param("si", $updatedFilesJson, $user_id);
        if ($stmt->execute()) {
            echo "Files uploaded successfully please Reload to see changes.";
        } else {
            echo "Error updating files: " . $stmt->error;
        }
    }
} else {
    echo "Please select files to upload and ensure you are logged in.";
}
?>