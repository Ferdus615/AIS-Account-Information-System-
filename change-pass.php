<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Change Password</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <a href="home.php" class="b_btn">Back</a>

        <div class="form">
            <div class="div">
                <h2>Change Password</h2><br>

                <?php
                if (isset($_GET['success'])) {
                    header("Location: login.php");
                    exit();
                }

                $message = '';
                $messageClass = '';

                if (isset($_GET['error'])) {
                    $message = htmlspecialchars($_GET['error']);
                    $messageClass = 'error';
                } elseif (isset($_GET['success'])) {
                    $message = htmlspecialchars($_GET['success']);
                    $messageClass = 'success';
                }
                ?>

                <form action="change-pass-form.php" method="post">
                    <?php if ($message) { ?>
                        <p class="<?php echo $messageClass; ?>"><?php echo $message; ?></p>
                    <?php } ?>

                    <input type="password" name="op" placeholder="Current Password">
                    <br><br>

                    <input type="password" name="np" placeholder="New password">
                    <br><br>

                    <input type="password" name="c_np" placeholder="Confirm password">
                    <br><br>

                    <button class="btn" type="submit">CHANGE</button>
                </form>
            </div>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>