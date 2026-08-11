<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['admin'] = $user;
        header("location: dashboard.php");
    } else {
        echo "<script>alert('Username atau Password Salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - Eduventure</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { display: block; width: 250px; margin-bottom: 10px; padding: 8px; }
        button { width: 100%; padding: 10px; background: #ffcc00; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">LOGIN</button>
        </form>
    </div>
</body>
</html>