<?php
session_start();
include 'db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$item_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $item_count += $item['quantity'];
    }
}

$sql = "SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.category_id";
$result = $conn->query($sql);
if (!$result) {
    echo "SQL Error: " . $conn->error;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Snickers Universe</title>
<style>
  body {
    font-family: sans-serif;
    margin: 20px;
  }
  .top-bar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
  }
  .top-bar a.button {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
  }
  .top-bar a.button:hover {
    background-color: #0056b3;
  }
  .user-info {
    margin-right: auto;
    font-size: 0.9rem;
  }
  h2 {
    margin-top: 0;
  }
</style>
</head>
<body>

<div class="top-bar">
  <?php if (isset($_SESSION['name'])): ?>
    <div class="user-info">
      Logged in as <?= htmlspecialchars($_SESSION['name']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)
    </div>
    <a href="order_history.php" class="button">Order History</a>
    <a href="logout.php" class="button">Sign Out</a>
  <?php else: ?>
    <a href="login.php" class="button">Sign In</a>
  <?php endif; ?>

  <a href="view_cart.php" class="button">
      View Cart (<?= $item_count ?>)
  </a>
</div>

<h2>Welcome to Snickers Universe</h2>

<?php include 'searchbar.php'; ?> 
<hr>

<?php while ($row = $result->fetch_assoc()): ?>
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; border:1px solid #ccc; padding:10px; margin:10px;">
    <div>
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>Category: <?= htmlspecialchars($row['category_name']) ?></p>
        <p><strong>$<?= number_format($row['price'], 2) ?></strong></p>
        <?php if (!empty($row['image_url'])): ?>
        <img src="<?= htmlspecialchars($row['image_url']) ?>" width="100" alt="Product Image">
        <?php endif; ?>
        <form method="post" action="cart.php">
            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
            <input type="number" name="quantity" value="1" min="1" required>
            <button type="submit" name="add_to_cart">Add to cart</button>
        </form>
    </div>
    <div>
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <th style="padding: 8px; text-align: left; background-color: #f8f8f8;">Description</th>
                </tr>
                <tr>
                    <td style="padding: 8px;"><?= htmlspecialchars($row['description']) ?></td>
                </tr>
                <tr>
                    <th style="padding: 8px; text-align: left; background-color: #f8f8f8;">Nutrition</th>
                </tr>
                <tr>
                    <td style="padding: 8px;"><?= nl2br(htmlspecialchars($row['nutrition'])) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endwhile; ?>

</body>
</html>
