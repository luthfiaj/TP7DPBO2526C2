-- Database: db_daily_routine
CREATE DATABASE IF NOT EXISTS `db_daily_routine`;
USE `db_daily_routine`;

-- Table 1: Categories (Routine Types: Morning / Night)
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `theme_color` VARCHAR(20) DEFAULT 'amber'
);

-- Table 2: Routines (Core Master Data)
CREATE TABLE IF NOT EXISTS `routines` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `day_of_week` ENUM('Everyday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') DEFAULT 'Everyday',
    `target_duration_minutes` INT DEFAULT 15,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
);

-- Table 3: Routine Logs (Tracking Progress)
CREATE TABLE IF NOT EXISTS `routine_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `routine_id` INT NOT NULL,
    `log_date` DATE NOT NULL,
    `status` ENUM('Completed', 'Pending', 'Skipped') DEFAULT 'Pending',
    `notes` TEXT,
    FOREIGN KEY (`routine_id`) REFERENCES `routines`(`id`) ON DELETE CASCADE
);

-- Initial Data
INSERT INTO `categories` (`id`, `name`, `description`, `theme_color`) VALUES
(1, 'Morning Routine', 'Energi positif & pembentukan mindset awal hari', 'amber'),
(2, 'Night Routine', 'Pembersihan diri, relaksasi & self-reflection', 'indigo');

INSERT INTO `routines` (`category_id`, `title`, `description`, `day_of_week`, `target_duration_minutes`) VALUES
(1, 'Ice Water Face Dip', 'Merendam muka dengan air dingin untuk menyegarkan kulit dan meningkatkan kewaspadaan', 'Everyday', 5),
(1, 'Olahraga Pagi (Full Body Warm-up)', 'Stretching dan kalistenik ringan untuk memicu metabolisme', 'Monday', 20),
(1, 'Olahraga Pagi (Jogging / Cardio)', 'Lari pagi 3km untuk melatih ketahanan jantung', 'Wednesday', 30),
(1, 'Membaca Buku Self-Development', 'Membaca 10 halaman buku pengembangan diri', 'Everyday', 15),
(1, 'Menyiapkan Sarapan Sehat', 'Membuat smoothie bowl atau oatmeal kaya nutrisi', 'Everyday', 15),
(2, 'Skincare Routine', 'Double cleansing, moisturizer, dan night serum', 'Everyday', 10),
(2, 'Journaling & Reflection', 'Menuliskan 3 hal yang disyukuri dan evaluasi target harian', 'Everyday', 15),
(2, 'Membaca Buku Fiksi / Filosofi', 'Relaksasi pikiran sebelum tidur tanpa menggunakan gadget', 'Everyday', 20),
(2, 'Digital Detox', 'Mematikan semua layar gadget 30 menit sebelum tidur', 'Everyday', 30);

INSERT INTO `routine_logs` (`routine_id`, `log_date`, `status`, `notes`) VALUES
(1, CURDATE(), 'Completed', 'Muka terasa sangat segar!'),
(2, CURDATE(), 'Completed', 'Berhasil stretching 20 menit'),
(6, CURDATE(), 'Pending', '');
