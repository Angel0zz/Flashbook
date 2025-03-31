<?php
include('../php/connection.php');
session_start();

// Check if the user is logged in


$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$ClientId = isset($_POST['ChatId']) ? intval($_POST['ChatId']) : null;
$freelancerChatID = isset($_POST['userChatId']) ? intval($_POST['userChatId']) : null;

if ($message !== '' && $ClientId !== null && $freelancerChatID !== null) {
    $stmt = $con->prepare("INSERT INTO tb_user_freelancer_chat (message, FchatId, UchatId, sender) VALUES (?, ?, ?, ?)");
    
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        die("Prepare failed: " . $con->error);
    }

    $sender = 0; // You can adjust based on your logic

    // Bind parameters
    $stmt->bind_param("siii", $message, $freelancerChatID, $ClientId, $sender);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid input. Message, ChatId, and userChatId must be provided.']);
}

// Close the database connection
$con->close();
?>
