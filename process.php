<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Skill sesuai kolom database
$skills = [
    "komunikasi","creativity","problem_solving","manajemen_waktu",
    "digital_literacy","analisis_data","leadership","organisasi",
    "koding_dasar","design_grafis","marketing","public_speaking",
    "negosiasi","teamwork","bahasa_inggris"
];

// Ambil POST skill
$values = [];
foreach ($skills as $s) {
    $values[$s] = isset($_POST[$s]) ? intval($_POST[$s]) : 0;
}

// Total skill
$total = array_sum($values);

// UPDATE data user
$update = $conn->prepare("UPDATE users SET name=?, age=?, interest=? WHERE id=?");
$update->bind_param("sisi", $_POST["name"], $_POST["age"], $_POST["interest"], $user_id);
$update->execute();

// INSERT nilai skill baru
$stmt = $conn->prepare("
    INSERT INTO skills (
        user_id, komunikasi, creativity, problem_solving, manajemen_waktu,
        digital_literacy, analisis_data, leadership, organisasi,
        koding_dasar, design_grafis, marketing, public_speaking,
        negosiasi, teamwork, bahasa_inggris, total_points
    )
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "iiiiiiiiiiiiiiiii",
    $user_id,
    $values['komunikasi'], $values['creativity'], $values['problem_solving'], $values['manajemen_waktu'],
    $values['digital_literacy'], $values['analisis_data'], $values['leadership'], $values['organisasi'],
    $values['koding_dasar'], $values['design_grafis'], $values['marketing'], $values['public_speaking'],
    $values['negosiasi'], $values['teamwork'], $values['bahasa_inggris'],
    $total
);

$stmt->execute();

// Redirect ke dashboard
header("Location: dashboard.php");
exit();
?>
