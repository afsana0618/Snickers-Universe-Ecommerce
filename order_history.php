<?php
session_start();
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id'])) {
    echo "<p>You must be logged in to view order history.</p>";
    echo "<a href='login.php'>Go to Login</a>";
    exit;
}

$user_id = $_SESSION['id'];

// Get all orders by this user
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        .order-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f0f0f0;
        }
        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>Your Order History</h2>

<?php
if ($order_result->num_rows === 0) {
    echo "<p>You have not placed any orders yet.</p>";
    echo "<a href='shop.php'>← Back to Shop</a>";
} else {
    while ($order = $order_result->fetch_assoc()):
        $order_id = $order['order_id'];
        $order_date = $order['order_date'];

        // Get items for this order
        $items_sql = "
            SELECT oi.*, p.name 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?
        ";
        $items_stmt = $conn->prepare($items_sql);
        $items_stmt->bind_param("i", $order_id);
        $items_stmt->execute();
        $items_result = $items_stmt->get_result();

        $order_total = 0;
?>
    <div class="order-box">
        <h3>Order #<?= $order_id ?> - <?= date("F j, Y, g:i a", strtotime($order_date)) ?></h3>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price (each)</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($item = $items_result->fetch_assoc()):
                $subtotal = $item['quantity'] * $item['price'];
                $order_total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($order_total, 2) ?></strong></td>
            </tr>
        </table>
    </div>
<?php
    endwhile;
}
?>

<a href="shop.php">← Back to Shop</a>

</body>
</html>
