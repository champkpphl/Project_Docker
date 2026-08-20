<?php
require_once 'db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query('SELECT * FROM news ORDER BY created_at DESC');
    $news = $stmt->fetchAll();
    echo json_encode(['success' => true, 'data' => $news]);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Failed to fetch news']);
}
?>
