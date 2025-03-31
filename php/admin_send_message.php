<?php
include('../php/connection.php');
session_start();

$message = isset($_POST['message']) ? $_POST['message'] : '';
$chatId = isset($_POST['chatId']) ? intval($_POST['chatId']) : null; // More generic chatId 
$adminChatID = isset($_POST['adminChatID']) ? intval($_POST['adminChatID']) : null;
$sender = 2; // You are always the sender


if ($message && $chatId && $adminChatID) {
    $stmt = $con->prepare("INSERT INTO tb_user_freelancer_chat (message, FchatId, UchatId, sender) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }
    $stmt->bind_param("siii", $message, $chatId, $adminChatID, $sender);

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
