<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Account Receivable</title>
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
                <a href="acc-pay.php">Acc. Payable</a>
                <a href="acc-receive.php" class="active">Acc. Receivable</a>
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
                <div class="list">
                    <h2 class="title">Account Receivable</h2>
                    <table>
                        <tr>
                            <th>Employee ID</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Due Amount</th>
                            <th>Timestamp</th>
                        </tr>
                        <?php
                        include "db_conn.php";

                        $sql = "SELECT employee_id, customer_name, customer_phone, SUM(due_amount) AS due_amount, 
                        MIN(timestamp) AS timestamp 
                        FROM orders 
                        WHERE due_amount > 0 
                        GROUP BY employee_id, customer_name, customer_phone";
                        $result = $conn->query($sql);

                        $total_due = 0;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['customer_phone']) . "</td>";
                                echo "<td>" . number_format($row['due_amount'], 2) . "</td>";
                                echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                                echo "</tr>";

                                $total_due += $row['due_amount'];
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                        <tr class="total-due-row">
                            <td colspan="3" style="text-align:right"><strong>Total Due Amount:</strong></td>
                            <td><?php echo number_format($total_due, 2); ?></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
