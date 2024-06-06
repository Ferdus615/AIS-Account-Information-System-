<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .link {
      margin-top: 15px;
    }

    a {
      font-size: 12px;
      text-decoration: none;
      color: aliceblue;
    }

    a:hover {
      color: aliceblue;
      cursor: pointer;
    }

    .fpass {
      margin-right: 15px;
    }

    .acc {
      margin-left: 15px;
    }
  </style>
</head>

<body>

  <div class="form">
    <div>

      <h2>Login</h2><br>

      <form action="login-form.php" method="post">
        <p>
          <input type="text" name="uname" placeholder="Username" required />
        </p><br>
        <p>
          <input type="password" name="password" placeholder="Password" required />
        </p><br>
        <p>
          <input class="btn" type="submit" value="Login" />
        </p>

        <div>
          <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
          <?php } ?>
        </div>

        <div class="link">
          <a href="forgot-pass.php" class="fpass">Forgot password</a>
          <a href="signup.php" class="acc">Create an account</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>