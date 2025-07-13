<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $remove_id = $_POST['remove_product_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Shopping Cart</title>
</head>
<body>
    <h2>Your Shopping Cart</h2>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $product_id => $item):
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="remove_product_id" value="<?= $product_id ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td colspan="2">$<?= number_format($total, 2) ?></td>
            </tr>
        </table> 
        <form action="checkout.php" method="post">
            <button type="submit">Proceed to Checkout</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    <br><a href="shop.php">← Back to Shop</a>
</body>
</html>


