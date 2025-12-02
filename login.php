<?php
// login.php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute(); $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                header("Location: dashboard.php");
                exit;
            } else $err = "Email atau password salah.";
        } else $err = "Email atau password salah.";
    } else $err = "Isi email & password.";
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="css/styles.css"></head>
<body>
<div class="card form-card">
  <h2>Login</h2>
  <?php if($err) echo "<div class='alert'>".htmlspecialchars($err)."</div>"; ?>
  <?php if(isset($_GET['registered'])) echo "<div class='success'>Pendaftaran sukses, silakan login.</div>"; ?>
  <form method="post">
    <label>Email<input type="email" name="email" required></label>
    <label>Password<input type="password" name="password" required></label>
    <button class="btn" type="submit">Login</button>
  </form>
  <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>
</body>
</html>
