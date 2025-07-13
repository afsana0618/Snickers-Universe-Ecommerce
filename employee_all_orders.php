<?php
session_start();
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$role = strtolower(trim($_SESSION['role'] ?? ''));
if ($role !== 'admin' && $role !== 'manager' && $role !== 'employee') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Customer Receipts</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        .top-bar {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
        .top-bar a.button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .top-bar a.button:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #999;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="dashboard_employee.php" class="button">← Back to Dashboard</a>
</div>

<?php
echo "<h2>All Customer Receipts</h2>";

$order_sql = "SELECT * FROM orders ORDER BY order_date DESC";
$order_result = mysqli_query($conn, $order_sql);

if (!$order_result) {
    echo "<p style='color:red;'>Receipts Query Error: " . mysqli_error($conn) . "</p>";
    exit;
}

if (mysqli_num_rows($order_result) > 0) {
    while ($order = mysqli_fetch_assoc($order_result)) {
        $order_id = $order['order_id'];
        $user_id = $order['user_id'];
        $order_date = $order['order_date'];

        echo "<h3>Receipt #$order_id - Date: $order_date - User ID: $user_id</h3>";

        $items_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
        $items_result = mysqli_query($conn, $items_sql);

        if (!$items_result) {
            echo "<p style='color:red;'>Receipt Items Query Error for Receipts #$order_id: " . mysqli_error($conn) . "</p>";
            continue;
        }

        if (mysqli_num_rows($items_result) > 0) {
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<tr><th>Product ID</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>";

            $total = 0;
            while ($item = mysqli_fetch_assoc($items_result)) {
                $pid = $item['product_id'];
                $qty = $item['quantity'];
                $price = $item['price'];
                $subtotal = $qty * $price;
                $total += $subtotal;

                echo "<tr>
                        <td>$pid</td>
                        <td>$qty</td>
                        <td>\$" . number_format($price, 2) . "</td>
                        <td>\$" . number_format($subtotal, 2) . "</td>
                      </tr>";
            }

            echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>\$" . number_format($total, 2) . "</strong></td></tr>";
            echo "</table><br>";
        } else {
            echo "<p>No items found for this receipts.</p>";
        }
    }
} else {
    echo "<p>No receipts found.</p>";
}
?>

</body>
</html>

