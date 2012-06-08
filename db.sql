CREATE DATABASE `galerie` /*!40100 CHARACTER SET latin1 COLLATE latin1_swedish_ci */;



CREATE TABLE `bilder` (  `id` INT(10) NOT NULL AUTO_INCREMENT, `productid` INT NOT NULL,  `name` VARCHAR(50) NOT NULL,  `thumbname` VARCHAR(50) NULL DEFAULT NULL, `ismainthumb` INT NOT NULL DEFAULT '0', `filetype` VARCHAR(50) NOT NULL, `description` VARCHAR(500) NULL, `timestamp` DATETIME NOT NULL,  PRIMARY KEY (`id`) ) COLLATE='latin1_swedish_ci' ENGINE=InnoDB ROW_FORMAT=DEFAULT;

CREATE TABLE `products` (  `id` INT(10) NOT NULL AUTO_INCREMENT,  `name` VARCHAR(50) NOT NULL,  `beschreibung` VARCHAR(500) NULL,  PRIMARY KEY (`id`) ) COLLATE='latin1_swedish_ci' ENGINE=InnoDB ROW_FORMAT=DEFAULT;