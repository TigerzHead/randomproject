-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Databasestructuur van zend_crud wordt geschreven
CREATE DATABASE IF NOT EXISTS `zend_crud` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `zend_crud`;


-- Structuur van  tabel zend_crud.chat wordt geschreven
CREATE TABLE IF NOT EXISTS `chat` (
  `cid` int(9) NOT NULL AUTO_INCREMENT,
  `uid` int(9) NOT NULL,
  `post` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `uid` (`uid`),
  CONSTRAINT `chat > users` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=latin1;

-- Dumpen data van tabel zend_crud.chat: ~6 rows (ongeveer)
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` (`cid`, `uid`, `post`, `date`) VALUES
	(242, 7, '"<h1> hallo </h1>"', '2015-06-10 11:05:06'),
	(243, 7, '"<script>alert(\\"hallo\\")</script>"', '2015-06-10 11:05:29'),
	(244, 7, '"hallo"', '2015-06-10 12:11:48'),
	(245, 7, 'hallo', '2015-06-10 12:12:22'),
	(246, 7, '<h1> hallo </h1>', '2015-06-10 12:12:28'),
	(247, 7, '<script>alert("hallo")</script>', '2015-06-10 12:12:54'),
	(248, 7, 'echo ', '2015-06-10 12:13:03'),
	(249, 7, 'blabla', '2015-06-10 14:37:55');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
