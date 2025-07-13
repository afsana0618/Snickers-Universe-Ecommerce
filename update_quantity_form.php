<!DOCTYPE html>
<html>
<head>
    <title>Update Product Quantity</title>
</head>
<body>
<h1>Update Product Quantity</h1>
<form action="update_quantity.php" method="post">
    <label for="product_id">Product ID:</label><br>
    <input type="number" name="product_id" id="product_id" required><br><br>
    <label for="quantity">New Quantity:</label><br>
    <input type="number" name="quantity" id="quantity" required><br><br>
    <input type="submit" value="Update Quantity">
</form>

<p><a href="dashboard_employee.php"> Back to Dashboard</a></p>
</body>
</html>