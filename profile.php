<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, age, interest, email FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil Saya</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<div class="container card" style="margin-top:30px;">
    <h2>Profil Anda</h2>

    <p><strong>Nama:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Umur:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
    <p><strong>Bidang Minat:</strong> <?php echo htmlspecialchars($user['interest']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <br>
    <a class="btn" href="dashboard.php">Kembali ke Dashboard</a>
</div>
</body>
</html>
