<?php
require_once 'middleware/auth_check.php';
require_once 'db.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM news WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: news.php');
    exit;
}

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $stmt = $pdo->prepare('INSERT INTO news (title, content) VALUES (?, ?)');
        $stmt->execute([$title, $content]);
        header('Location: news.php');
        exit;
    }
}

// Fetch all
$newsList = $pdo->query('SELECT * FROM news ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการข่าวสาร | IT Department</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Prompt', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-slate-700">
            <h1 class="text-xl font-bold text-cyan-400">IT Admin Panel</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-chart-line w-5"></i> ภาพรวม
            </a>
            <a href="projects.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-folder-open w-5"></i> จัดการผลงาน
            </a>
            <a href="news.php" class="flex items-center gap-3 px-4 py-3 bg-slate-800 rounded-lg text-white">
                <i class="fa-solid fa-newspaper w-5"></i> จัดการข่าวสาร
            </a>
            <a href="contacts.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-envelope w-5"></i> ข้อความติดต่อ
            </a>
            <a href="settings.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-cog w-5"></i> ตั้งค่าเว็บไซต์
            </a>
        </nav>
        <div class="p-4 border-t border-slate-700">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
                    <i class="fa-solid fa-user text-slate-400"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></p>
                    <p class="text-xs text-slate-400">ผู้ดูแลระบบ</p>
                </div>
            </div>
            <a href="logout.php" class="flex items-center gap-2 text-sm text-red-400 hover:text-red-300 transition">
                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-8">
        <header class="mb-8 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-slate-800">จัดการประกาศและข่าวสาร</h2>
            <div class="flex gap-3">
                <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <i class="fa-solid fa-plus mr-2"></i>เขียนข่าวใหม่
                </button>
                <a href="http://localhost:8080/" target="_blank" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition shadow-sm flex items-center">
                    <i class="fa-solid fa-external-link-alt mr-2"></i>ดูหน้าเว็บไซต์
                </a>
            </div>
        </header>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-sm text-slate-500">
                        <th class="p-4 font-medium w-1/4">หัวข้อข่าว</th>
                        <th class="p-4 font-medium w-1/2">รายละเอียด</th>
                        <th class="p-4 font-medium">วันที่ประกาศ</th>
                        <th class="p-4 font-medium text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $news): ?>
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="p-4 font-medium text-slate-800"><?= htmlspecialchars($news['title']) ?></td>
                        <td class="p-4 text-slate-600 text-sm truncate max-w-xs"><?= htmlspecialchars($news['content']) ?></td>
                        <td class="p-4 text-sm text-slate-500"><?= date('d/m/Y H:i', strtotime($news['created_at'])) ?></td>
                        <td class="p-4 text-right">
                            <a href="?delete=<?= $news['id'] ?>" onclick="return confirm('ยืนยันการลบข่าวนี้?')" class="text-red-500 hover:text-red-700 p-2">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($newsList) === 0): ?>
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">ไม่มีข้อมูลข่าวสาร</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 bg-slate-900/50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="font-bold text-lg text-slate-800">เขียนข่าวประกาศใหม่</h3>
                <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-times"></i></button>
            </div>
            <form method="POST" action="news.php" class="p-6">
                <input type="hidden" name="action" value="add">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">หัวข้อข่าว</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">เนื้อหาข่าวประกาศ</label>
                    <textarea name="content" required rows="5" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-purple-500"></textarea>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50">ยกเลิก</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">ประกาศข่าว</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
