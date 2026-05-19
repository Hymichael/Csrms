<?php
require_once 'config.php';
session_start();
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $mysqli = db_connect();
    $stmt = $mysqli->prepare('SELECT id,name,password,role FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($row = $res->fetch_assoc()){
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];
            header('Location: index.php');
            exit;
        } else {
            $err = 'Invalid credentials';
        }
    } else {
        $err = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login - CSRMS</title><link rel="stylesheet" href="styles.css"></head>
<body>
<div class="container">
  <h2>CSRMS - Login</h2>
  <?php if($err): ?><div class="error"><?=htmlspecialchars($err)?></div><?php endif; ?>
  <form method="post">
    <label>Email</label><input type="email" name="email" required>
    <label>Password</label><input type="password" name="password" required>
    <button type="submit">Login</button>
  </form>
  <p>Init DB: <a href="init.php">Run init.php</a></p>
</div>
</body>
</html>
