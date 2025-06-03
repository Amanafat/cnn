<?php
$host = 'localhost';
$db = 'dbmfwyugchltcj';  // Your database name
$user = 'uggpvv6mdgp0o';  // Your username
$pass = 'clkntymnqjg1';   // Your password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
