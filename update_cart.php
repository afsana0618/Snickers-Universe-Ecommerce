<?php
session_start();
include 'db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product_id'], $_POST['new_quantity'])) {
    $id = intval($_POST['update_product_id']);
    $qty = intval($_POST['new_quantity']);

    
    $stmt = $conn->prepare("SELECT inventory_quantity FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();

        if (isset($_SESSION['cart'][$id])) {
            if ($qty > 0) {
                if ($qty <= $product['inventory_quantity']) {
                    
                    $_SESSION['cart'][$id]['quantity'] = $qty;
                } else {
                   
                    $_SESSION['error_message'] = "Only {$product['inventory_quantity']} unit(s) available in stock for this product.";
                }
            } else {
                
                unset($_SESSION['cart'][$id]);
            }
        }
    } else {
        $_SESSION['error_message'] = "Product not found.";
    }

    $stmt->close();
    $conn->close();
}

header("Location: view_cart.php");
exit;
