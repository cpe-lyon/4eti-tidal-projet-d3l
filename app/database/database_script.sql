CREATE DATABASE IF NOT EXISTS D3LDatabase;

DROP TABLE IF EXISTS country;

CREATE TABLE IF NOT EXISTS country (
	id int(11) PRIMARY KEY AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	code varchar(255) NOT NULL,
	continent varchar(255) NOT NULL,
	region varchar(255) NOT NULL
);

DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user (
	id int(11) PRIMARY KEY AUTO_INCREMENT,
	firstname varchar(255) NOT NULL,
	lastname varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	comment text
);
