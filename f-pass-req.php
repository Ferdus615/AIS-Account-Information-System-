<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    include "db_conn.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $reset_token = bin2hex(random_bytes(32));

        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $update_sql = "UPDATE users SET reset_token = '$reset_token', token_expiry = '$expiry_time' WHERE email = '$email'";
        mysqli_query($conn, $update_sql);

        $reset_link = "http://yourdomain.com/reset-pass.php?token=$reset_token";
        $email_subject = "Password Reset";
        $email_body = "To reset your password, click the following link: $reset_link";

        $headers = "From: your-email@example.com";

        if (mail($email, $email_subject, $email_body, $headers)) {

            header("Location: forgot-pass.php?success=Password reset instructions sent to your email");
        } else {
            header("Location: forgot-pass.php?error=Failed to send password reset instructions");
        }
    } else {
        header("Location: forgot-pass.php?error=Email not found");
    }
} else {
    header("Location: forgot-pass.php");
}
