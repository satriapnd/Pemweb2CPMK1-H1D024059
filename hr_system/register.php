<?php
require_once 'Auth.php';
$auth = new Auth();

// Jika user sudah login, tidak boleh mengakses halaman register
if ($auth->isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role']; // Ambil 'admin' atau 'employee' dari dropdown

    // Pastikan ID departemen 1 untuk Admin sesuai data SQL di atas
    $dept_id = ($role === 'admin') ? 1 : 2; 

    $result = $auth->register($username, $email, $password, $role, $dept_id);

    if ($result === true) {
        header("Location: login.php?msg=success");
    } elseif ($result === "email_exists") {
        echo "Registrasi gagal! Email sudah terdaftar.";
    } else {
        echo "Gagal menyimpan data ke database.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - HR System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: sans-serif;">

    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; color: #2c3e50; margin-bottom: 25px;">Daftar Akun Baru</h2>

        <?php if($error): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-size: 14px; border: 1px solid #f5c6cb;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #34495e;">Username</label>
                <input type="text" name="username" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #34495e;">Email</label>
                <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #34495e;">Password</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;" placeholder="Min. 6 karakter" required>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px; color: #34495e;">Role (Akses)</label>
                <select name="role" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                    <option value="admin">Admin</option>
                    <option value="hr">HR Staff</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
            <label>Departemen</label><br>
           

            <button type="submit" style="width: 100%; padding: 12px; background-color: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
                Daftar Sekarang
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #7f8c8d;">
            Sudah punya akun? <a href="login.php" style="color: #3498db; text-decoration: none; font-weight: bold;">Login di sini</a>
        </p>
    </div>

</body>
</html>