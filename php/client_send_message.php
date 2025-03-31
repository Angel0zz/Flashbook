<?php
include('../php/connection.php');
session_start();

// Get the input data
$message = isset($_POST['message']) ? $_POST['message'] : '';
$chatId = isset($_POST['chatId']) ? intval($_POST['chatId']) : null; // More generic chatId for either freelancer or admin
$userChatId = isset($_POST['userChatId']) ? intval($_POST['userChatId']) : null;
$sender = 1; // You are always the sender

// Check if the necessary data is provided
if ($message && $chatId && $userChatId) {
    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO tb_user_freelancer_chat (message, FchatId, UchatId, sender) VALUES (?, ?, ?, ?)");
    
    // Check if the prepare was successful
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("siii", $message, $chatId, $userChatId, $sender);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    http_response_code(400); // Bad Request
    echo "Invalid input.";
}


$con->close();

?>
