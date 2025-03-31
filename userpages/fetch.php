<?php
include('../php/connection.php');
session_start();

$id = $_SESSION['id'];

if (isset($_POST['option'])) {

    if ($_POST['option'] == 'markAsRead' && isset($_POST['notifId'])) {
    
        $notifId = intval($_POST['notifId']); 
        $update = "UPDATE testing_notification SET status = 1 WHERE id = $notifId AND clientID = $id";
        mysqli_query($con, $update);
    }


    $query = "SELECT * FROM testing_notification WHERE clientID = $id ORDER BY id DESC";
    $result = mysqli_query($con, $query);
    $output = '';

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result)) {
       
            $notifClass = $row['status'] == 0 ? 'new-notif' : ''; 
            $output .= "
                <div class='notif-item $notifClass' data-id='".$row['id']."'>
                    <a href='./appointments.php' class='notifLink' data-id='".$row['id']."'>
                        <span style='font-size: 15px;'>".$row['notif_Title']."</span><br>
                        <p style='font-size:12px;line-height:125%;'>".$row['notif_content']."</p>
                        <span class='timestamp'>".$row['created_at']."</span>
                    </a>
                </div>
            ";
        }
    } else {
        
        $output = "<div class='notif-item'>No new notifications</div>";
    }

    $status_query = "SELECT * FROM testing_notification WHERE status = 0 AND clientID = $id";
    $result_query = mysqli_query($con, $status_query);
    $count = mysqli_num_rows($result_query);

    // If no notifications, set count to 0
    if ($count === 0) {
        $count = 0;
    }

    // Prepare response data
    $data = array(
        'notification' => $output,
        'unreadNotification' => $count
    );

    echo json_encode($data);
}
?>
