<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update data user (name, age, interest)
$stmt = $conn->prepare("UPDATE users SET name=?, age=?, interest=? WHERE id=?");
$stmt->bind_param("sisi",
    $_POST['name'],
    $_POST['age'],
    $_POST['interest'],
    $user_id
);
$stmt->execute();

// Simpan nilai skill
$fields = "";
$values = "";
$params = [];
$types = "";

foreach ($_POST as $key => $val) {
    if (in_array($key, ["name","age","interest"])) continue; // skip data user

    $fields .= "$key,";
    $values .= "?,";
    $params[] = $val;
    $types .= "i"; // semua skill integer
}

$fields .= "user_id,created_at";
$values .= "?, NOW()";
$params[] = $user_id;
$types .= "i";

$sql = "INSERT INTO skills ($fields) VALUES ($values)";
$stmt2 = $conn->prepare($sql);
$stmt2->bind_param($types, ...$params);
$stmt2->execute();

header("Location: dashboard.php");
exit();
