<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('product_functions.php'); 

echo "<!DOCTYPE html><html><head><title>Add a Product</title></head><body>";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
  display_product_form(); 
  echo '<br><a href="inventory.php"> Back to Inventory</a>';
} else {
  echo "<p>You are not authorized to access this page.</p>";
}

echo "</body></html>";
?>