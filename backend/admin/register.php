<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            $error = 'รหัสผ่านไม่ตรงกัน';
        } else {
            // Check if username already exists
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = 'ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว กรุณาใช้ชื่ออื่น';
            } else {
                // Hash password and insert
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)');
                if ($stmt->execute([$username, $hash, 'user'])) {
                    $success = 'สมัครสมาชิกสำเร็จ! คุณสามารถเข้าสู่ระบบได้แล้ว';
                } else {
                    $error = 'เกิดข้อผิดพลาด ไม่สามารถสมัครสมาชิกได้';
                }
            }
        }
    } else {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก | IT Department</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Prompt', sans-serif; }</style>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">สมัครสมาชิกใหม่</h1>
            <p class="text-slate-500 mt-2">สร้างบัญชีสำหรับเข้าใช้งานระบบ IT Department</p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($success) ?>
            </div>
            <div class="mt-4">
                <a href="login.php" class="w-full inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    ไปที่หน้าเข้าสู่ระบบ
                </a>
            </div>
        <?php else: ?>
            <form method="POST" action="register.php">
                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-2">ชื่อผู้ใช้ (Username)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400"></i>
                        </div>
                        <input type="text" name="username" class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="ตั้งชื่อผู้ใช้" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-2">รหัสผ่าน (Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input type="password" name="password" class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="ตั้งรหัสผ่าน" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-slate-700 text-sm font-bold mb-2">ยืนยันรหัสผ่าน (Confirm Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400"></i>
                        </div>
                        <input type="password" name="confirm_password" class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="พิมพ์รหัสผ่านอีกครั้ง" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i> สมัครสมาชิก
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm text-slate-600">
                มีบัญชีอยู่แล้ว? <a href="login.php" class="text-blue-600 hover:underline font-medium">เข้าสู่ระบบที่นี่</a>
            </div>
        <?php endif; ?>
        
        <div class="mt-4 text-center text-sm">
            <a href="http://localhost:8080/" class="text-slate-400 hover:text-slate-600"><i class="fas fa-arrow-left"></i> กลับสู่หน้าแรก</a>
        </div>
    </div>
</body>
</html>
