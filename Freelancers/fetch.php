<?php

include('../php/connection.php');
session_start();
// Get user session ID
    $id = $_SESSION['id'];

    if(isset($_POST['option'])){
        // Handle case when 'option' is not empty
        if($_POST['option'] != ''){
            // Correct SQL syntax: Use a single WHERE clause
            $update = "UPDATE testing_notification SET freelancer_status = 1 WHERE status = 0 AND freelancerID = $id";
            mysqli_query($con, $update);
        }

        // Query to get all notifications for the user, ordering by id
        $query = "SELECT * FROM testing_notification WHERE freelancerID = $id ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        $output = '';

        if(mysqli_num_rows($result) > 0){
            // Build the output for notifications
            while($row = mysqli_fetch_array($result)){
                $output .= "
               
                    <div class='notif-item'>
                     <a href='./dashboard.php' class='notifLink'>
                    <span style='font-size: 15px; '>".$row['freelancer_notif_title']."</span><br>
                    <p style='font-size:12px;line-height:125%;'>".$row['freelancer_notif_content']."</p>
                    <span class='timestamp'>".$row['created_at']."</span>
                   </a>
                    </div>
             
            
         
                ";
            }
        } else {
            // No new notifications
            $output = "<div class='notif-item'>No new notifications</div>";
        }

        // Query to count unread notifications
        $status_query = "SELECT * FROM testing_notification WHERE freelancer_status = 0 AND freelancerID = $id";
        $result_query = mysqli_query($con, $status_query);
        $count = mysqli_num_rows($result_query);

        // Prepare response data
        $data = array(
            'notification' => $output,
            'unreadNotification' => $count
        );

        echo json_encode($data);

        // Handle case when option is 'updateAll'
        if ($_POST['option'] == 'updateAll') {
            // Update all notifications to read
            $update_all = "UPDATE testing_notification SET freelancer_status = 1 WHERE freelancer_status = 0 AND freelancerID = $id";
            
            if (mysqli_query($con, $update_all)) {
                // Return success message
                echo "success";
            } else {
                // Return error if something went wrong
                echo "error";
            }
        }
    }
?>

