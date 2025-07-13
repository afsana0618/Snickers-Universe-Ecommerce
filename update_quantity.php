<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('product_functions.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p>You are not authorized to view this page.</p>";
    echo '<p><a href="dashboard_employee.php">← Back to Dashboard</a></p>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $db = new mysqli('localhost', 'mundol1', '@Delasalle17', 'mundol1_snickers_store');

    if ($db->connect_error) {
        die("Database connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("UPDATE products SET inventory_quantity = ? WHERE product_id = ?");
    if (!$stmt) {
        die("<p>Prepare fail: " . $db->error ."</p>");
    }
    $stmt->bind_param("ii", $quantity, $product_id);

    if ($stmt->execute()) {
        echo "<p>Quantity successfully updated for Product ID $product_id.</p>";
        echo '<p><a href="dashboard_employee.php"> Back to Dashboard</a></P>';
    } else {
        echo "<p>Update failed: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $db->close();
} else {
      ?>
    <h2>Update Product Quantity (Admin Only)</h2>
    <form action="update_quantity.php" method="post">
        <p>Product ID: <input type="number" name="product_id" required></p>
        <p>New Quantity: <input type="number" name="quantity" required></p>
        <input type="submit" value="Update Quantity">
    </form>
    <p><a href="dashboard_employee.php">← Back to Dashboard</a></p>
    <?php
}
?>
