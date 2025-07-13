<?php
session_start();
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'], $_POST['product_id'], $_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

   
    $stmt = $conn->prepare("SELECT name, price, inventory_quantity FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();

        
        if ($quantity > $product['inventory_quantity']) {
            echo "Sorry, only {$product['inventory_quantity']} unit(s) available in stock.";
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            // Check total intended quantity doesn't exceed inventory
            $existing_quantity = $_SESSION['cart'][$product_id]['quantity'];
            $new_total = $existing_quantity + $quantity;

            if ($new_total > $product['inventory_quantity']) {
                echo "You already have {$existing_quantity} in cart. Only {$product['inventory_quantity']} available total.";
                exit;
            }

            $_SESSION['cart'][$product_id]['quantity'] = $new_total;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }

        $stmt->close();
        header("Location: view_cart.php");
        exit;
    } else {
        echo "Product not found.";
    }

    $stmt->close();
}
?>
