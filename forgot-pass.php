<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <style>
        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="form">
        <h2>Reset Password</h2>
        <form action="f-pass-req.php" method="post">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>
</body>

</html>