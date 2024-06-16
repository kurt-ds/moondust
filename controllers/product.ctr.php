<?php
 
$heading = "Product";
$product_id = $params['product_id'];



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (!isLoggedIn()) {
    header("Location: /login");
  }
  try {
    require_once './model/product.model.php';

    $product = get_product_by_id($pdo, $product_id);
    $images = get_images_by_id($pdo, $product_id);
    $variations = get_variations_by_id($pdo, $product_id);
    $quantity = get_quantity_by_id($pdo, $product_id);
  
    require "views/product.view.php";
    
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['_method'] == 'delete') {
  try {
    require_once './model/product.model.php';

    delete_images_by_id($pdo, $product_id);
    delete_variations_by_id($pdo, $product_id);
    delete_inventory($pdo, $product_id);
    delete_product($pdo, $product_id);
  
    header("Location: /admin?delete=success");
    
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
  }
}
