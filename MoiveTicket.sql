-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for movie_ticket
DROP DATABASE IF EXISTS `movie_ticket`;
CREATE DATABASE IF NOT EXISTS `movie_ticket` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `movie_ticket`;

-- Dumping structure for table movie_ticket.category
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.category: ~12 rows (approximately)
INSERT IGNORE INTO `category` (`category_id`, `name`) VALUES
	(1, 'Action'),
	(2, 'Adventure'),
	(3, 'Crime'),
	(4, ' Drama '),
	(5, 'Fantasy'),
	(6, 'History'),
	(7, 'Horror'),
	(8, 'Mystery'),
	(9, 'Romance'),
	(10, ' Sci-fi '),
	(11, 'Thriller'),
	(12, 'Western ');

-- Dumping structure for table movie_ticket.movies
DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `movie_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `director` varchar(50) NOT NULL,
  `category_Id` int(10) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `status_id` int(10) NOT NULL,
  PRIMARY KEY (`movie_id`) USING BTREE,
  KEY `FK_movies_category` (`category_Id`),
  KEY `FK_movies_status` (`status_id`),
  CONSTRAINT `FK_movies_category` FOREIGN KEY (`category_Id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_movies_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.movies: ~6 rows (approximately)
INSERT IGNORE INTO `movies` (`movie_id`, `name`, `price`, `director`, `category_Id`, `description`, `image`, `status_id`) VALUES
	(23, 'Companion | คอมแพเนียน', 99, 'ดรูว์ ฮานค็อก', 7, 'การเสียชีวิตของมหาเศรษฐีพันล้านคนหนึ่ง ได้กลายมาเป็นจุดเริ่มต้นให้เกิดเหตุการณ์มากมายในระหว่างที่ ไอริส และเพื่อนของเธอ มาพักผ่อนช่วงสุดสัปดาห์ที่บ้านหรูริมทะเลสาปของเขา', 'comper.jpg', 1),
	(24, 'Dark Nuns', 99, 'ควอน ฮยอก-แจ', 7, 'พื่อช่วยเหลือเด็กชายที่ถูกวิญญาณร้ายเข้าสิง แม่ชี ยูเนีย ต้องเผชิญกับอันตรายที่คาดไม่ถึง เธอมุ่งมั่นจะช่วยเด็กคนนั้นด้วยความช่วยเหลือจากแม่ชีคาเอลาแม้ว่าจะต้องทำพิธีกรรมต้องห้ามก็ตามท่ามกลางความโกลาหลที่รายล้อมพวกเธอ บาทหลวพอลผู้เป็นนักนักจิตเวชยืนกรานว่า', 'Dacknun.jpg', 1),
	(25, 'The Substance | สวยสลับร่าง', 99, 'กอราลี ฟาร์ฌาต์', 8, 'อลิซาเบธ สปาร์คเกิล’ (เดมี่ มัวร์) เป็นอดีตดาราดังแถวหน้าที่เคยเจิดจรัสในวงการบันเทิง แต่ตอนนี้เธอมีอายุมากขึ้นจนถูกฮาร์วี่ (เดนนิส เดวด)  หัวหน้าสถานีเขี่ยทิ้งจากรายการออกกำลังกายซึ่งเป็นอาชีพสุดท้ายที่เธอเหลืออยู่ในภาวะที่สิ้นหวัง', 'substance.jpg', 1),
	(26, 'มูลู หน้าครู', 99, 'บุญส่ง นาคภู่', 7, 'เมย์ สถาปนิกสาวที่เพิ่งย้ายเข้ามาบ้านใหม่แถวชานเมืองกับ กัน แฟนหนุ่ม ได้รับแจ้งข่าวการตายของ ปอ แม่เลี้ยง โดยมีเพียง นุ่น ลูกสาวของปอให้การว่า มีคนฆ่าแม่ของเธอ แต่ไม่ปรากฏว่ามีพยานหลักฐานใดที่ชี้ชัด', 'mulunaku.jpg', 3),
	(27, 'snowwhite | สโนว์ไวท์', 99, 'Marc Webb', 5, 'ภาพยนตร์ไลฟ์แอคชั่นที่ดัดแปลงมาจากแอนิเมชั่นในปี 1937 ของดิสนีย์ ในชื่อ "สโนวไวท์และคนแคระทั้งเจ็ด" นำแสดงโดย เรเชล เซกเลอร์ (“West Side Story”) ในบทนำ และ กัล การ์ด็อท (“Wonder Woman”) ในบทแม่เลี้ยงใจร้าย ', 'snowwhite.jpg', 3),
	(32, 'naja 2 | นาจา 2', 200, 'Yang Yu', 2, 'หลังจากรับอสนีบาต แม้นาจากับอ๋าวปิ่งจะรอดมาได้ด้วยการกลายเป็นวิญญาณ แต่ในไม่ช้าพวกเขาก็จะต้องสลายหายไป ไท่หยี่จึงวางแผนที่จะสร้างร่างของนาจาและอ๋าวปิ่งขึ้นมาใหม่ด้วยดอกบัววิเศษเจ็ดสี                      ทว่าระหว่างการสร้างร่างก็ได้เกิดอุปสรรคขึ้นมากมาย ม', 'naja2.jpg', 3);

