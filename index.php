<?php
require_once 'helpers.php';
require_login();
$user = current_user();
$mysqli = db_connect();
// quick stats
$cars = $mysqli->query("SELECT COUNT(*) AS c FROM cars")->fetch_assoc()['c'];
$available = $mysqli->query("SELECT COUNT(*) AS c FROM cars WHERE status='available'")->fetch_assoc()['c'];
$rented = $mysqli->query("SELECT COUNT(*) AS c FROM cars WHERE status='rented'")->fetch_assoc()['c'];
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard - CSRMS</title><link rel="stylesheet" href="styles.css"></head>
<body>
<div class="topbar">
  <div>CSRMS</div>
  <div>Welcome, <?=htmlspecialchars($user['name'])?> (<?=htmlspecialchars($user['role'])?>) | <a href="logout.php">Logout</a></div>
</div>
<div class="container">
  <h2>Dashboard</h2>
  <div class="cards">
    <div class="card"><strong><?= $cars ?></strong><div>Cars (total)</div></div>
    <div class="card"><strong><?= $available ?></strong><div>Available</div></div>
    <div class="card"><strong><?= $rented ?></strong><div>Rented</div></div>
  </div>

  <h3>Quick Links</h3>
  <ul>
    <?php if($user['role'] === 'admin'): ?>
      <li><a href="admin/add_car.php">Add Car</a></li>
      <li><a href="admin/list_cars.php">List Cars</a></li>
    <?php else: ?>
      <li><a href="admin/list_cars.php">View Cars</a></li>
    <?php endif; ?>
    <li><a href="staff/rent_car.php">Rent a Car</a></li>
    <li><a href="staff/return_car.php">Return a Car</a></li>
    <li><a href="reports.php">Reports</a></li>
  </ul>
</div>
</body>
</html>
