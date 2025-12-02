<?php
// register.php
require 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $age = intval($_POST['age'] ?? 0);
    $interest = trim($_POST['interest'] ?? '');

    if (!$name || !$email || !$password) $errors[] = "Isi semua kolom wajib.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute(); $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email sudah terdaftar.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (name,email,password,age,interest) VALUES (?,?,?,?,?)");
            $ins->bind_param('sssis', $name, $email, $hash, $age, $interest);
            if ($ins->execute()) {
                header("Location: login.php?registered=1");
                exit;
            } else $errors[] = "Gagal mendaftar.";
        }
    }
}
?>

<!doctype html>

<html>
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="card form-card">
  <h2>Daftar Akun</h2>

  <?php if(!empty($errors)): ?>

```
  <?php foreach($errors as $e): ?>
      <div class='alert'><?php echo htmlspecialchars($e); ?></div>
  <?php endforeach; ?>
```

  <?php endif; ?>

  <form method="post">
    <label>Nama<input type="text" name="name" required></label>
    <label>Email<input type="email" name="email" required></label>
    <label>Password<input type="password" name="password" required></label>
    <label>Umur<input type="number" name="age"></label>
    <label>Bidang Minat<input type="text" name="interest"></label>
    <button class="btn" type="submit">Daftar</button>
  </form>
  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>
</body>
</html>
