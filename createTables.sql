DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `buyOffer`;
DROP TABLE IF EXISTS `saleInstance`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `moon`;
DROP TABLE IF EXISTS `planet`;
DROP TABLE IF EXISTS `planetarySystem`;
DROP TABLE IF EXISTS `star`;
DROP TABLE IF EXISTS `spaceObject`;

CREATE TABLE `spaceObject` (
	`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`radius` INT(11) NULL DEFAULT NULL,
	`mass` INT(11) NULL DEFAULT NULL,
	`EarthDistance` INT(11) NULL DEFAULT NULL,
	`age` INT(11) NULL DEFAULT NULL,
	`rotationSpeed` INT(11) NULL DEFAULT NULL,
	`galaxyName` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`galaxyType` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`name`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `star` (
	`OName` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`starType` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`color` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`OName`),
	CONSTRAINT `star_ibfk_1` FOREIGN KEY (`OName`) REFERENCES `spaceObject` (`name`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `planetarySystem` (
	`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`starName` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`description` LONGTEXT NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`name`),
	INDEX `starName` (`starName`),
	CONSTRAINT `planetarySystem_ibfk_1` FOREIGN KEY (`starName`) REFERENCES `star` (`OName`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `planet` (
	`OName` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`isLiveable` TINYINT(1) NOT NULL DEFAULT '0',
	`hasWater` TINYINT(1) NOT NULL DEFAULT '0',
	`hasAtmosphere` TINYINT(1) NOT NULL DEFAULT '0',
	`planetarySystemName` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`OName`),
	INDEX `planetarySystemName` (`planetarySystemName`),
	CONSTRAINT `planet_ibfk_1` FOREIGN KEY (`OName`) REFERENCES `spaceObject` (`name`),
	CONSTRAINT `planet_ibfk_2` FOREIGN KEY (`planetarySystemName`) REFERENCES `planetarySystem` (`name`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `moon` (
	`name` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`Pname` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`name`, `Pname`),
	INDEX `Pname` (`Pname`),
	CONSTRAINT `moon_ibfk_1` FOREIGN KEY (`Pname`) REFERENCES `planet` (`OName`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `user` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`fname` VARCHAR(255) COLLATE 'utf8_unicode_ci',
	`lname` VARCHAR(255) COLLATE 'utf8_unicode_ci',
	`password` VARCHAR(255) COLLATE 'utf8_unicode_ci',
	`placeOfBirth` VARCHAR(255) COLLATE 'utf8_unicode_ci',
	`gender` VARCHAR(255) COLLATE 'utf8_unicode_ci',
	PRIMARY KEY (`ID`, `login`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `saleInstance` (
	`buyerID` INT(11) NULL DEFAULT NULL,
	`sellerID` INT(11) NOT NULL DEFAULT '0',
	`OName` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`initPrice` INT(11) NOT NULL,
	`finalPrice` INT(11) NOT NULL,
	`offerDateTime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`saleDateTime` DATETIME NULL DEFAULT NULL,
	`isCompleted` TINYINT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`sellerID`, `offerDateTime`, `OName`),
	INDEX `buyerID` (`buyerID`),
	INDEX `OName` (`OName`),
	CONSTRAINT `saleInstance_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `user` (`ID`),
	CONSTRAINT `saleInstance_ibfk_2` FOREIGN KEY (`sellerID`) REFERENCES `user` (`ID`),
	CONSTRAINT `saleInstance_ibfk_3` FOREIGN KEY (`OName`) REFERENCES `spaceObject` (`name`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `buyOffer` (
	`buyerID` INT(11) NOT NULL DEFAULT '0',
	`offeredPrice` INT(11) NULL DEFAULT NULL,
	`OName` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8_unicode_ci',
	`sellerID` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`buyerID`, `OName`, `sellerID`),
	INDEX `OName` (`OName`),
	INDEX `sellerID` (`sellerID`),
	CONSTRAINT `buyOffer_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `user` (`ID`),
	CONSTRAINT `buyOffer_ibfk_2` FOREIGN KEY (`OName`) REFERENCES `spaceObject` (`name`),
	CONSTRAINT `buyOffer_ibfk_3` FOREIGN KEY (`sellerID`) REFERENCES `saleInstance` (`sellerID`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

CREATE TABLE `sessions` (
  `id` varchar(32) NOT NULL,
  `access` int(10) unsigned DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
