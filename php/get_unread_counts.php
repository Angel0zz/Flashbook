<?php
session_start();
include('path_to_your_database_connection.php');
$userId = intval($_GET['userId']);

$query = "
    SELECT FchatId, 
           COUNT(*) AS unread_count 
    FROM tb_user_freelancer_chat 
    WHERE UchatId = $userId AND is_read = 0 
    GROUP BY FchatId
";
$result = $con->query($query);

$counts = [];
while ($row = $result->fetch_assoc()) {
    $counts[] = $row;
}

header('Content-Type: application/json');
echo json_encode($counts);
?>