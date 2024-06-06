<?php
include "db_conn.php";

$sql = "SELECT customer_name, customer_phone, part_name, quantity, price, total_price, paid_amount, due_amount, timestamp FROM orders ORDER BY timestamp DESC";
$result = $conn->query($sql);

$encountered_customers = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <title>Sales Report</title>
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
                <a href="sales-record.php" class="active">Sales Report</a>
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
            <div class="table">

                <h2>Sales Record</h2>

                <?php if ($result->num_rows > 0) : ?>
                    <table>
                        <tr>
                            <th>Timestamp</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Part Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Accu. Price</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                        </tr>
                        <?php
                        $total_price = 0;
                        $total_due = 0;
                        while ($row = $result->fetch_assoc()) {
                            $customer_name = htmlspecialchars($row['customer_name']);
                            $customer_phone = htmlspecialchars($row['customer_phone']);
                            $part_name = htmlspecialchars($row['part_name']);
                            $quantity = htmlspecialchars($row['quantity']);
                            $price = htmlspecialchars($row['price']);
                            $t_price = htmlspecialchars($row['total_price']);
                            $paid_amount = htmlspecialchars($row['paid_amount']);
                            $due_amount = htmlspecialchars($row['due_amount']);
                            $timestamp = htmlspecialchars($row['timestamp']);

                            $row_total = $quantity * $price;

                            $customer_key = $customer_name . '|' . $timestamp;

                            echo "<tr>";
                            echo "<td>{$timestamp}</td>";
                            echo "<td>{$customer_name}</td>";
                            echo "<td>{$customer_phone}</td>";
                            echo "<td>{$part_name}</td>";
                            echo "<td>{$quantity}</td>";
                            echo "<td>" . number_format($price, 2) . "</td>";
                            echo "<td>" . number_format($row_total, 2) . "</td>";

                            if (!isset($encountered_customers[$customer_key])) {
                                echo "<td>" . number_format($paid_amount, 2) . "</td>";
                                echo "<td>" . number_format($due_amount, 2) . "</td>";
                                $total_due += $due_amount;
                                $encountered_customers[$customer_key] = true;
                            } else {
                                echo "<td></td>";
                                echo "<td></td>";
                            }

                            echo "</tr>";

                            $total_price += $row_total;
                        }
                        ?>
                        <tr class="total-row">
                            <td colspan="6" style="text-align: right;">Total Price: <?php echo number_format($total_price, 2); ?></td>
                            <td colspan="3" style="text-align: right;">Total Due: <?php echo number_format($total_due, 2); ?></td>
                        </tr>
                    </table>
                <?php else : ?>
                    <p class="no-orders" ;>No orders found.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </div>
    </div>
</body>

</html>