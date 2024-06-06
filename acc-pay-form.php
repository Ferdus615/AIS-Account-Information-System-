<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <title>Payable Form</title>

    <style>
        .list {
            padding: 50px;
        }

        .total-due {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="list">
        <h2 class="title">Account Payable</h2>
        <table>
            <tr>
                <th>Timestamp</th>
                <th>Vendor Name</th>
                <th>Total Amount</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
            </tr>
            <?php
            include "db_conn.php";

            $total_due = 0;

            $sql = "SELECT * FROM account_payable";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['vendor_name']) . "</td>";
                    echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
                    echo "<td>" . number_format($row['paid_amount'], 2) . "</td>";
                    echo "<td>" . number_format($row['due_amount'], 2) . "</td>";
                    echo "</tr>";

                    $total_due += $row['due_amount'];
                }
            } else {
                echo "<tr><td colspan='5'>No records found.</td></tr>";
            }

            $conn->close();
            ?>
            <tr class="total-due-row">
                <td colspan="4" style="text-align:right"><strong>Total Due Amount:</strong></td>
                <td><?php echo number_format($total_due, 2); ?></td>
            </tr>
        </table>

        <a href="acc-pay.php" class="btn">Back</a>
    </div>
</body>

</html>