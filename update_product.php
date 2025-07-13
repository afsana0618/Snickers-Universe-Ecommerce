<html>
<head>
  <title>Snickers Product Update Results</title>
</head>
<body>
<h1>Snickers Product Update Results</h1>

<?php
  $product_id = $_POST['product_id'] ?? '';
  $name = $_POST['name'] ?? '';
  $description = $_POST['description'] ?? '';
  $category_id = $_POST['category_id'] ?? '';
  $price = $_POST['price'] ?? '';
  $image_url = $_POST['image_url'] ?? '';

  if (!$product_id || !$name || !$description || !$category_id || !$price) {
     echo "You have not entered all the required details.<br />Please go back and try again.";
     exit;
  }

  if (!get_magic_quotes_gpc()) {
    $product_id = addslashes($product_id);
    $name = addslashes($name);
    $description = addslashes($description);
    $category_id = addslashes($category_id);
    $price = doubleval($price);
    $image_url = addslashes($image_url);
  }

  @ $db = new mysqli('localhost', 'mundol1', '@Delasalle17', 'mundol1_snickers_store');

  if (mysqli_connect_errno()) {
     echo "Error: Could not connect to database. Please try again later.";
     exit;
  }

  $query = "UPDATE products SET 
              name = '$name',
              description = '$description',
              category_id = '$category_id',
              price = $price,
              image_url = '$image_url'
            WHERE product_id = '$product_id'";

  $result = $db->query($query);

  if ($result) {
      echo $db->affected_rows . " product updated successfully.";
  } else {
      echo "An error has occurred. The product was not updated.<br />";
      echo "Error: " . $db->error;
  }

  $db->close();
?>

<br>
<a href="dashboard_employee.php">← Back to Dashboard</a>

</body>
</html>
