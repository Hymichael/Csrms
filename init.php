<?php
// init.php - creates DB schema & default users if not present.
// Run this once (or whenever) by visiting init.php in browser.
require_once 'config.php';
$mysqli = db_connect();

// read SQL file and execute
$sql = file_get_contents(__DIR__ . '/db.sql');
if(!$sql){
    echo "db.sql missing.";
    exit;
}
foreach (explode(';', $sql) as $stmt){
    $stmt = trim($stmt);
    if($stmt){
        if(!$mysqli->query($stmt)){
            // ignore errors for existing items
            // echo "Err: " . $mysqli->error;
        }
    }
}

// ensure default users exist using PHP password_hash
$defaults = [
    ['Administrator','admin@example.com','Admin@123','admin'],
    ['Staff Member','staff@example.com','Staff@123','staff']
];
foreach($defaults as $d){
    $email = $mysqli->real_escape_string($d[1]);
    $res = $mysqli->query("SELECT id FROM users WHERE email='$email'");
    if($res->num_rows == 0){
        $hash = password_hash($d[2], PASSWORD_DEFAULT);
        $name = $mysqli->real_escape_string($d[0]);
        $role = $d[3];
        $mysqli->query("INSERT INTO users (name,email,password,role) VALUES ('{$name}','{$email}','{$hash}','{$role}')");
    }
}
echo "Initialization complete. Default users created if missing.\n";
echo "Admin: admin@example.com / Admin@123\nStaff: staff@example.com / Staff@123\n";
?>