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
    product_id INT NOT NULL,
    variation_name VARCHAR(35) NOT NULL,
    color VARCHAR(35) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE inventory_item (
    inventory_id INT PRIMARY KEY AUTO_INCREMENT,
	  product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE cart_item (
	cart_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    variation VARCHAR(35) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(8, 2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
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
  FOREIGN KEY (user_id) REFERENCES user(user_id),
  FOREIGN KEY (status) REFERENCES order_status(status_id)
);

INSERT INTO order_status (status_id, name, description)
VALUES
  (1, 'Submitted', 'Order is placed by the customer.'),
  (2, 'Pending Payment', 'Order is awaiting payment from the customer.'),
  (3, 'Authorized', 'Payment is authorized by the customer\'s bank.'),
  (4, 'In Process', 'Order is being processed by the seller (e.g., picking, packing).'),
  (5, 'On Hold', 'Order processing is paused due to issues (e.g., out of stock).'),
  (6, 'Partially Shipped', 'Part of the order is shipped, the rest is pending.'),
  (7, 'Shipped', 'Entire order is shipped to the customer.'),
  (8, 'Out for Delivery', 'Package is with the delivery carrier.'),
  (9, 'Delivered', 'Order is delivered to the customer.'),
  (10, 'Completed', 'Order is fulfilled and payment is received.'),
  (11, 'Cancelled', 'Order is cancelled by the customer or seller.'),
  (12, 'Returned', 'Order is returned by the customer.');' -- Remove the exta single quote

CREATE TABLE order_item (
  item_id INT PRIMARY KEY AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  variation VARCHAR(35) NOT NULL,  -- Adjust size based on your needs
  quantity INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES c_order(order_id),
  FOREIGN KEY (product_id) REFERENCES product(product_id)
);