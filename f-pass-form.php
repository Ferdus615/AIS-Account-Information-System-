<?php
if (isset($_POST['token']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $token = htmlspecialchars($_POST['token']);
    $new_password = htmlspecialchars($_POST['new_password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        header("Location: reset-password.php?token=$token&error=Passwords do not match");
        exit();
    }

    $new_password_hashed = md5($new_password);
    include "db_conn.php";

    $sql = "SELECT * FROM users WHERE reset_token='$token' AND token_expiry > NOW()";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $sql = "UPDATE users SET password='$new_password_hashed', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
        mysqli_query($conn, $sql);
        header("Location: login.php?success=Your password has been reset successfully");
    } else {
        header("Location: reset-password.php?token=$token&error=Invalid or expired token");
    }
} else {
    header("Location: login.php");
    exit();
}
