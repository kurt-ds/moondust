<?php
 
$heading = "Product";
$product_id = $params['product_id'];



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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
  if (!isLoggedIn()) {
    header("Location: /login");
  }

  if (!isAdmin()) {
    header('Location: /products?error=unauthorized');
  }

  try {
    require_once './model/product.model.php';
    require_once './model/cart.model.php';
    require_once './model/order.model.php';

    $variations = get_variations_by_id($pdo, $product_id);

    foreach ($variations as $variation) {
      $variation_id = $variation['variation_id'];
      remove_order_variation($pdo, $variation_id);
      remove_cart_variation($pdo, $variation_id);
    }

    delete_images_by_id($pdo, $product_id);
    delete_variations_by_id($pdo, $product_id);
    delete_inventory($pdo, $product_id);
    $orders = delete_order_by_product($pdo, $product_id);
    $carts = delete_cart_by_product($pdo, $product_id);

    foreach ($orders as $order) {
      $order_id = $order['order_id'];
      $no_of_order_items = count_order_items($pdo, $order_id);
      $order_items = get_order_items($pdo, $order_id);
      $order_total = 0;
      foreach ($order_items as $order_item) {
        $order_total = $order_total + $order_item['order_price'];
      }

      if ($order_total === 0) {
        delete_order($pdo, $order_id);
      } else {
        update_order_total($pdo, $order_id, $order_total);
      }
    }

    delete_product($pdo, $product_id);
  
    header("Location: /admin?delete=success");
    
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
  }
}
