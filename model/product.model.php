<?php

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function set_product(object $pdo, array $data) {
  $query = "INSERT INTO product (product_name, unit_price, product_desc) VALUES (:product_name, :unit_price, :product_desc);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->bindParam(":unit_price", $data['unit_price']);
  $stmt->bindParam(":product_desc", $data['product_desc']);

  $stmt->execute();
  $query = "SELECT * FROM product WHERE product_name = :product_name;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->execute();
  
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}


function get_all_products(object $pdo) {
  $query = "SELECT p.*, pi.image_url AS main_image 
FROM product p
LEFT JOIN (
  SELECT product_id, MIN(image_id) AS min_id
  FROM product_image
  GROUP BY product_id
) AS min_image ON p.product_id = min_image.product_id
LEFT JOIN product_image pi ON min_image.min_id = pi.image_id;";
  $stmt = $pdo->prepare($query);

  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_product_by_name(object $pdo, string $product_name) {
  $query = "SELECT product_id FROM product WHERE product_name = :product_name;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function set_image(object $pdo, $product_id ,string $image_url) {
  $query = "INSERT INTO product_image (product_id, image_url) VALUES (:product_id, :image_url);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->bindParam(":image_url", $image_url);

  $stmt->execute();
}

function set_color(object $pdo, $product_id, $color, $name) {
  $query = "INSERT INTO variation (product_id, variation_name, color) VALUES (:product_id, :variation_name, :color);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->bindParam(":variation_name", $name);
  $stmt->bindParam(":color", $color);

  $stmt->execute();
}

function get_product_by_id(object $pdo, $product_id) {
  $query = "SELECT * FROM product WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function get_images_by_id(object $pdo, $product_id) {
  $query = "SELECT image_url FROM product_image WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_variations_by_id(object $pdo, $product_id) {
  $query = "SELECT variation_name, color FROM variation WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
