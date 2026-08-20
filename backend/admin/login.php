<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: /index.php');
            } else {
                // For users, redirect back to frontend or a simple user page.
                // Since frontend is on port 8080 (client side), we redirect them there.
                header('Location: http://localhost:8080/');
            }
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ | IT Department</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Prompt', sans-serif; }</style>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">IT Department</h1>
            <p class="text-slate-500 mt-2">เข้าสู่ระบบเพื่อดำเนินการต่อ</p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-4">
                <label class="block text-slate-700 text-sm font-bold mb-2">ชื่อผู้ใช้ (Username)</label>
                <input type="text" name="username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-slate-700 text-sm font-bold mb-2">รหัสผ่าน (Password)</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                เข้าสู่ระบบ
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm text-slate-500">
            ยังไม่มีบัญชีใช่หรือไม่? <a href="register.php" class="text-blue-600 hover:underline font-medium">สมัครสมาชิกที่นี่</a>
        </div>
        <div class="mt-4 text-center text-sm text-slate-500">
            <a href="http://localhost:8080/" class="hover:text-blue-600">กลับสู่หน้าแรก</a>
        </div>
    </div>
</body>
</html>
