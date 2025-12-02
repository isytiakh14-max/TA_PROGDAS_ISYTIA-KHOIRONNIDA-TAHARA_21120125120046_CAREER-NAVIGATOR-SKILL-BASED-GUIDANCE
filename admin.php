<?php
require 'config.php';
if(!isset($_SESSION['user_id'])) header("Location: login.php");
$uid = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email FROM users WHERE id=?"); $stmt->bind_param('i',$uid); $stmt->execute(); $row=$stmt->get_result()->fetch_assoc();
if($row['email'] !== 'admin@example.com') { echo "Access denied."; exit; }

$res = $conn->query("SELECT u.id,u.name,u.email, r.recommended, r.score, r.created_at FROM users u LEFT JOIN results r ON u.id = r.user_id ORDER BY r.created_at DESC LIMIT 200");
?>
<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="css/styles.css"></head><body>
<div class="card">
  <h2>Admin Panel</h2>
  <table>
    <tr><th>User</th><th>Email</th><th>Recommendation</th><th>Score</th><th>Date</th></tr>
    <?php while($row=$res->fetch_assoc()){
      echo "<tr><td>".htmlspecialchars($row['name'])."</td><td>".htmlspecialchars($row['email'])."</td><td>".htmlspecialchars($row['recommended'])."</td><td>".intval($row['score'])."</td><td>".htmlspecialchars($row['created_at'])."</td></tr>";
    } ?>
  </table>
  <p><a href="dashboard.php">Back</a></p>
</div>
</body></html>
