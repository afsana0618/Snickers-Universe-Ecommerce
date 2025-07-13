<?php
$conn = new mysqli("localhost", "mundol1", "@Delasalle17", "mundol1_snickers_store");

$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

echo "<h1>Product Categories</h1>";
echo "<ul>";
while($row = $result->fetch_assoc()) {
    echo "<li><a href='products.php?category_id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a></li>";
}
echo "</ul>";
?>

