<?php
function display_product_form() {
    echo '<h2>Add a New Product</h2>';
    echo '<form action="insert_product.php" method="post">';
    echo '<p>Product Name: <input type="text" name="name" required></p>';
    echo '<p>Description: <textarea name="description" required></textarea></p>';
    echo '<p>Category ID: <input type="number" name="category_id" required></p>';
    echo '<p>Price: <input type="number" step="0.01" name="price" required></p>';
    
    echo '<p>Image URL: <input type="text" name="image_url"></p>';

    echo '<p>Inventory Quantity: <input type="number" name="inventory_quantity" required></p>';
    echo '<p><input type="submit" value="Add Product"></p>';
    echo '</form>';
}

function delete_product($product_id) {
    $db = new mysqli('localhost', 'mundol1', '@Delasalle17', 'mundol1_snickers_store');
    if ($db->connect_error) {
        echo "Database connection failed: " . $db->connect_error;
        return false;
    }

    $query = "DELETE FROM products WHERE product_id = ?";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        echo "Prepare Failed: " . $db->error;
        return false;
    }

    $stmt->bind_param("i", $product_id);
    $success = $stmt->execute();
    if (!$success) {
        echo "Execute Failed: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
    return $success;
}
?>
