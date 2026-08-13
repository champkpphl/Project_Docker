CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES 
('hero_badge', 'Information Technology Department • KPTC'),
('hero_title1', 'สร้างอนาคตด้วย'),
('hero_title1_hi', 'เทคโนโลยี'),
('hero_title2', 'ขับเคลื่อนโลกด้วย'),
('hero_title2_hi', 'นวัตกรรม IT'),
('hero_desc', 'แผนกวิชาเทคโนโลยีสารสนเทศ วิทยาลัยเทคนิคกำแพงเพชร มุ่งเน้นการผลิตนักพัฒนาดิจิทัล ผู้เชี่ยวชาญระบบเครือข่าย นักพัฒนาซอฟต์แวร์ และเทคโนโลยีปัญญาประดิษฐ์สู่อุตสาหกรรมยุคใหม่');
