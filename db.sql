CREATE DATABASE `galerie` /*!40100 CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

CREATE TABLE `bilder` (  `id` INT(10) NOT NULL AUTO_INCREMENT,  `originalname` VARCHAR(50) NOT NULL,  `vorschauname` VARCHAR(50) NULL DEFAULT NULL,  `filetype` VARCHAR(50) NOT NULL,  `timestamp` DATETIME NOT NULL,  PRIMARY KEY (`id`) ) COLLATE='latin1_swedish_ci' ENGINE=InnoDB ROW_FORMAT=DEFAULT;