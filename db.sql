create database gishamer_intranet;

CREATE TABLE users(
    ID serial PRIMARY KEY NOT NULL,
	username VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL
);

CREATE TABLE news(
    ID serial PRIMARY KEY NOT NULL,
	title VARCHAR(255) NOT NULL,
	message TEXT NOT NULL,
	posting_date DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE categories(
    ID serial PRIMARY KEY NOT NULL,
	title VARCHAR(255) NOT NULL,
	icon VARCHAR(255) NOT NULL,
	type VARCHAR(255) NOT NULL,
    category_id INTEGER REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE entries(
    ID serial PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
	link VARCHAR(255) NOT NULL,
	info TEXT NOT NULL,
    color VARCHAR(255),
	thumbnail VARCHAR(255),
    category_id INTEGER REFERENCES categories(id) ON DELETE CASCADE
);