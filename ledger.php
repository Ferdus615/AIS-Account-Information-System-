<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <title>General Ledger</title>
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
                <a href="ledger.php" class="active">General Ledger</a>
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

            <h2>General Ledger</h2>

            <table>
                <tr>
                    <th>Timestamp</th>
                    <th>Customer & Employee ID</th>
                    <th>Parts Name</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>

                <?php
                include "db_conn.php";

                $sql_orders = "SELECT timestamp, customer_name, employee_id, paid_amount, due_amount,
                            GROUP_CONCAT(part_name SEPARATOR ', ') AS parts
                        FROM orders 
                        GROUP BY timestamp DESC, customer_name, employee_id";
                $result_orders = $conn->query($sql_orders);

                $debit_total = 0;
                $credit_total = 0;
                $balance = 0;

                if ($result_orders->num_rows > 0) {
                    while ($row_order = $result_orders->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_order['timestamp'] . "</td>";
                        echo "<td>" . htmlspecialchars($row_order['customer_name']) . " (E.ID: " . htmlspecialchars($row_order['employee_id']) . ")" . "</td>";
                        echo "<td>" . htmlspecialchars($row_order['parts']) . "</td>";
                        echo "<td>" . number_format($row_order['paid_amount'], 2) . "</td>";
                        echo "<td>" . number_format($row_order['due_amount'], 2) . "</td>";
                        echo "</tr>";

                        $debit_total += $row_order['paid_amount'];
                        $credit_total += $row_order['due_amount'];
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found.</td></tr>";
                }

                $sql_payable = "SELECT * FROM account_payable";
                $result_payable = $conn->query($sql_payable);

                if ($result_payable->num_rows > 0) {
                    while ($row_payable = $result_payable->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_payable['timestamp'] . "</td>";
                        echo "<td>" . htmlspecialchars($row_payable['vendor_name']) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row_payable['parts_name']) . "</td>"; 
                        echo "<td>  </td>";
                        echo "<td>" . number_format($row_payable['due_amount'], 2) . "</td>";
                        echo "</tr>";

                        $credit_total += $row_payable['due_amount'];
                    }
                } else {
                    echo "<tr><td colspan='5'>No payable records found.</td></tr>";
                }

                $balance = $debit_total - $credit_total;
                $conn->close();
                ?>

                <tr class="total-row">
                    <td colspan="3" style="text-align:right">Total:</td>
                    <td><?php echo number_format($debit_total, 2); ?></td>
                    <td><?php echo number_format($credit_total, 2); ?></td>
                </tr>

                <tr class="total-row">
                    <td colspan="4" style="text-align:right">Balance:</td>
                    <td><?php echo number_format($balance, 2); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>