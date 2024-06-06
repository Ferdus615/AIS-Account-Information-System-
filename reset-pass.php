<?php
if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Reset Password</title>
        <style>
            body {
                background-color: burlywood;
                font-family: Arial, sans-serif;
            }

            .reset-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: 100px;
            }

            input[type='password'] {
                width: 200px;
                padding: 10px;
                border: 1px solid black;
                border-radius: 5px;
                outline: none;
                background: transparent;
            }

            .reset-btn {
                width: 100px;
                padding: 10px;
                border: 1px solid black;
                border-radius: 5px;
                color: aliceblue;
                background-color: black;
                margin: 20px 0;
            }

            .reset-btn:hover {
                color: black;
                background-color: aliceblue;
                cursor: pointer;
            }

            .error {
                color: red;
            }

            .success {
                color: green;
            }
        </style>
    </head>

    <body>
        <div class="reset-form">
            <h2>Reset Password</h2>
            <form action="reset-pass-form.php" method="post">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                <button class="reset-btn" type="submit">Reset Password</button>
            </form>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
