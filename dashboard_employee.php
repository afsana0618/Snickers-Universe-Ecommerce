<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$role = strtolower(trim($_SESSION['role'] ?? ''));
if ($role !== 'admin' && $role !== 'manager' && $role !== 'employee') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
        }
        h2 {
            margin-bottom: 5px;
        }
        .link-box {
            margin-top: 20px;
        }
        .link-box a {
            display: inline-block;
            margin-right: 15px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }
        .link-box a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Welcome <?= htmlspecialchars($_SESSION['name']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</h2>
<p>This is the <?= htmlspecialchars($_SESSION['role']) ?> dashboard.
<div class="link-box">
    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
        <a href="inventory.php">📦 View Inventory</a>
    <?php endif; ?>
    <a href="employee_all_orders.php">🧾 View All Receipts</a>
    <a href="logout.php">🔒 Logout</a>
</div>

</body>
</html>


