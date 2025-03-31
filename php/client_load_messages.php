<?php
include('../php/connection.php');
session_start();

$chatId = isset($_GET['chatId']) ? intval($_GET['chatId']) : null;

if (!$chatId) {
    exit; // Prevent loading messages if no chat ID is provided
}

$userChatId = $_SESSION['UchatId']; // Get the logged-in user's chat ID

// Update the query to join with tb_freelancers and tb_admin to get both freelancer and admin names
$message_query = $con->prepare("
    SELECT 
        c.*, 
        f.Fname AS freelancer_name, 
        a.adminEmail AS admin_name 
    FROM 
        tb_user_freelancer_chat AS c 
    LEFT JOIN 
        tb_freelancers AS f ON c.FchatId = f.FchatId 
    LEFT JOIN 
        tb_admin AS a ON c.FchatId = a.adminID 
    WHERE 
        (c.UchatId = ? AND c.FchatId = ?) OR (c.UchatId = ? AND c.FchatId = ?) 
    ORDER BY 
        c.sent_at
");
$message_query->bind_param("iiii", $userChatId, $chatId, $chatId, $userChatId);
$message_query->execute();
$result = $message_query->get_result();

while ($message = $result->fetch_assoc()) {
    // Determine the sender label (you, freelancer, or admin)
    if ($message['sender'] == 1) {
        $senderLabel = '';
    } elseif (!empty($message['freelancer_name'])) {
        $senderLabel = htmlspecialchars($message['freelancer_name']);
    } elseif ($message['sender'] == 2) {
        $senderLabel = 'Admin ' . htmlspecialchars($message['admin_name']);
    } else {
        $senderLabel = 'Unknown';
    }
    $bgColor = $message['sender'] == 1 ? 'background-color: #4c8cff; color:#f1f1e6;' : 'background-color: white;'; // Set background color based on sender

    echo '
    <div class="msg" style="text-align: ' . ($message['sender'] == 1 ? 'right' : 'left') . '; 
    margin-' . ($message['sender'] == 1 ? 'right' : 'left') . ': 10px; 
    margin-' . ($message['sender'] == 1 ? 'left' : 'right') . ': 50%; 
    background-color: ' . $bgColor . '; 
    border-radius: 5px; 
    display: flex-block;">'; 
    echo '<section style="' . $bgColor . ';  border-radius:20px;       box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);"><span >'.htmlspecialchars($message['message']).'</span><br></section>';
    echo '<span style="font-size:8px;font-weight:400; color:black;">' . htmlspecialchars($message['sent_at']) . '</span>';
    echo '</div>';
    }
?>
