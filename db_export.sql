-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-06-10 22:41:36
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for galerie
DROP DATABASE IF EXISTS `galerie`;
CREATE DATABASE IF NOT EXISTS `galerie` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `galerie`;


-- Dumping structure for table galerie.bilder
DROP TABLE IF EXISTS `bilder`;
CREATE TABLE IF NOT EXISTS `bilder` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `thumbname` varchar(50) DEFAULT NULL,
  `ismainthumb` int(11) NOT NULL DEFAULT '0',
  `filetype` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table galerie.bilder: ~0 rows (approximately)
/*!40000 ALTER TABLE `bilder` DISABLE KEYS */;
INSERT INTO `bilder` (`id`, `productid`, `name`, `thumbname`, `ismainthumb`, `filetype`, `description`, `timestamp`) VALUES
	(4, 3, 'everyday-600x399', 'tn_4', 0, 'jpg', 'Everyday I\'m Schaffnering', '2012-06-09 11:58:10'),
	(5, 2, 'launch-i-said-lunch', 'tn_5', 0, 'jpg', 'Launch? I said lunch', '2012-06-09 11:59:31'),
	(6, 3, 'g2a2q', 'tn_6', 0, 'jpg', NULL, '2012-06-09 12:05:14'),
	(7, 3, 'qunfe', 'tn_7', 0, 'jpg', NULL, '2012-06-09 12:05:14'),
	(8, 3, 'meh-ro7035-455x455', 'tn_8', 0, 'jpg', NULL, '2012-06-09 12:05:14');
/*!40000 ALTER TABLE `bilder` ENABLE KEYS */;


-- Dumping structure for table galerie.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `beschreibung` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table galerie.products: ~0 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `beschreibung`) VALUES
	(1, 'Moped', 'Das ist die Moped Beschreibung'),
	(2, 'Hase', 'Hallo Hase'),
	(3, 'Stuff', 'Das ist der ganze andere Mist');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
