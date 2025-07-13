<?php
$conn = new mysqli("localhost", "mundol1", "@Delasalle17", "mundol1_snickers_store");

$category_id = intval($_GET['category_id']); // Get category from URL

// Get category name
$cat_result = $conn->query("SELECT name FROM categories WHERE id = $category_id");
$cat_row = $cat_result->fetch_assoc();

echo "<h1>Products in " . htmlspecialchars($cat_row['name']) . "</h1>";

// Get products in that category
$sql = "SELECT name, description, price FROM products WHERE category_id = $category_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<strong>$" . $row['price'] . "</strong>";
        echo "</div><hr>";
    }
} else {
    echo "No products found in this category.";
}
?>
