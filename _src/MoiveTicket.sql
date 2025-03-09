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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.movies: ~2 rows (approximately)
INSERT IGNORE INTO `movies` (`movie_id`, `name`, `price`, `director`, `category_Id`, `description`, `image`, `status_id`) VALUES
	(23, 'ฟหกasdawdฟ', 50, 'ฟหกฟไ', 1, 'ฟกไกฟ', 'favico.png', 1),
	(24, 'ฟหกฟ', 50, 'ฟหกฟไ', 1, 'ฟกไกฟ', 'favico.png', 3);

-- Dumping structure for table movie_ticket.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `totalPrice` float NOT NULL,
  `movie_id` int(10) NOT NULL,
  `ticketQty` int(10) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `FK_orders_users` (`user_id`),
  KEY `FK_orders_movies` (`movie_id`),
  CONSTRAINT `FK_orders_movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.orders: ~0 rows (approximately)

-- Dumping structure for table movie_ticket.showtimes
DROP TABLE IF EXISTS `showtimes`;
CREATE TABLE IF NOT EXISTS `showtimes` (
  `show_id` int(10) NOT NULL AUTO_INCREMENT,
  `time` varchar(50) DEFAULT NULL,
  `movie_id` int(10) NOT NULL,
  `seats` int(10) NOT NULL DEFAULT 40,
  PRIMARY KEY (`show_id`),
  KEY `FK_showtimes_movies` (`movie_id`),
  CONSTRAINT `FK_showtimes_movies` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.showtimes: ~0 rows (approximately)

-- Dumping structure for table movie_ticket.status
DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT 'Coming',
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table movie_ticket.users: ~2 rows (approximately)
INSERT IGNORE INTO `users` (`user_id`, `username`, `password`, `name`, `email`, `role_id`) VALUES
	(21, 'natt', '2806', 'nattawut', 'nat@email.com', 2),
	(22, 'save', '1234', 'savevenjer', 'savevenjer@gmail.com', 1);

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
