<?php
include("../php/connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $AnnouncementTitle = $_POST['announcementTitle'];
    $AnnouncementContent1 = $_POST['announcementContent1'];
    $AnnouncementContent2 = $_POST['announcementContent2'];
    $AnnouncementContent = $_POST['announcementContent'];

    // Prepare the mailer
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@example.com");

    $emailsSent = 0;
    $errors = [];

    // Prepare the email body
    $mail->Subject = htmlspecialchars($AnnouncementTitle);
    $mail->Body = '
    <div style="padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f7f7f7; width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; color: #333;">
        <h2 style="color: #333; text-align: center;">📸 ' . htmlspecialchars($AnnouncementTitle) . ' 🎥</h2>
        <p style="font-size: 16px; font-weight: bold; text-align: center;">' . htmlspecialchars($AnnouncementContent1) . ' 🎥 🎉</p>
        <p style="font-size: 14px; line-height: 1.6; color: #555;">' . htmlspecialchars($AnnouncementContent2) . '</p>
        <p style="font-size: 14px; line-height: 1.6; color: #555;">' . htmlspecialchars($AnnouncementContent) . '</p>
        <p style="font-size: 14px; line-height: 1.6; text-align: center; color: #777;">Thank you for choosing us as your go-to platform for creative appointments! Start booking today and capture your moments in style!</p>
    </div>';
    // Function to send emails from a given SQL query
    function sendEmails($con, $query, $mail, &$emailsSent, &$errors) {
        $stmt = $con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($email);

        while ($stmt->fetch()) {
            $mail->addAddress($email);
            try {
                $mail->send();
                $emailsSent++;
            } catch (Exception $e) {
                $errors[] = "Error sending email to $email: " . $e->getMessage();
            }
            // Clear the address for the next iteration
            $mail->clearAddresses();
        }

        $stmt->close();
    }

    // Send emails to clients
    $clientEmailSql = "SELECT email FROM tb_clientusers";
    sendEmails($con, $clientEmailSql, $mail, $emailsSent, $errors);

    // Send emails to freelancers
    $freelancerEmailSql = "SELECT Freelancer_email FROM tb_freelancers";
    sendEmails($con, $freelancerEmailSql, $mail, $emailsSent, $errors);

    // Redirect with success or error messages
    if ($emailsSent > 0) {
        $redirectUrl = "../Admin/admin_admins_module.php?success=" . urlencode("$emailsSent announcement emails sent successfully.");
    } else {
        $redirectUrl = "../Admin/admin_freelancer_module.php?error=" . urlencode("No emails were sent. " . implode(", ", $errors));
    }

    header("Location: $redirectUrl");
    exit();
}
