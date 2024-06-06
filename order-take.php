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

        .success {
            color: green;
            display: none;
        }

        .payment label {
            margin-right: 10px;
        }

        .total-price {
            font-weight: bold;
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
                <a href="order-take.php" class="active">Order Form</a>
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
                <?php
                include "db_conn.php";

                $employee_id = "";
                $employee_name = "";

                // Fetch employee details
                $sql = "SELECT id, name FROM users LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $employee_id = $row['id'];
                    $employee_name = $row['name'];
                }

                $show_success_msg = false;

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $customer_name = htmlspecialchars($_POST['customer_name']);
                    $customer_phone = htmlspecialchars($_POST['customer_phone']);
                    $parts = $_POST['parts'];
                    $paid_amount = floatval($_POST['paid_amount']);
                    $due_amount = floatval($_POST['due_amount']);
                    $total_price = 0;

                    // Insert order data
                    foreach ($parts as $part) {
                        $part_name = htmlspecialchars($part['part_name']);
                        $quantity = intval($part['quantity']);
                        $price = floatval($part['price']);

                        $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, employee_id, part_name, quantity, price, paid_amount, due_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("ssssssdd", $customer_name, $customer_phone, $employee_id, $part_name, $quantity, $price, $paid_amount, $due_amount);

                        if ($stmt->execute()) {
                            $show_success_msg = true;
                            $total_price += $price * $quantity;
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        $stmt->close();
                    }

                    // Insert revenue data
                    $stmt = $conn->prepare("INSERT INTO revenue (timestamp, employee_id, employee_name, total_price) VALUES (CURRENT_TIMESTAMP, ?, ?, ?)");
                    $stmt->bind_param("ssd", $employee_id, $employee_name, $total_price);

                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>

                <div class="order-form">
                    <h2>Order Form</h2><br>
                    <?php if ($show_success_msg) : ?>
                        <p class="success" id="success-msg">New record created successfully</p>
                    <?php endif; ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="customer">
                            <input type="text" name="customer_name" placeholder="Customer Name" required>
                            <input type="text" name="customer_phone" placeholder="Customer Phone" required><br><br>
                            <input type="text" name="employee_id" value="<?php echo '#' . $employee_id; ?>" readonly>
                            <br><br>
                        </div>
                        <br>
                        <div id="parts">
                            <div class="part-item">
                                <input type="text" name="parts[0][part_name]" placeholder="Part Name" required>
                                <input type="number" name="parts[0][quantity]" placeholder="Quantity" required min="1">
                                <input type="number" name="parts[0][price]" placeholder="Price" required min="0.01" step="0.01">
                            </div>
                        </div>
                        <br>
                        <div class="payment">
                            <input type="number" id="paid_amount" name="paid_amount" placeholder="Paid Amount" min="0" step="0.01">
                            <input type="number" id="due_amount" name="due_amount" placeholder="Due Amount" readonly>
                        </div>
                        <br>

                        <p class="total-price">Total Price: <span id="total-price">0.00</span></p><br>

                        <button type="button" class="add-btn" onclick="addPart()">Add Another Part</button>
                        <br><br>
                        <input class="btn" type="submit" value="Submit">
                        <a href="order-list.php" class="btn">Show Table</a>
                    </form>

                    <script>
                        function addPart() {
                            var partsDiv = document.getElementById('parts');
                            var index = partsDiv.children.length;

                            var newPart = document.createElement('div');
                            newPart.classList.add('part-item');
                            newPart.innerHTML = `
                                <br>
                                <input type="text" name="parts[${index}][part_name]" placeholder="Part Name" required>
                                <input type="number" name="parts[${index}][quantity]" placeholder="Quantity" required min="1">
                                <input type="number" name="parts[${index}][price]" placeholder="Price" required min="0.01" step="0.01">
                        `;
                            partsDiv.appendChild(newPart);
                        }

                        document.addEventListener('input', function(event) {
                            if (event.target && (event.target.matches('input[name^="parts"][name$="[price]"]') || event.target.matches('input[name^="parts"][name$="[quantity]"]') || event.target.matches('#paid_amount'))) {
                                updateTotalPrice();
                            }
                        });

                        function updateTotalPrice() {
                            var totalPrice = 0;
                            var partItems = document.querySelectorAll('.part-item');

                            partItems.forEach(function(partItem) {
                                var quantityInput = partItem.querySelector('input[name$="[quantity]"]');
                                var priceInput = partItem.querySelector('input[name$="[price]"]');

                                var quantity = parseFloat(quantityInput.value) || 0;
                                var price = parseFloat(priceInput.value) || 0;

                                totalPrice += quantity * price;
                            });

                            document.getElementById('total-price').textContent = totalPrice.toFixed(2);

                            updateDueAmount(totalPrice);
                        }

                        function updateDueAmount(totalPrice) {
                            var paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
                            var dueAmount = totalPrice - paidAmount;
                            document.getElementById('due_amount').value = dueAmount.toFixed(2);
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            var successMsg = document.getElementById('success-msg');
                            if (successMsg) {
                                successMsg.style.display = 'block';
                                setTimeout(function() {
                                    successMsg.style.display = 'none';
                                }, 3000)
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>