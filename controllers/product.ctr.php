<?php

$heading = "Product";
$product_id = $params['product_id'];



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once './model/product.model.php';

    $product = get_product_by_id($pdo, $product_id);
    $images = get_images_by_id($pdo, $product_id);
    $variations = get_variations_by_id($pdo, $product_id);

  
    require "views/product.view.php";
    
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
  }
}
