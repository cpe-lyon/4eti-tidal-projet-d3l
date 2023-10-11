
DROP TABLE IF EXISTS "country";


CREATE TABLE IF NOT EXISTS "country" (
	id integer PRIMARY KEY NOT NULL,
	name char(50) NOT NULL,
	capital char(50) NOT NULL,
	population integer NOT NULL
);

DROP TABLE IF EXISTS "user";


CREATE TABLE IF NOT EXISTS "user" (
	id integer PRIMARY KEY NOT NULL,
	firstname char(50) NOT NULL,
	lastname char(50) NOT NULL,
	email char(50) NOT NULL,
	password char(50) NOT NULL,
	comment text NOT NULL
);
