CREATE DATABASE moondust;

USE moondust;

CREATE TABLE role (
  role_id INT PRIMARY KEY AUTO_INCREMENT,
  role_name VARCHAR(35) NOT NULL
);

INSERT INTO role (role_id, role_name) VALUES
(1, 'user'),
(2, 'admin');

CREATE TABLE `user` (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  pwd VARCHAR(255) NOT NULL,
  contact_no VARCHAR(35) NOT NULL UNIQUE,
  address VARCHAR(255) NOT NULL,
  role_id INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE product (
  product_id INT PRIMARY KEY AUTO_INCREMENT,
  product_name VARCHAR(100) UNIQUE NOT NULL,
  unit_price DECIMAL(8,2) NOT NULL,
  product_desc TEXT NOT NULL
);

CREATE TABLE product_image (
  image_id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE variation (
  variation_id INT PRIMARY KEY AUTO_INCREMENT,  -- Added primary key for variation table
  product_id INT NOT NULL,
  variation_name VARCHAR(35) NOT NULL,
  color VARCHAR(35) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE inventory_item (
  inventory_id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  stock_available INT NOT NULL,
  item_total DECIMAL(8,2) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE cart_item (
  cart_id INT PRIMARY KEY AUTO_INCREMENT,
  product_id INT NOT NULL,
  user_id INT NOT NULL,
  variation_id INT NULL,
  cart_quantity INT NOT NULL,
  cart_total DECIMAL(8, 2) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id),
  FOREIGN KEY (user_id) REFERENCES `user`(user_id),
  FOREIGN KEY (variation_id) REFERENCES variation(variation_id)
);

CREATE TABLE order_status (
  status_id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  CONSTRAINT unique_name UNIQUE (name)
);

CREATE TABLE c_order (
  order_id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  status INT NOT NULL,
  order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  order_total DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES `user`(user_id),
  FOREIGN KEY (status) REFERENCES order_status(status_id)
);

INSERT INTO order_status (status_id, name, description)
VALUES
  (1, 'Submitted', 'Order is placed by the customer.'),
  (2, 'In Process', 'Order is being processed by the seller (e.g., picking, packing).'),
  (3, 'Shipped', 'Entire order is shipped to the customer.'),
  (4, 'Out for Delivery', 'Package is with the delivery carrier.'),
  (5, 'Delivered', 'Order is delivered to the customer.'),
  (6, 'Completed', 'Order is fulfilled and payment is received.'),
  (7, 'Cancelled', 'Order is cancelled by the customer or seller.'),
  (8, 'Returned', 'Order is returned by the customer.');

CREATE TABLE order_item (
  item_id INT PRIMARY KEY AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  variation_id INT NULL,
  order_quantity INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES c_order(order_id),
  FOREIGN KEY (product_id) REFERENCES product(product_id),
  FOREIGN KEY (variation_id) REFERENCES variation(variation_id)
);
