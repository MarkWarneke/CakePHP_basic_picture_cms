CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	created DATETIME,
	modified DATETIME
);

CREATE TABLE pictures (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(50),
	description TEXT,
	path VARCHAR(255) NOT NULL,
	created DATETIME,
	modified DATETIME
);

CREATE TABLE tags (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255),
	created DATETIME,
	modified DATETIME,
	UNIQUE KEY(title)
);

CREATE TABLE pictures_tags (
	picture_id INT NOT NULL,
	tag_id INT NOT NULL,
	PRIMARY KEY (picture_id, tag_id),
	FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),
	FOREIGN KEY picture_key(picture_id) REFERENCES pictures(id)
);


	
