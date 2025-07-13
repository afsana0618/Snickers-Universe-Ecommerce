<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo "<p>You are not authorized to access this page.</p>";
    echo "<br><a href='inventory.php'> Back to Inventory</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>Product with ID " . htmlspecialchars($product_id) . " was successfully deleted.</p>";
        } else {
            echo "<p>Product with ID " . htmlspecialchars($product_id) . " could not be deleted. It may not exist.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error preparing the delete query: " . $conn->error . "</p>";
    }

    echo "<br><a href='delete_product_form.php'>← Back to Delete Product</a>";
} else {
    echo "<p>No product selected for deletion.</p>";
    echo "<br><a href='inventory.php'> Back to Inventory</a>";
}
?>
