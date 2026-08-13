<?php
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Also support form data
    $name = $data['name'] ?? $_POST['name'] ?? '';
    $email = $data['email'] ?? $_POST['email'] ?? '';
    $message = $data['message'] ?? $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $message]);
        echo json_encode(['success' => true]);
    } catch (\PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Failed to save contact']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
}
?>
