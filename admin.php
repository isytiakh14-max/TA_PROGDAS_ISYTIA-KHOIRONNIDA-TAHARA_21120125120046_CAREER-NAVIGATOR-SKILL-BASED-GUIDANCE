<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email FROM users WHERE id=?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if ($data['email'] !== 'admin@example.com') {
    echo "Access denied.";
    exit;
}

$totalUser = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();

$listUser = $conn->query("SELECT id, email FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard (Single File)</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f7;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        width: 85%;
        margin: auto;
        padding-top: 30px;
    }

    header {
        background: #3f51b5;
        color: white;
        padding: 16px 22px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header h2 { margin: 0; }

    .logout {
        background: #e53935;
        padding: 8px 12px;
        color: white;
        border-radius: 6px;
        text-decoration: none;
    }
    .logout:hover { background: #c62828; }

    .box {
        background: white;
        margin-top: 25px;
        padding: 22px;
        border-radius: 10px;
        box-shadow: 0px 2px 4px rgba(0,0,0,0.12);
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        margin-top: 20px;
        gap: 20px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.15);
        text-align: center;
    }

    .card .angka {
        font-size: 40px;
        color: #3f51b5;
        font-weight: bold;
        margin-top: 10px;
    }

    table {
        width: 100%;
        margin-top: 15px;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background: #3f51b5;
        color: white;
        padding: 12px;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

</style>

</head>

<body>

<div class="wrapper">

    <header>
        <h2>Admin Dashboard</h2>
        <a class="logout" href="logout.php">Logout</a>
    </header>

    <div class="box">
        <h3>Halo Admin!</h3>
        <p>Anda login sebagai: <strong><?= $data['email']; ?></strong></p>
    </div>

    <div class="grid">

        <div class="card">
            <h4>Total Pengguna Terdaftar</h4>
            <div class="angka"><?= $totalUser['total']; ?></div>
        </div>

        <div class="card">
            <h4>Status Sistem</h4>
            <p>Semua layanan berjalan normal.</p>
        </div>

    </div>

    <div class="box">
        <h3>Daftar Seluruh Pengguna</h3>

        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>

            <?php while ($u = $listUser->fetch_assoc()): ?>
            <tr>
                <td><?= $u['id']; ?></td>
                <td><?= $u['email']; ?></td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>

</div>

</body>
</html>
