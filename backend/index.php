<?php
require_once 'middleware/auth_check.php';
require_once 'db.php';

// Fetch stats
$projectsCount = $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();
$newsCount = $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn();
$newContactsCount = $pdo->query('SELECT COUNT(*) FROM contacts WHERE status = "new"')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบจัดการหลังบ้าน | IT Department</title>
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
            <a href="index.php" class="flex items-center gap-3 px-4 py-3 bg-slate-800 rounded-lg text-white">
                <i class="fa-solid fa-chart-line w-5"></i> ภาพรวม (Dashboard)
            </a>
            <a href="projects.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-folder-open w-5"></i> จัดการผลงาน
            </a>
            <a href="news.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-newspaper w-5"></i> จัดการข่าวสาร
            </a>
            <a href="contacts.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-envelope w-5"></i> ข้อความติดต่อ
                <?php if($newContactsCount > 0): ?>
                    <span class="ml-auto bg-red-500 text-xs px-2 py-1 rounded-full"><?= $newContactsCount ?></span>
                <?php endif; ?>
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
                    <p class="text-sm font-semibold"><?= htmlspecialchars($_SESSION['username']) ?></p>
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
            <h2 class="text-2xl font-bold text-slate-800">ภาพรวมระบบ (Dashboard)</h2>
            <a href="http://localhost:8080/" target="_blank" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition shadow-sm">
                <i class="fa-solid fa-external-link-alt mr-2"></i>ดูหน้าเว็บไซต์
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">ผลงานทั้งหมด</p>
                    <h3 class="text-3xl font-bold text-slate-800"><?= $projectsCount ?></h3>
                </div>
            </div>
            
            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">ข่าวสารประกาศ</p>
                    <h3 class="text-3xl font-bold text-slate-800"><?= $newsCount ?></h3>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">ข้อความใหม่</p>
                    <h3 class="text-3xl font-bold text-slate-800"><?= $newContactsCount ?></h3>
                </div>
            </div>
        </div>
    </main>

</body>
</html>