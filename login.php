<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ('db.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

//Preventing SQL injection
    $stmt = $conn->prepare("SELECT user_id AS id, first_name, password, 'user' AS role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user_result = $stmt->get_result();
//
    if ($user_result->num_rows === 1) {
        $row = $user_result->fetch_assoc();
    } else {
        $stmt = $conn->prepare("SELECT employee_id AS id, first_name, password, role FROM employee WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emp_result = $stmt->get_result();
        if ($emp_result->num_rows === 1) {
            $row = $emp_result->fetch_assoc();
        } else {
            $error = "User not found.";
        }
    }

    if (!empty($row)) {
        if ($password === $row['password']) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['first_name'];
            $_SESSION['role'] = strtolower(trim($row['role']));
            if ($_SESSION['role'] === 'user') {
                header("Location: shop.php");
                exit;
            } elseif ($_SESSION['role'] === 'admin') {
                header("Location: dashboard_employee.php");
                exit;
            } elseif ($_SESSION['role'] === 'manager') {
                header("Location: dashboard_employee.php");
                exit;
            } elseif ($_SESSION['role'] === 'employee') {
                header("Location: dashboard_employee.php");
                exit;
            } else {
                $error = "Unrecognized role.";
            }
        } else {
            $error = "Incorrect password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Snickers Universe</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            width: 300px;
        }
        input[type="email"],
        input[type="password"],
        button {
            width: 100%;
            padding: 12px 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: -15px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Welcome to Snickers Universe</h1>

<form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</form>

</body>
</html>
