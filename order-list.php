<?php
include "db_conn.php";

$sql = "SELECT id, customer_name, customer_phone, employee_id, part_name, quantity, price, paid_amount, due_amount, timestamp
        FROM orders 
        ORDER BY timestamp DESC 
        LIMIT 5";

$result = $conn->query($sql);

$total_price = 0;
$total_due = 0;
$encountered_timestamps = [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Order List</title>
    <style>
        .p_btn {
            text-decoration: none;
            font-size: 12px;
            border: none;
            outline: none;
            width: 100px;
            padding: 10px;
            border-radius: 5px;
            color: aliceblue;
            background-color: black;
        }

        .p_btn:hover {
            color: aliceblue;
            background-color: #b64045;
        }
    </style>
</head>

<body>
    <a href="order-take.php" class="b_btn">Back</a>

    <div class="table">

        <?php if ($result->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Employee ID</th>
                    <th>Part Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Accu. Price</th>
                    <th>Due Amount</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) :
                    $id = $row['id'];
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_phone']);
                    $employee_id = htmlspecialchars($row['employee_id']);
                    $part_name = htmlspecialchars($row['part_name']);
                    $quantity = htmlspecialchars($row['quantity']);
                    $price = htmlspecialchars($row['price']);
                    $paid_amount = htmlspecialchars($row['paid_amount']);
                    $due_amount = htmlspecialchars($row['due_amount']);
                    $timestamp = htmlspecialchars($row['timestamp']);

                    $row_total = $quantity * $price;

                    $update_sql = "UPDATE orders SET total_price = ? WHERE id = ?";
                    $stmt = $conn->prepare($update_sql);
                    $stmt->bind_param("di", $row_total, $id);
                    $stmt->execute();
                ?>
                    <tr>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_phone; ?></td>
                        <td><?php echo $employee_id; ?></td>
                        <td><?php echo $part_name; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($price, 2); ?></td>
                        <td><?php echo number_format($row_total, 2); ?></td>
                        <td>
                            <?php
                            if (!in_array($timestamp, $encountered_timestamps)) {
                                echo number_format($due_amount, 2);
                                $total_due += $due_amount;
                                $encountered_timestamps[] = $timestamp;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php $total_price += $row_total; ?>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="7" style="text-align:right">Total Price: <?php echo number_format($total_price, 2); ?></td>
                    <td style="text-align:right">Total Due: <?php echo number_format($total_due, 2); ?></td>
                </tr>
            </table>
            <button class="p_btn" onclick="window.print()" style="margin-top: 20px;">Print</button>
        <?php else : ?>
            <p class="no-orders">No orders found.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>