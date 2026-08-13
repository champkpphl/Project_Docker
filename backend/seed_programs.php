<?php
require_once 'db.php';
$pdo->exec("SET NAMES utf8mb4");

$defaults = [
    'prog_tag' => 'Academic Programs',
    'prog_title' => 'หลักสูตรการศึกษาที่เปิดสอน',
    'prog_desc' => 'ครอบคลุมทุกระดับการศึกษา ตั้งแต่ระดับพื้นฐานจนถึงปริญญาตรี พร้อมฝึกปฏิบัติจริงกับอุปกรณ์มาตรฐานอุตสาหกรรม',
    'prog1_title' => 'ระดับ ปวช.',
    'prog1_desc' => 'ประกาศนียบัตรวิชาชีพ (รับผู้จบ ม.3) มุ่งเน้นสร้างพื้นฐานการเขียนโปรแกรม ระบบคอมพิวเตอร์ กราฟิก และเครือข่ายเบื้องต้น',
    'prog1_tag1' => 'ระยะเวลา 3 ปี',
    'prog1_tag2' => 'พื้นฐานเขียนโปรแกรม',
    'prog1_tag3' => 'Hardware & OS',
    'prog2_title' => 'ระดับ ปวส.',
    'prog2_desc' => 'ประกาศนียบัตรวิชาชีพชั้นสูง (รับผู้จบ ปวช. หรือ ม.6) เน้นความเชี่ยวชาญขั้นสูง Web/App Development, Cloud Computing และ Cybersecurity',
    'prog2_tag1' => 'ระยะเวลา 2 ปี',
    'prog2_tag2' => 'Full-Stack Dev',
    'prog2_tag3' => 'Network & Cloud',
    'prog3_title' => 'ระดับ ปริญญาตรี (ทล.บ.)',
    'prog3_desc' => 'เทคโนโลยีบัณฑิต สาขาวิชาเทคโนโลยีสารสนเทศ (ต่อเนื่อง 2 ปี) เติมเต็มทักษะบริหารจัดการโครงการวิจัย สถาปัตยกรรมซอฟต์แวร์ และ AI',
    'prog3_tag1' => 'ระยะเวลา 2 ปี (ต่อเนื่อง)',
    'prog3_tag2' => 'AI & Data Analytics',
    'prog3_tag3' => 'IT Management'
];

foreach ($defaults as $key => $val) {
    // Check if exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)');
        $stmt->execute([$key, $val]);
    }
}
echo "Programs settings seeded.\n";
?>