-- Dumping structure for table movie_ticket.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `totalPrice` float NOT NULL,
  `movie_id` int(10) NOT NULL,
  `ticketQty` int(10) NOT NULL,
  `show_id` int(10) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `FK_orders_users` (`user_id`),
  KEY `FK_orders_movies` (`movie_id`),
  KEY `FK_orders_showtimes` (`show_id`),
  CONSTRAINT `FK_orders_movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_orders_showtimes` FOREIGN KEY (`show_id`) REFERENCES `showtimes` (`show_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.orders: ~8 rows (approximately)
INSERT IGNORE INTO `orders` (`order_id`, `user_id`, `totalPrice`, `movie_id`, `ticketQty`, `show_id`) VALUES
	(3, 21, 50, 23, 1, 11),
	(4, 23, 50, 25, 1, 8),
	(5, 21, 50, 23, 1, 11),
	(6, 21, 50, 23, 1, 11),
	(7, 24, 300, 25, 6, 7),
	(8, 21, 99, 25, 1, 7),
	(9, 22, 99, 23, 1, 11),
	(10, 25, 99, 23, 1, 11);

-- Dumping structure for table movie_ticket.showtimes
DROP TABLE IF EXISTS `showtimes`;
CREATE TABLE IF NOT EXISTS `showtimes` (
  `show_id` int(10) NOT NULL AUTO_INCREMENT,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `movie_id` int(10) NOT NULL,
  `seats` int(10) NOT NULL DEFAULT 40,
  PRIMARY KEY (`show_id`),
  KEY `FK_showtimes_movies` (`movie_id`),
  CONSTRAINT `FK_showtimes_movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.showtimes: ~4 rows (approximately)
INSERT IGNORE INTO `showtimes` (`show_id`, `time`, `date`, `movie_id`, `seats`) VALUES
	(7, '20:14:00', '2025-03-05', 25, 40),
	(8, '01:15:00', '2025-03-03', 25, 40),
	(9, '15:32:00', '2025-02-25', 24, 40),
	(11, '10:52:29', '2025-03-10', 23, 40);

-- Dumping structure for table movie_ticket.status
DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'Coming',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.status: ~3 rows (approximately)
INSERT IGNORE INTO `status` (`status_id`, `name`) VALUES
	(1, 'Now'),
	(2, 'Inactive'),
	(3, 'Coming');

-- Dumping structure for table movie_ticket.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` char(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role_id` int(5) NOT NULL DEFAULT 2,
  PRIMARY KEY (`user_id`),
  KEY `FK_users_usertype` (`role_id`),
  CONSTRAINT `FK_users_usertype` FOREIGN KEY (`role_id`) REFERENCES `usertype` (`role_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.users: ~5 rows (approximately)
INSERT IGNORE INTO `users` (`user_id`, `username`, `password`, `name`, `email`, `role_id`) VALUES
	(21, 'natt', '2806', 'nattawut', 'nat@email.com', 2),
	(22, 'save', '1234', 'savevenjer', 'savevenjer@gmail.com', 1),
	(23, 'art', '123456', 'att', 'nftheater142+26@gmail.com', 2),
	(24, 'gun', 'gunkung1234', 'guntinan', 'guntinanprosri@gmail.com', 2),
	(25, 'Pookkie', '2002', 'pookkie', 'pookkie123@gmail.com', 2);

-- Dumping structure for table movie_ticket.usertype
DROP TABLE IF EXISTS `usertype`;
CREATE TABLE IF NOT EXISTS `usertype` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.usertype: ~2 rows (approximately)
INSERT IGNORE INTO `usertype` (`role_id`, `name`) VALUES
	(1, 'admin'),
	(2, 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
