<?php
require_once 'db.php';
$pdo->exec("SET NAMES utf8mb4");

$defaults = [
    'hero_badge' => 'Information Technology Department • KPTC',
    'hero_title1' => 'สร้างอนาคตด้วย',
    'hero_title1_hi' => 'เทคโนโลยี',
    'hero_title2' => 'ขับเคลื่อนโลกด้วย',
    'hero_title2_hi' => 'นวัตกรรม IT',
    'hero_desc' => 'แผนกวิชาเทคโนโลยีสารสนเทศ วิทยาลัยเทคนิคกำแพงเพชร มุ่งเน้นการผลิตนักพัฒนาดิจิทัล ผู้เชี่ยวชาญระบบเครือข่าย นักพัฒนาซอฟต์แวร์ และเทคโนโลยีปัญญาประดิษฐ์สู่อุตสาหกรรมยุคใหม่'
];

foreach ($defaults as $key => $val) {
    $stmt = $pdo->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
    $stmt->execute([$val, $key]);
}
echo "Database encoding fixed.\n";
?>
