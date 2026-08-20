<?php
require_once 'middleware/auth_check.php';
require_once 'db.php';

// Mark as read
if (isset($_GET['read'])) {
    $id = (int)$_GET['read'];
    $stmt = $pdo->prepare('UPDATE contacts SET status = "read" WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: contacts.php');
    exit;
}

// Fetch all
$contacts = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อความติดต่อ | IT Department</title>
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
            <a href="news.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-newspaper w-5"></i> จัดการข่าวสาร
            </a>
            <a href="contacts.php" class="flex items-center gap-3 px-4 py-3 bg-slate-800 rounded-lg text-white">
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
            <h2 class="text-2xl font-bold text-slate-800">ข้อความที่ได้รับจากหน้าเว็บ</h2>
            <div class="flex gap-3">
                <a href="http://localhost:8080/" target="_blank" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition shadow-sm flex items-center">
                    <i class="fa-solid fa-external-link-alt mr-2"></i>ดูหน้าเว็บไซต์
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-4">
            <?php foreach ($contacts as $contact): ?>
            <div class="bg-white rounded-xl shadow-sm border <?= $contact['status'] === 'new' ? 'border-emerald-300 bg-emerald-50/30' : 'border-slate-200' ?> p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                            <?= htmlspecialchars($contact['name']) ?>
                            <?php if($contact['status'] === 'new'): ?>
                                <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full uppercase tracking-wider font-bold">New</span>
                            <?php endif; ?>
                        </h3>
                        <p class="text-sm text-slate-500"><a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="hover:text-blue-600 transition"><i class="fa-regular fa-envelope mr-1"></i><?= htmlspecialchars($contact['email']) ?></a></p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-slate-400 block mb-2"><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></span>
                        <?php if($contact['status'] === 'new'): ?>
                            <a href="?read=<?= $contact['id'] ?>" class="text-xs text-blue-600 hover:text-blue-800 font-medium">ทำเครื่องหมายว่าอ่านแล้ว</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg text-slate-700 text-sm border border-slate-100">
                    <?= nl2br(htmlspecialchars($contact['message'])) ?>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if (count($contacts) === 0): ?>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center text-slate-500">
                ยังไม่มีข้อความติดต่อ
            </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
