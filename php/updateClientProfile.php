<?php
include('../php/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'save') {
    $id = $_SESSION['id'];
    $updateFname = $_POST['updateFirstName'];
    $updateMname = $_POST['updateMiddleName'];
    $updateLname = $_POST['updateLastName'];
    $updateContactNumber = $_POST['updateContactDetail'];
    $updatePassword = $_POST['UpdatePassword'];
    $hashedPassword = password_hash($updatePassword, PASSWORD_DEFAULT); 
    $updateProfile = $_FILES["updateProfilePic"]["name"];
    $fileSizeImage = $_FILES["updateProfilePic"]["size"];
    $tempNameImage = $_FILES["updateProfilePic"]["tmp_name"];
    $validImageExtensions = ['jpg', 'jpeg', 'png'];
    $imageExtensionImage = pathinfo($updateProfile, PATHINFO_EXTENSION);

    $updateFields = [];
    $params = [$updateFname, $updateMname, $updateLname, $updateContactNumber];
    
    $updateFields[] = "first_name = ?";
    $updateFields[] = "middle_name = ?";
    $updateFields[] = "last_name = ?";
    $updateFields[] = "Client_number = ?";

    if (!empty($updatePassword)) {
        $updateFields[] = "password = ?";
        $params[] = $hashedPassword;
    }
    if (!empty($updateProfile)) {
        if (!in_array(strtolower($imageExtensionImage), $validImageExtensions)) {
            echo "<script>alert('Invalid image file format. Only JPG, JPEG, and PNG are allowed.')</script>";
        } else if ($fileSizeImage > 10000000) {
            echo "<script>alert('Image file size is too large. Maximum allowed size is 10MB.')</script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtensionImage;
            if (move_uploaded_file($tempNameImage, '../img/' . $newImageName)) {
                $updateFields[] = "picture = ?";
                $params[] = $newImageName;
            } else {
                header("Location: ./myportfolio.php?error=Something went wrong with the file upload");
                exit(); 
            }
        }
    }

    $params[] = $id;

    $query = "UPDATE tb_clientusers SET " . implode(", ", $updateFields) . " WHERE id = ?";
    
    $stmt = mysqli_prepare($con, $query);
    $types = str_repeat('s', count($params) - 1) . 'i'; 
    
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../userpages/profile.php?success=Profile Updated Successfully");
        exit(); 
    } else {
        echo "Error updating profile: " . mysqli_error($con);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'delete') {
    $id = $_SESSION['id']; 

    mysqli_begin_transaction($con);

    try {
        // Delete related reviews
        $deleteReviewsQuery = "DELETE FROM tb_reviews WHERE clientId = ?";
        $deleteReviewsStmt = mysqli_prepare($con, $deleteReviewsQuery);
        mysqli_stmt_bind_param($deleteReviewsStmt, 'i', $id);

        if (!mysqli_stmt_execute($deleteReviewsStmt)) {
            throw new Exception("Error deleting related reviews: " . mysqli_error($con));
        }

        // Delete related notifications
        $deleteNotificationsQuery = "DELETE FROM testing_notification WHERE clientID = ?";
        $deleteNotificationsStmt = mysqli_prepare($con, $deleteNotificationsQuery);
        mysqli_stmt_bind_param($deleteNotificationsStmt, 'i', $id);

        if (!mysqli_stmt_execute($deleteNotificationsStmt)) {
            throw new Exception("Error deleting related notifications: " . mysqli_error($con));
        }

        // Delete related appointments
        $deleteAppointmentsQuery = "DELETE FROM tb_appointment WHERE userID = ?";
        $deleteAppointmentsStmt = mysqli_prepare($con, $deleteAppointmentsQuery);
        mysqli_stmt_bind_param($deleteAppointmentsStmt, 'i', $id);

        if (!mysqli_stmt_execute($deleteAppointmentsStmt)) {
            throw new Exception("Error deleting related appointments: " . mysqli_error($con));
        }

        // Delete the user
        $deleteUserQuery = "DELETE FROM tb_clientusers WHERE id = ?";
        $deleteUserStmt = mysqli_prepare($con, $deleteUserQuery);
        mysqli_stmt_bind_param($deleteUserStmt, 'i', $id);

        if (!mysqli_stmt_execute($deleteUserStmt)) {
            throw new Exception("Error deleting user profile: " . mysqli_error($con));
        }

        mysqli_commit($con);
        session_destroy();
        header("Location: ../index.php?success=Profile and related records deleted successfully");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo $e->getMessage();
    }
}

?>
