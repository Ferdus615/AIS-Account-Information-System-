<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Revenue Report</title>
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
                <a href="revenue.php" class="active">Revenue</a>
                <a href="Tax-calculator.php">Tax Calculator</a>
            </div>
            <div class="logout">
                <a href="change-pass.php" class="btn">Change Password</a>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>

        <div class="right-container">
            <h2>Revenue Report</h2>

            <table>
                <tr>
                    <th>Timestamp</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Revenue</th>
                </tr>

                <?php
                include "db_conn.php";

                $sql_revenue = "
                    SELECT r.timestamp, r.employee_id, u.name AS employee_name, r.total_price
                    FROM revenue r
                    LEFT JOIN users u ON r.employee_id = u.id
                    ORDER BY r.timestamp DESC";

                $result_revenue = $conn->query($sql_revenue);
                $total_price_sum = 0;

                if ($result_revenue->num_rows > 0) {
                    while ($row_revenue = $result_revenue->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row_revenue['timestamp']) . "</td>";
                        echo "<td>" . htmlspecialchars($row_revenue['employee_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row_revenue['employee_name']) . "</td>";
                        echo "<td>" . number_format($row_revenue['total_price'], 2) . "</td>";
                        echo "</tr>";

                        $total_price_sum += $row_revenue['total_price'];
                    }
                } else {
                    echo "<tr><td colspan='4'>No revenue records found.</td></tr>";
                }

                $conn->close();
                ?>

                <tr>
                    <td colspan="3" style="text-align:right"><strong>Total Revenue:</strong></td>
                    <td><strong><?php echo number_format($total_price_sum, 2); ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>