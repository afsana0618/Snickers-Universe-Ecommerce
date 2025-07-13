<?php
session_start();
require_once('db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized access. Only admins can insert products.";
    exit;
}
?>
<html>
<head>
    <title>Snickers Product Entry Results</title>
</head>
<body>
<h1>Snickers Product Entry Results</h1>

<?php
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$category_id = $_POST['category_id'] ?? '';
$price = $_POST['price'] ?? '';
$image_url = $_POST['image_url'] ?? ''; // optional
$inventory_quantity = $_POST['inventory_quantity'] ?? '';

if ($name === '' || $description === '' || $category_id === '' || $price === '' || $inventory_quantity === '') {
    echo "<p>You have not entered all the required details. Please go back and try again.</p>";
    exit;
}

$price = doubleval($price);
$inventory_quantity = intval($inventory_quantity);

$name = addslashes($name);
$description = addslashes($description);
$category_id = addslashes($category_id);
$image_url = addslashes($image_url); 

$query = "INSERT INTO products (name, description, category_id, price, image_url, inventory_quantity)
          VALUES ('$name', '$description', '$category_id', $price, '$image_url', $inventory_quantity)";

$result = $conn->query($query);

if ($result) {
    echo "<p>Product inserted successfully with quantity $inventory_quantity.</p>";
} else {
    echo "<p>An error has occurred. The product was not added.<br>";
    echo "Error: " . $conn->error . "</p>";
}

$conn->close();
?>

<p><a href="inventory.php">← Back to Inventory</a></p>
</body>
</html>








