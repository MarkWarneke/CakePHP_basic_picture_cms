CREATE DATABASE IF NOT EXISTS d0166923;

USE d0166923;

CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	publisher boolean not null default 0,
	created DATETIME,
	modified DATETIME
);

CREATE TABLE IF NOT EXISTS pictures (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(50),
	description TEXT,
	path VARCHAR(255) NOT NULL,
	thumb VARCHAR(255),
	created DATETIME,
	modified DATETIME
);

CREATE TABLE IF NOT EXISTS tags (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255),
	created DATETIME,
	modified DATETIME,
	UNIQUE KEY(title)
); 

CREATE TABLE IF NOT EXISTS pictures_tags (
	picture_id INT NOT NULL,
	tag_id INT NOT NULL,
	PRIMARY KEY (picture_id, tag_id),
	FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),
	FOREIGN KEY picture_key(picture_id) REFERENCES pictures(id)
);


	
