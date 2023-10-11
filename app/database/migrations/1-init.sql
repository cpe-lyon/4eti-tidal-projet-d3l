
DROP TABLE IF EXISTS "country";

CREATE TABLE IF NOT EXISTS "country" (
	id serial PRIMARY KEY,
	name char(50) NOT NULL,
	capital char(50) NOT NULL,
	population integer NOT NULL,
	president integer
);

DROP TABLE IF EXISTS "user";

CREATE TABLE IF NOT EXISTS "user" (
	id serial PRIMARY KEY,
	firstname text NOT NULL,
	lastname text NOT NULL,
	email text NOT NULL,
	password text NOT NULL,
	comment text NOT NULL
);

ALTER TABLE "country" ADD CONSTRAINT "country_president_fkey" FOREIGN KEY ("president") REFERENCES "user" ("id");


