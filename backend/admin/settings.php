<?php
require_once 'middleware/auth_check.php';
require_once 'db.php';

// Fetch current settings
$stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$settings = [];
foreach ($results as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateStmt = $pdo->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
    
    // List of keys we expect
    $expected_keys = [
        'hero_badge', 'hero_title1', 'hero_title1_hi', 'hero_title2', 'hero_title2_hi', 'hero_desc',
        'prog_tag', 'prog_title', 'prog_desc',
        'prog1_title', 'prog1_desc', 'prog1_tag1', 'prog1_tag2', 'prog1_tag3', 'prog1_icon',
        'prog2_title', 'prog2_desc', 'prog2_tag1', 'prog2_tag2', 'prog2_tag3', 'prog2_icon',
        'prog3_title', 'prog3_desc', 'prog3_tag1', 'prog3_tag2', 'prog3_tag3', 'prog3_icon'
    ];
    
    foreach ($expected_keys as $key) {
        if (isset($_POST[$key])) {
            $check = $pdo->prepare('SELECT COUNT(*) FROM settings WHERE setting_key = ?');
            $check->execute([$key]);
            if ($check->fetchColumn() == 0) {
                $insert = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)');
                $insert->execute([$key, trim($_POST[$key])]);
            } else {
                $updateStmt->execute([trim($_POST[$key]), $key]);
            }
        }
    }
    
    // Redirect to self to show success
    header('Location: settings.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตั้งค่าเว็บไซต์ | IT Department</title>
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
            <a href="contacts.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-envelope w-5"></i> ข้อความติดต่อ
            </a>
            <a href="settings.php" class="flex items-center gap-3 px-4 py-3 bg-slate-800 rounded-lg text-white">
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
    <main class="flex-1 overflow-y-auto p-8 bg-slate-50">
        <header class="mb-8 flex justify-between items-center max-w-5xl mx-auto">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">ตั้งค่าเว็บไซต์ <span class="text-blue-600">(หน้าแรก)</span></h2>
                <p class="text-slate-500 mt-1 text-sm">ปรับแต่งข้อความและข้อมูลที่แสดงบนหน้าแรกของเว็บไซต์</p>
            </div>
            <div class="flex gap-3">
                <a href="http://localhost:8080/" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:text-blue-600 transition-all shadow-sm flex items-center gap-2 group">
                    <i class="fa-solid fa-external-link-alt text-slate-400 group-hover:text-blue-500 transition-colors"></i> ดูหน้าเว็บไซต์
                </a>
            </div>
        </header>

        <div class="max-w-5xl mx-auto">
            <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-8 flex items-center gap-4 shadow-sm animate-pulse-once">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-check text-emerald-600"></i>
                </div>
                <div>
                    <h4 class="font-bold">บันทึกการตั้งค่าเรียบร้อยแล้ว</h4>
                    <p class="text-sm text-emerald-600 mt-0.5">การเปลี่ยนแปลงของคุณถูกนำไปแสดงผลที่หน้าแรกแล้ว</p>
                </div>
            </div>
            <?php endif; ?>

            <form method="POST" action="settings.php" class="space-y-8 pb-12">
                
                <!-- Hero Section Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-900 to-slate-900 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white backdrop-blur-sm">
                            <i class="fa-solid fa-image"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">ส่วนต้อนรับ (Hero Section)</h3>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ข้อความป้ายกำกับ (Badge)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <input type="text" name="hero_badge" value="<?= htmlspecialchars($settings['hero_badge'] ?? '') ?>" required class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 hover:bg-white transition-colors text-slate-800">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">หัวข้อบรรทัดที่ 1 (ข้อความปกติ)</label>
                                    <input type="text" name="hero_title1" value="<?= htmlspecialchars($settings['hero_title1'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 hover:bg-white transition-colors text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">หัวข้อบรรทัดที่ 2 (ข้อความปกติ)</label>
                                    <input type="text" name="hero_title2" value="<?= htmlspecialchars($settings['hero_title2'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 hover:bg-white transition-colors text-slate-800">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-blue-600 mb-1.5">หัวข้อบรรทัดที่ 1 (เน้นสีสัน)</label>
                                    <input type="text" name="hero_title1_hi" value="<?= htmlspecialchars($settings['hero_title1_hi'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-blue-50/30 hover:bg-white transition-colors text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-blue-600 mb-1.5">หัวข้อบรรทัดที่ 2 (เน้นสีสัน)</label>
                                    <input type="text" name="hero_title2_hi" value="<?= htmlspecialchars($settings['hero_title2_hi'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-blue-50/30 hover:bg-white transition-colors text-slate-800">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">คำอธิบาย (Subtitle)</label>
                            <textarea name="hero_desc" required rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 hover:bg-white transition-colors text-slate-800 resize-none"><?= htmlspecialchars($settings['hero_desc'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <?php
                $icon_options = [
                    'fa-laptop-code' => 'คอมพิวเตอร์/โค้ด (Laptop/Code)',
                    'fa-server' => 'เซิร์ฟเวอร์/เครือข่าย (Server/Network)',
                    'fa-user-graduate' => 'การศึกษา/บัณฑิต (Education)',
                    'fa-chart-line' => 'กราฟ/สถิติ (Chart/Stats)',
                    'fa-bullhorn' => 'ประกาศ/การตลาด (Marketing)',
                    'fa-cogs' => 'ระบบ/ฟันเฟือง (System/Gears)',
                    'fa-handshake' => 'บริการ/ความร่วมมือ (Service)',
                    'fa-lightbulb' => 'ไอเดีย/นวัตกรรม (Idea/Innovation)',
                    'fa-shield-alt' => 'ความปลอดภัย (Security)',
                    'fa-star' => 'แนะนำ/ยอดนิยม (Star)',
                    'fa-users' => 'ทีมงาน/บุคลากร (Team/Users)',
                    'fa-building' => 'องค์กร/บริษัท (Building)',
                    'fa-briefcase' => 'ธุรกิจ/กระเป๋าเอกสาร (Business)',
                    'fa-globe' => 'เว็บไซต์/โลก (Web/Global)',
                    'fa-mobile-alt' => 'แอปมือถือ (Mobile App)',
                    'fa-shopping-cart' => 'ตะกร้าสินค้า (Shopping)',
                    'fa-leaf' => 'ธรรมชาติ/เกษตร (Nature/Farm)',
                ];
                ?>

                <!-- Feature Cards Section (Generic) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-900 to-slate-900 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white backdrop-blur-sm">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">ส่วนการ์ดเนื้อหา 3 คอลัมน์ (3-Column Feature Section)</h3>
                    </div>
                    <div class="p-6 md:p-8 space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">ป้ายกำกับส่วน (Section Tag)</label>
                                <input type="text" name="prog_tag" value="<?= htmlspecialchars($settings['prog_tag'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 bg-slate-50 hover:bg-white transition-colors text-slate-800">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">หัวข้อส่วน (Section Title)</label>
                                <input type="text" name="prog_title" value="<?= htmlspecialchars($settings['prog_title'] ?? '') ?>" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 bg-slate-50 hover:bg-white transition-colors text-slate-800">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">คำอธิบายส่วน (Section Description)</label>
                            <textarea name="prog_desc" required rows="2" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 bg-slate-50 hover:bg-white transition-colors text-slate-800 resize-none"><?= htmlspecialchars($settings['prog_desc'] ?? '') ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-slate-100">
                            <!-- Card 1 -->
                            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <i class="fa-solid fa-1"></i>
                                    </div>
                                    <h4 class="font-bold text-blue-900 text-lg">การ์ดที่ 1</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2">เลือกไอคอน (Select Icon)</label>
                                        <div class="grid grid-cols-5 gap-2 max-h-48 overflow-y-auto p-2 bg-slate-50 border border-slate-200 rounded-lg custom-scrollbar">
                                            <?php 
                                            $current1 = $settings['prog1_icon'] ?? 'fa-laptop-code';
                                            foreach($icon_options as $val => $label): 
                                            ?>
                                            <label class="cursor-pointer" title="<?= $label ?>">
                                                <input type="radio" name="prog1_icon" value="<?= $val ?>" class="peer hidden" <?= $current1 === $val ? 'checked' : '' ?>>
                                                <div class="aspect-square rounded-md flex items-center justify-center border border-slate-200 bg-white peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 text-slate-500 hover:bg-slate-50 hover:border-slate-300 transition-all">
                                                    <i class="fa-solid <?= $val ?> text-lg"></i>
                                                </div>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">หัวข้อการ์ด (Card Title)</label>
                                        <input type="text" name="prog1_title" value="<?= htmlspecialchars($settings['prog1_title'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">รายละเอียด (Description)</label>
                                        <textarea name="prog1_desc" required rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-sm resize-none"><?= htmlspecialchars($settings['prog1_desc'] ?? '') ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tags จุดเด่น (3 รายการ)</label>
                                        <div class="space-y-2">
                                            <input type="text" name="prog1_tag1" value="<?= htmlspecialchars($settings['prog1_tag1'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-xs bg-white/80">
                                            <input type="text" name="prog1_tag2" value="<?= htmlspecialchars($settings['prog1_tag2'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-xs bg-white/80">
                                            <input type="text" name="prog1_tag3" value="<?= htmlspecialchars($settings['prog1_tag3'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-xs bg-white/80">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="bg-purple-50/50 border border-purple-100 rounded-2xl p-5 hover:shadow-md transition-shadow relative overflow-hidden">
                                <div class="absolute top-0 right-0 bg-purple-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">ป้ายกำกับ</div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <i class="fa-solid fa-2"></i>
                                    </div>
                                    <h4 class="font-bold text-purple-900 text-lg">การ์ดที่ 2</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2">เลือกไอคอน (Select Icon)</label>
                                        <div class="grid grid-cols-5 gap-2 max-h-48 overflow-y-auto p-2 bg-slate-50 border border-slate-200 rounded-lg custom-scrollbar">
                                            <?php 
                                            $current2 = $settings['prog2_icon'] ?? 'fa-server';
                                            foreach($icon_options as $val => $label): 
                                            ?>
                                            <label class="cursor-pointer" title="<?= $label ?>">
                                                <input type="radio" name="prog2_icon" value="<?= $val ?>" class="peer hidden" <?= $current2 === $val ? 'checked' : '' ?>>
                                                <div class="aspect-square rounded-md flex items-center justify-center border border-slate-200 bg-white peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:text-purple-600 text-slate-500 hover:bg-slate-50 hover:border-slate-300 transition-all">
                                                    <i class="fa-solid <?= $val ?> text-lg"></i>
                                                </div>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">หัวข้อการ์ด (Card Title)</label>
                                        <input type="text" name="prog2_title" value="<?= htmlspecialchars($settings['prog2_title'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">รายละเอียด (Description)</label>
                                        <textarea name="prog2_desc" required rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-sm resize-none"><?= htmlspecialchars($settings['prog2_desc'] ?? '') ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tags จุดเด่น (3 รายการ)</label>
                                        <div class="space-y-2">
                                            <input type="text" name="prog2_tag1" value="<?= htmlspecialchars($settings['prog2_tag1'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-xs bg-white/80">
                                            <input type="text" name="prog2_tag2" value="<?= htmlspecialchars($settings['prog2_tag2'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-xs bg-white/80">
                                            <input type="text" name="prog2_tag3" value="<?= htmlspecialchars($settings['prog2_tag3'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-xs bg-white/80">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                        <i class="fa-solid fa-3"></i>
                                    </div>
                                    <h4 class="font-bold text-emerald-900 text-lg">การ์ดที่ 3</h4>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-2">เลือกไอคอน (Select Icon)</label>
                                        <div class="grid grid-cols-5 gap-2 max-h-48 overflow-y-auto p-2 bg-slate-50 border border-slate-200 rounded-lg custom-scrollbar">
                                            <?php 
                                            $current3 = $settings['prog3_icon'] ?? 'fa-user-graduate';
                                            foreach($icon_options as $val => $label): 
                                            ?>
                                            <label class="cursor-pointer" title="<?= $label ?>">
                                                <input type="radio" name="prog3_icon" value="<?= $val ?>" class="peer hidden" <?= $current3 === $val ? 'checked' : '' ?>>
                                                <div class="aspect-square rounded-md flex items-center justify-center border border-slate-200 bg-white peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 text-slate-500 hover:bg-slate-50 hover:border-slate-300 transition-all">
                                                    <i class="fa-solid <?= $val ?> text-lg"></i>
                                                </div>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">หัวข้อการ์ด (Card Title)</label>
                                        <input type="text" name="prog3_title" value="<?= htmlspecialchars($settings['prog3_title'] ?? '') ?>" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">รายละเอียด (Description)</label>
                                        <textarea name="prog3_desc" required rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-sm resize-none"><?= htmlspecialchars($settings['prog3_desc'] ?? '') ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tags จุดเด่น (3 รายการ)</label>
                                        <div class="space-y-2">
                                            <input type="text" name="prog3_tag1" value="<?= htmlspecialchars($settings['prog3_tag1'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-xs bg-white/80">
                                            <input type="text" name="prog3_tag2" value="<?= htmlspecialchars($settings['prog3_tag2'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-xs bg-white/80">
                                            <input type="text" name="prog3_tag3" value="<?= htmlspecialchars($settings['prog3_tag3'] ?? '') ?>" required class="w-full px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-xs bg-white/80">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-12 mb-8">
                    <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-full hover:bg-slate-800 font-bold text-lg transition-all shadow-xl shadow-slate-900/20 flex items-center gap-3 hover:-translate-y-1">
                        <i class="fa-solid fa-save"></i> บันทึกการตั้งค่าทั้งหมด
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
