<?php 

$email = $_POST["Forgetemail"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/connection.php";
$sql = "UPDATE tb_freelancers SET reset_token_hash = ?, reset_token_expire_at = ? WHERE Freelancer_email = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($stmt->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END
    <div style="padding: 20px; border: 1px solid #ccc; border-radius: 10px; width: 300px; margin: 0 auto; text-align: center; font-family: Arial, sans-serif; background-color: #f9f9f9;">
        <h2 style="color: #333;">Password Reset</h2>
        <p style="color: #666;">Click the button below to reset your password:</p>
        <a href="http://localhost/flashbook/php/reset-password.php?token=$token" 
           style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
           Reset Password
        </a>
        <p style="color: #999; margin-top: 20px;">If you didn't request this, you can ignore this email.</p>
    </div>
    END;

    try {
        $mail->send();
        header("Location: ../index.php?success=Passwords Reset link Sent, please check your inbox.");
    } catch (Exception $e) {
        header("Location: ../index.php?error=something went wrong please try again later");;
    }
} else {
    echo "No records updated.";
}

$stmt->close();
$mysqli->close(); // Close the mysqlinection
