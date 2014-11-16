DROP TABLE IF EXISTS spaceObject;
CREATE TABLE spaceObject (
	name VARCHAR(255),
	radius int,
	mass int,
	EarthDistance int,
	age int,
	rotationSpeed int,
	galaxyName VARCHAR(255),
	galaxyType VARCHAR(255)
);

DROP TABLE IF EXISTS star;
CREATE TABLE star (
	OName VARCHAR(255),
	starType VARCHAR(255),
	color VARCHAR(255)
);

DROP TABLE IF EXISTS planet;
CREATE TABLE planet (
	OName VARCHAR(255),
	isLiveable Bool,
	hasWater Bool,
	hasAtmosphere Bool,
	planetarySystemName VARCHAR(255)
);

DROP TABLE IF EXISTS moon;
CREATE TABLE moon (
	name VARCHAR(255),
	Pname VARCHAR(255)
);

DROP TABLE IF EXISTS planetarySystem;
CREATE TABLE planetarySystem (
	name VARCHAR(255),
	starName VARCHAR(255),
	description LONGTEXT
);
	
DROP TABLE IF EXISTS user;
CREATE TABLE user (
	ID int,
	login VARCHAR(255),
	name VARCHAR(255),
	password VARCHAR(255),
	placeOfBirth VARCHAR(255)
);

DROP TABLE IF EXISTS saleInstance;
CREATE TABLE saleInstance(
	buyerID int,
	sellerID int,
	OName VARCHAR(255),
	initPrice int,
	finalPrice int,
	saleDateTime DATETIME,
	isCompleted Bool
);

DROP TABLE IF EXISTS buyOffer;
CREATE TABLE buyOffer (
	buyerID int,
	offeredPrice int,
	OName VARCHAR(255),
	sellerID int
);