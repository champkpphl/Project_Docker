<?php
$host = getenv('PMA_HOST') ?: 'mysql';
$db   = getenv('MYSQL_DATABASE') ?: 'department';
$user = getenv('MYSQL_USER') ?: 'admin';
$pass = getenv('MYSQL_PASSWORD') ?: 'admin123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET NAMES utf8mb4");
} catch (\PDOException $e) {
    die('Database connection failed.');
}
?>
