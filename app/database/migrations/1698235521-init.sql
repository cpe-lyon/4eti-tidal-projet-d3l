
DROP TABLE IF EXISTS "country";

CREATE TABLE IF NOT EXISTS "country" (
	id serial PRIMARY KEY,
	name text NOT NULL,
	capital text NOT NULL,
	population integer NOT NULL,
	fk_id_user_president int NOT NULL
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

ALTER TABLE "country" ADD CONSTRAINT "country_fk_id_user_president" FOREIGN KEY ("fk_id_user_president") REFERENCES "user" ("id");


