<?php
require_once 'helpers.php';
require_login();
$mysqli = db_connect();
// simple sales/rentals report - count by status and revenue
$total_rentals = $mysqli->query('SELECT COUNT(*) AS c FROM rentals')->fetch_assoc()['c'];
$active = $mysqli->query("SELECT COUNT(*) AS c FROM rentals WHERE status='active'")->fetch_assoc()['c'];
$completed = $mysqli->query("SELECT COUNT(*) AS c FROM rentals WHERE status='completed'")->fetch_assoc()['c'];
$revenue = $mysqli->query('SELECT SUM(total_cost + late_fee) AS s FROM rentals WHERE status="completed"')->fetch_assoc()['s'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>Reports</title><link rel="stylesheet" href="styles.css"></head>
<body><div class="container">
  <h2>Reports</h2>
  <table class="table">
    <tr><th>Total Rentals</th><td><?= $total_rentals ?></td></tr>
    <tr><th>Active Rentals</th><td><?= $active ?></td></tr>
    <tr><th>Completed Rentals</th><td><?= $completed ?></td></tr>
    <tr><th>Revenue (completed)</th><td><?= number_format($revenue,2) ?></td></tr>
  </table>
  <p><a href="index.php">Back</a></p>
</div></body></html>
