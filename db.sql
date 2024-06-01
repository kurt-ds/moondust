CREATE DATABASE moondust;

USE moondust;

CREATE TABLE user (
	user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
   	contact_no VARCHAR(35) NOT NULL,
    address VARCHAR(255) NOT NULL
);

