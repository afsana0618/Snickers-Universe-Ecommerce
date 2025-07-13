<?php
session_start();
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_order']) && $_POST['confirm_order'] === 'yes') {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<p>Your cart is empty.</p>";
            exit;
        }
        if (!isset($_SESSION['id'])) {
            echo "<p>You must be logged in to place an order.</p>";
            exit;
        }
        $user_id = $_SESSION['id'];
        $total = 0;

        
        $conn->begin_transaction();

        try {
          
            $order_stmt = $conn->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, NOW())");
            if (!$order_stmt) {
                throw new Exception("Prepare failed for orders: (" . $conn->errno . ") " . $conn->error);
            }
            $order_stmt->bind_param("i", $user_id);
            $order_stmt->execute();
            if ($order_stmt->affected_rows < 1) {
                throw new Exception("Failed to create order.");
            }
            $order_id = $order_stmt->insert_id;

            
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $quantity = $item['quantity'];
                $price = $item['price'];
                $subtotal = $quantity * $price;
                $total += $subtotal;

               
                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                if (!$item_stmt) {
                    throw new Exception("Prepare failed for order_items: (" . $conn->errno . ") " . $conn->error);
                }
                $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                $item_stmt->execute();

               
                $update_stmt = $conn->prepare("UPDATE products SET inventory_quantity = inventory_quantity - ? WHERE product_id = ? AND inventory_quantity >= ?");
                if (!$update_stmt) {
                    throw new Exception("Prepare failed for inventory update: (" . $conn->errno . ") " . $conn->error);
                }
                $update_stmt->bind_param("iii", $quantity, $product_id, $quantity);
                $update_stmt->execute();

                if ($update_stmt->affected_rows < 1) {
                    throw new Exception("Not enough inventory for product ID $product_id.");
                }
            }

            
            $conn->commit();

            
            unset($_SESSION['cart']);

            
            echo "<h2>Thank you for your order!</h2>";
            echo "<p>Your Snickers will be on the way soon.</p>";
            echo "<p>Total: $" . number_format($total, 2) . "</p>";
            echo "<a href='shop.php'>Back to Shop</a>";

        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Order failed: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<a href='checkout.php'>Back to Checkout</a>";
        }
    } else {
        echo "<p>Order confirmation failed. Button may not be working correctly.</p>";
    }
} else {
    header("Location: checkout.php");
    exit;
}
?>
