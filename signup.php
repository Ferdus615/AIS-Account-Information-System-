<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style>
        a {
            font-size: 12px;
            text-decoration: none;
            color: #7e7e7e;
        }

        a:hover {
            color: aliceblue;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="form">
        <form action="signup-form.php" method="post">

            <h2>SIGN UP</h2><br>

            <?php
            $fields = ['name' => 'Full Name', 'email' => 'Email Address', 'number' => 'Phone Number', 'address' => 'Address', 'uname' => 'User Name'];
            foreach ($fields as $field => $placeholder) {
                $value = isset($_GET[$field]) ? htmlspecialchars($_GET[$field]) : '';
                echo "<p><input type='text' name='$field' placeholder='$placeholder' value='$value'></p><br>";
            }
            ?>

            <p><input type="password" name="password" placeholder="Password"></p><br>
            <p><input type="password" name="re_password" placeholder="Confirm Password"></p><br>

            <div>
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
                <?php } ?>
            </div>

            <p>
                <input class="btn" type="submit" value="Sign Up" />
            </p>

            <p>
                <a href="login.php">Login</a>
            </p>

        </form>
    </div>
</body>

</html>