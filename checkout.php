<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty";
    exit;
}
?>
<h2>Checkout</h2>
<form method="post" action="process_checkout.php">
    <table border="1">
        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            echo "<tr>
                    <td>{$item['name']}</td>
                    <td>\${$item['price']}</td>
                    <td>{$item['quantity']}</td>
                    <td>\$" . number_format($subtotal, 2) . "</td>
                  </tr>";
        }
        ?>
    </table>
    <p><strong>Total: $<?= number_format($total, 2) ?></strong></p>
    <button type="submit" name="confirm_order" value="yes">Confirm Order</button>
    <br><a href="shop.php">← Back to Shop</a>
</form>

