<?php

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function set_product(object $pdo, array $data) {
  $query = "INSERT INTO product (product_name, unit_price, product_desc, image_url) VALUES (:product_name, :unit_price, :product_desc, :image_url);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->bindParam(":unit_price", $data['unit_price']);
  $stmt->bindParam(":product_desc", $data['product_desc']);
  $stmt->bindParam(":image_url", $data['image_url']);

  $stmt->execute();
}


function get_all_products(object $pdo) {
  $query = "SELECT * FROM product;";
  $stmt = $pdo->prepare($query);

  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

