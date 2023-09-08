
DROP TABLE IF EXISTS "country";

CREATE TABLE IF NOT EXISTS "country" (
	id serial PRIMARY KEY NOT NULL,
	name varchar(50) NOT NULL,
	capital varchar(50) NOT NULL,
	population int
);

DROP TABLE IF EXISTS "user";

CREATE TABLE IF NOT EXISTS "user" (
	id serial PRIMARY KEY NOT NULL,
	firstname varchar(50) NOT NULL,
	lastname varchar(50) NOT NULL,
	email varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	comment text
);
