<!DOCTYPE html>
<html>
<head>
  <title>Snicker's Search Results</title>
</head>
<body>
<h1>Snicker's Search Results</h1>

<?php
  $searchtype = $_POST['searchtype'] ?? '';
  $searchterm = trim($_POST['searchterm'] ?? '');

  if (!$searchtype || !$searchterm) {
     echo 'You have not entered search details. Please go back and try again.';
     exit;
  }

  if (!get_magic_quotes_gpc()) {
    $searchtype = addslashes($searchtype);
    $searchterm = addslashes($searchterm);
  }

  $allowed_search_types = ['name', 'description'];
  if (!in_array($searchtype, $allowed_search_types)) {
      echo "Invalid search type.";
      exit;
  }

  @ $db = new mysqli('localhost', 'mundol1', '@Delasalle17', 'mundol1_snickers_store');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database. Please try again later.';
     exit;
  }

  $query = "SELECT p.*, c.name AS category_name 
            FROM products p 
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.$searchtype LIKE '%$searchterm%'";

  $result = $db->query($query);

  if (!$result) {
      echo "Query Error: " . $db->error;
      exit;
  }

  $num_results = $result->num_rows;

  echo "<p>Number of products found: ".$num_results."</p>";

  for ($i = 0; $i < $num_results; $i++) {
     $row = $result->fetch_assoc();
     echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
     echo "<p><strong>".($i + 1).". Name: ";
     echo htmlspecialchars(stripslashes($row['name']));
     echo "</strong><br />Category: ";
     echo htmlspecialchars(stripslashes($row['category_name']));
     echo "<br />Price: $";
     echo number_format($row['price'], 2);
     echo "<br />Description: ";
     echo htmlspecialchars(stripslashes($row['description']));

     if (!empty($row['image_url'])) {
         echo "<br><img src='" . htmlspecialchars($row['image_url']) . "' width='100' alt='Product Image'>";
     }

     echo "<form method='post' action='cart.php' style='margin-top:10px;'>";
     echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
     echo "<input type='number' name='quantity' value='1' min='1' required>";
     echo "<button type='submit' name='add_to_cart'>Add to Cart</button>";
     echo "</form>";

     echo "</div>";
  }

  $result->free();
  $db->close();
?>

<br>
<a href="shop.php">← Back to Shop</a>

</body>
</html>
