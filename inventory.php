<?php
session_start();
require_once 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'manager'])) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventory List</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        h2 {
            margin-bottom: 10px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f0f0f0;
        }
        .low-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Inventory List</h2>
<a class="back-link" href="dashboard_employee.php">← Back to Dashboard</a>

<?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
    <div style="margin-bottom: 20px;">
       <p><a class="black-link" href="insert_product_form.php"> Add Product</a></p>
       <p></p><a class="black-link" href="delete_product_form.php"> Delete Product</a></p>
    </div>
<?php endif; ?>

<?php
$sql = "SELECT p.product_id, p.name, p.price, p.inventory_quantity, c.name AS category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $qty = $row['inventory_quantity'];
        $qty_display = ($qty <= 5)
            ? "<td class='low-stock'>{$qty} (Low)</td>"
            : "<td>{$qty}</td>";

        echo "<tr>
                <td>{$row['product_id']}</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['category_name']) . "</td>
                <td>$" . number_format($row['price'], 2) . "</td>
                $qty_display";
        if ($_SESSION['role'] === 'admin'){
            echo "<td><a href='update_quantity_form.php?product_id={$row['product_id']}'>Update</a></td>";
        }else{
            echo "<td>-</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No products in inventory.</p>";
}
$conn->close();
?>

</body>
</html>
