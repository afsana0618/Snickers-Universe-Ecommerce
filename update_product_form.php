<!DOCTYPE html>
<html>
<head>
  <title>Update Snickers Product</title>
</head>
<body>
<h1>Update a Product in the Catalog</h1>

<form action="update_product.php" method="post">
  <p><strong>Enter Product ID to Update:</strong></p>
  <input type="number" name="product_id" required><br><br>

  <p><strong>New Product Name:</strong></p>
  <input type="text" name="name" required><br><br>

  <p><strong>New Description:</strong></p>
  <textarea name="description" rows="4" cols="50" required></textarea><br><br>

  <p><strong>New Category ID:</strong></p>
  <input type="number" name="category_id" required><br><br>

  <p><strong>New Price:</strong></p>
  <input type="text" name="price" required><br><br>

  <p><strong>New Image URL (optional):</strong></p>
  <input type="text" name="image_url"><br><br>

  <input type="submit" value="Update Product">
</form>

<br>
<a href="dashboard_employee.php">← Back to Dashboard</a>

</body>
</html>
