<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow frontend access

try {
    $pdo = new PDO('mysql:host=mysql;dbname=department;charset=utf8mb4', 'admin', 'admin123');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");

    $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $settings = [];
    foreach ($results as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    echo json_encode([
        'success' => true,
        'data' => $settings
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
