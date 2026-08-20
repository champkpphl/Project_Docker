CREATE DATABASE IF NOT EXISTS `department` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `department`;

-- 1. users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. contacts table
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read') NOT NULL DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. projects table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. news table
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin account (password: password)
-- PHP password_hash('password', PASSWORD_DEFAULT) output for 'password'
INSERT IGNORE INTO `users` (`username`, `password_hash`, `role`) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Insert sample projects
INSERT IGNORE INTO `projects` (`title`, `category`, `description`, `image_path`) VALUES 
('Smart Farm IoT', 'iot', 'ระบบรดน้ำอัตโนมัติสั่งการผ่านสมาร์ทโฟน', 'https://images.unsplash.com/photo-1558449028-b53a39d100fc?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'),
('KPTC App', 'app', 'แอปพลิเคชันให้บริการข้อมูลวิทยาลัย', 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'),
('E-Commerce Website', 'web', 'เว็บไซต์ขายสินค้าออนไลน์ครบวงจร', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');

-- Insert sample news
INSERT IGNORE INTO `news` (`title`, `content`) VALUES 
('ประกาศรับสมัครนักศึกษาใหม่ ประจำปีการศึกษาหน้า', 'เปิดรับสมัครนักศึกษาใหม่ระดับ ปวช. และ ปวส. สามารถสมัครได้ตั้งแต่วันนี้เป็นต้นไป ติดต่อสอบถามได้ที่ห้องวิชาการ'),
('แผนก IT จัดกิจกรรมแข่งขันทักษะการเขียนโปรแกรม', 'ขอเชิญชวนนักศึกษาในแผนกเข้าร่วมการแข่งขันทักษะการเขียนโปรแกรม ชิงเงินรางวัลมากมาย');
