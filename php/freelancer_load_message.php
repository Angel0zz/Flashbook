<?php
include('../php/connection.php');
session_start();


$ChatId = isset($_GET['ChatId']) ? intval($_GET['ChatId']) : null;

if (!$ChatId) {
    exit; 
}

$freelancerId = $_SESSION['FchatId']; 


$message_query = $con->prepare("
    SELECT 
        c.*, 
        f.Fname AS freelancer_name, 
        a.adminEmail AS admin_name,
        u.first_name AS first_name
    FROM 
        tb_user_freelancer_chat AS c 
    LEFT JOIN 
        tb_freelancers AS f ON c.FchatId = f.FchatId 
    LEFT JOIN 
        tb_admin AS a ON c.FchatId = a.adminID
    LEFT JOIN 
        tb_clientusers AS u ON c.UchatId = u.UchatId
    WHERE 
        (c.UchatId = ? AND c.FchatId = ?) OR (c.UchatId = ? AND c.FchatId = ?)
    ORDER BY 
        c.sent_at
");
$message_query->bind_param("iiii", $freelancerId, $ChatId, $ChatId, $freelancerId);
$message_query->execute();
$result = $message_query->get_result();

while ($message = $result->fetch_assoc()) {

    if ($message['sender'] == 0) {
        $senderLabel = 'You';
    } elseif (!empty($message['admin_name'])) {
        $senderLabel = 'Admin: ' . htmlspecialchars($message['admin_name']);
    } elseif (!empty($message['first_name'])) {
        $senderLabel = 'Client: ' . htmlspecialchars($message['first_name']);
    } else {
        $senderLabel = 'admin';
    }
    $bgColor = $message['sender'] == 0 ? 'background-color: #4c8cff; color:#f1f1e6;' : 'background-color: white;'; // Set background color based on sender

    echo '
    <div class="msg" style="text-align: ' . ($message['sender'] == 0 ? 'right' : 'left') . '; 
    margin-' . ($message['sender'] == 0 ? 'right' : 'left') . ': 10px; 
    margin-' . ($message['sender'] == 0 ? 'left' : 'right') . ': 50%; 
    background-color: ' . $bgColor . '; 
    border-radius: 5px; 
    display: flex-block;">'; 
    echo '<section style="' . $bgColor . ';  border-radius:20px;       box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);"><span >'.htmlspecialchars($message['message']).'</span><br></section>';
    echo '<span style="font-size:8px;font-weight:400; color:black;">' . htmlspecialchars($message['sent_at']) . '</span>';
    echo '</div>';
    }


$con->close();
?>
