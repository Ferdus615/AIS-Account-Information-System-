<?php
include "db_conn.php";

$sql = "SELECT SUM(total_price) AS total_revenue FROM revenue";
$result = $conn->query($sql);
$totalRevenue = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalRevenue = $row["total_revenue"];
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tax Calculator</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .tax-container {
            width: 75%;
            background-color: aliceblue;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .result-text {
            margin-top: 20px;
            text-align: center;
        }

        .result {
            margin-top: 10px;
            color: #d64045;
            text-align: center;
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
                <a href="home.php">Home</a>
                <a href="order-take.php">Order Form</a>
                <a href="sales-record.php">Sales Report</a>
                <a href="ledger.php">General Ledger</a>
                <a href="acc-pay.php">Acc. Payable</a>
                <a href="acc-receive.php">Acc. Receivable</a>
                <a href="revenue.php">Revenue</a>
                <a href="Tax-calculator.php" class="active">Tax Calculator</a>
            </div>
            <div class="logout">
                <a href="change-pass.php" class="btn">Change Password</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
        <div class="tax-container">
            <div class="form">
                <div>
                    <h2>Enter your Revenue</h2><br>

                    <form method="post" action="">
                        <input type="number" name="income" id="income" required min="0" placeholder="Enter your revenue" value="<?php echo $totalRevenue; ?>">
                        <br><br>
                        <input type="submit" value="Calculate Tax" class="btn">
                    </form>

                    <?php
                    function calculateTax($income)
                    {
                        $taxBrackets = [
                            // 300000 => 0,
                            // 400000 => 0.05,
                            // 600000 => 0.10,
                            // 1000000 => 0.15,
                            // 1500000 => 0.20,
                            PHP_INT_MAX => 0.0275
                        ];

                        $taxOwed = 0;
                        $previousBracketLimit = 0;

                        foreach ($taxBrackets as $bracketLimit => $rate) {
                            if ($income <= $bracketLimit) {
                                $taxOwed += ($income - $previousBracketLimit) * $rate;
                                break;
                            } else {
                                $taxOwed += ($bracketLimit - $previousBracketLimit) * $rate;
                                $previousBracketLimit = $bracketLimit;
                            }
                        }
                        return $taxOwed;
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $income = filter_input(INPUT_POST, 'income', FILTER_VALIDATE_FLOAT);
                        if ($income !== false && $income >= 0) {
                            $tax = calculateTax($income);
                            echo "<div class='result-text'>Your Tax amount is: </div>";
                            echo "<div class='result'>" . number_format($tax, 2) . "</div>";
                        } else {
                            echo "<div class='result'>Enter a valid positive number</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>