<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user'){
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome <?= $_SESSION['name'] ?> (Customer)</h2>
<p>This is your dashboard.</p>
<a href="logout.php">Logout</a>