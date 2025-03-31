<?php
include("../php/connection.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $freelancer_id = $_POST['freelancer_id'];
    $action = $_POST['action'];



    if ($action === 'approve') {
        $newStatus = 'Active';
        $message = "Freelancer has been approved successfully.";
        $emailSql = "SELECT Freelancer_email FROM tb_freelancers WHERE id = ?";
        $stmt = $con->prepare($emailSql);
        $stmt->bind_param('i', $freelancer_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        if ($email) {
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Application Approve";
            $mail->Body = '
            <html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #2C2C2C;">
           
                <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; ">
                  <img src="https://flashbook.online/assets/footer-logo.png" alt="Logo" style="max-width: 30%; height: auto; display: block; margin: 0 auto 20px;">
                    <h2 style="color: #99CCFF ;">Welcome to Our Platform!</h2>
                    <p style="font-size: 16px; color: #1A1A1A;">
                        We are thrilled to have you onboard as a freelancer. Your application has been approved, 
                        and you can now log in to start connecting with clients and showcasing your talents.
                    </p>
                
                        <a href="login_url" style="display: inline-block; padding: 10px 20px; background-color: #005580; color: white; text-decoration: none; border-radius: 5px;">
                            Log in Here
                        </a>
                    <p style="font-size: 14px; color: #555;">
                        If you have any questions, feel free to reach out to our support team.
                    </p>
                </div>
            </body>
            </html>
        ';
        
        
            try {
                $mail->send();
                $redirectUrl = "../Admin/admin_freelancer_module.php?success=" . urlencode($message);
            } catch (Exception $e) {
                $redirectUrl = "../Admin/admin_freelancer_module.php?error=something went wrong while sending email.";
            }
        } else {
            die("Freelancer email not found.");
        }
    } elseif ($action === 'decline') {
        $newStatus = 'Rejected';
        $message = "Freelancer has been Rejected.";

        $emailSql = "SELECT Freelancer_email FROM tb_freelancers WHERE id = ?";
        $stmt = $con->prepare($emailSql);
        $stmt->bind_param('i', $freelancer_id);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        if ($email) {
            // Send rejection email
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Application Rejected";
            $mail->Body = '
            <html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #2C2C2C;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
                    <img src="https://flashbook.online/assets/footer-logo.png" alt="Logo" style="max-width: 30%; height: auto; display: block; margin: 0 auto 20px;">
                    <h2 style="color: #ff3333;">Application Rejected</h2>
                    <p style="font-size: 16px; color: #1A1A1A;">
                        We regret to inform you that your freelancer application has been rejected. 
                        Please contact us at <a href="mailto:flashbook.2023@gmail.com" style="color: #005580;">flashbook.2023@gmail.com</a> if you have any questions.
                    </p>
                </div>
            </body>
            </html>
            ';
            
            try {
                $mail->send();
                $redirectUrl = "../Admin/admin_freelancer_module.php?success=" . urlencode($message);
            } catch (Exception $e) {
                $redirectUrl = "../Admin/admin_freelancer_module.php?error=something went wrong while sending email.";
            }
        } else {
            die("Freelancer email not found.");
        }

        
    } elseif ($action === 'viewDetails') {
        $redirectUrl = "../Admin/admin_freelancer_applicationView.php?freelancer_id=" . urlencode($freelancer_id);
        header("Location: " . $redirectUrl);
        exit; 
    } else {
        die("Invalid action.");
    }

    $updateSql = "UPDATE tb_freelancers SET Status = ? WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param('si', $newStatus, $freelancer_id);

    if ($stmt->execute()) {
 
        header("Location: " . $redirectUrl);
    } else {
        echo "Error updating freelancer status.";
    }

    $stmt->close();
    exit; 
}
?>
