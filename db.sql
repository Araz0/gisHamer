-- create database gishamer_intranet;
-- truncate users;
CREATE TABLE users(
    ID serial PRIMARY KEY NOT NULL,
    username VARCHAR(255) NOT NULL,
    sec_question VARCHAR(255) NOT NULL,
    sec_answer VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE news(
    ID serial PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    create_date DATE NOT NULL DEFAULT CURRENT_DATE,
    edit_date DATE
);

CREATE TABLE categories(
    ID serial PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    icon VARCHAR(255),
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