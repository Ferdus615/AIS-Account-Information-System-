<?php
include "db_conn.php";

$show_success_msg = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendor_name = htmlspecialchars($_POST['vendor_name']);
    $parts_name = htmlspecialchars($_POST['parts_name']);
    $total_amount = floatval($_POST['total_amount']);
    $paid_amount = floatval($_POST['paid_amount']);
    $due_amount = floatval($_POST['due_amount']);
    $timestamp = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO account_payable (timestamp, vendor_name, parts_name, total_amount, paid_amount, due_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddd", $timestamp, $vendor_name, $parts_name, $total_amount, $paid_amount, $due_amount);

    if ($stmt->execute()) {
        $show_success_msg = true;
        header("Location: acc-pay-form.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Order Form</title>
    <style>
        .customer {
            border: none;
            outline: none;
            border-bottom: 1px solid black;
            background: transparent;
        }

        ::placeholder {
            color: black;
        }

        .add-btn {
            padding: 10px;
            border: 1px solid black;
            border-radius: 5px;
            color: black;
            background-color: aliceblue;
            text-decoration: none;
        }

        .add-btn:hover {
            color: aliceblue;
            background-color: black;
            cursor: pointer;
        }

        .payment label {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container-home">
        <div class="left-container">
            <div class="prof-img">
                <img class="profile-img" src="Files/Rasmus Lerdorf.jpg" alt="Profile Image" style="height: 100px; width: 100px">
            </div>
            <div class="vertical-menu">
                <a href="home.php">Home</a>
                <a href="order-take.php">Order Form</a>
                <a href="sales-record.php">Sales Report</a>
                <a href="ledger.php">General Ledger</a>
                <a href="acc-pay.php" class="active">Acc. Payable</a>
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
                <div class="order-form">
                    <h2>Order Form</h2><br>

                    <?php if ($show_success_msg) : ?>
                        <p class="success" id="success-msg">New record created successfully</p>
                    <?php endif; ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="customer">
                            <input type="text" name="vendor_name" placeholder="Vendor Name" required>
                            <input type="text" name="parts_name" placeholder="Parts Name" required>
                            <br><br>
                        </div>
                        <br>
                        <div class="payment">
                            <input type="number" id="total_amount" name="total_amount" placeholder="Total Amount" min="0">
                            <input type="number" id="paid_amount" name="paid_amount" placeholder="Paid Amount" min="0">
                            <input type="number" id="due_amount" name="due_amount" placeholder="Due Amount" readonly>
                        </div>
                        <br>

                        <input class="btn" type="submit" value="Submit">
                        <a href="acc-pay-form.php" class="btn">Show Form</a>
                    </form>

                    <script>
                        document.addEventListener('input', function(event) {
                            if (event.target && (event.target.matches('#total_amount') || event.target.matches('#paid_amount'))) {
                                updateDueAmount();
                            }
                        });

                        function updateDueAmount() {
                            var totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
                            var paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
                            var dueAmount = totalAmount - paidAmount;
                            document.getElementById('due_amount').value = dueAmount.toFixed(2);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>