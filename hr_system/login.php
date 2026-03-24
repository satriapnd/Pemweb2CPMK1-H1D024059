<?php
require_once 'Auth.php';
$auth = new Auth();

if ($auth->isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Email atau Password Salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login HR</title></head>
<body>
    <h2>Login HR System</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</body>
</html>