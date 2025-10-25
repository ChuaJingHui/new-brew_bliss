<?php
$servername = "localhost";
$db   = 'brew_bliss';
$user = 'root';
$pass = '';
$host = 'localhost';

$username = "root";
$password = "";
$dbname = "brew_bliss";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


?>
