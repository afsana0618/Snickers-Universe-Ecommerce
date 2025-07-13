<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo "<p> You are not authorized to access this page.</p>";
    echo "<a href='inventory.php' Back to Inventory</a>";
    exit;
}
?>

<html>
<head>
  <title>Delete Snickers Product</title>
</head>
<body>
<h1>Delete a Product from the Catalog</h1>

<form action="delete_product.php" method="post">
    <label for="product_id">Enter the Product ID to delete:</label><br>
    <input type="number" name="product_id" id="product_id" required><br><br>
</form>

<br>
<a href="inventory.php"> Back to Inventory</a>

</body>
</html>
