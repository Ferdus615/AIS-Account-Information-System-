<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css">

        <title>HOME</title>
        <style>
            .right-section h3 {
                font-size: 24px;
                margin-bottom: 10px;
                color: #d64045;
            }

            .right-section h1 {
                font-size: 36px;
                margin-bottom: 20px;
            }

            .right-section p {
                font-size: 18px;
                margin: 10px 0;
                color: gray;
            }

            .right-section span {
                color: #d64045;
            }
        </style>
    </head>

    <body>
        <div class="container-home">
            <div class="left-container">
                <div class="prof-img">
                    <img class="profile-img" src="Files\Rasmus Lerdorf.jpg" alt="Profile Image" style="height: 100px; width:100px">
                </div>
                <div class="vertical-menu">
                    <a href="home.php" class="active">Home</a>
                    <a href="order-take.php">Order Form</a>
                    <a href="sales-record.php">Sales Report</a>
                    <a href="ledger.php">General Ledger</a>
                    <a href="acc-pay.php">Acc. Payable</a>
                    <a href="acc-receive.php">Acc. Receivable</a>
                    <a href="revenue.php">Revenue</a>
                    <a href="Tax-calculator.php">Tax Calculator</a>
                </div>
                <div class="logout">
                    <a href="change-pass.php" class="btn">Change Password</a>
                    <a href="logout.php" class="btn">Logout</a>
                </div>
            </div>
            <div class="right-container">
                <div class="right-section">

                    <h3>Welcome</h3>

                    <h1><?php echo $_SESSION['name']; ?></h1>
                    <p>User Id: <span><?php echo $_SESSION['id']; ?></span></p>
                    <p>Full Name: <span><?php echo $_SESSION['name']; ?></span></p>
                    <p>Mobile: <span><?php echo $_SESSION['number']; ?></span></p>
                    <p>Email: <span><?php echo $_SESSION['email']; ?></span></p>
                    <p>Address: <span><?php echo $_SESSION['address']; ?></span></p>
                </div>
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