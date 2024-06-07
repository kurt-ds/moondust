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

CREATE TABLE product (
	product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    unit_price DECIMAL(8,2) NOT NULL,
    product_desc TEXT NOT NULL
);

CREATE TABLE product_image (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

