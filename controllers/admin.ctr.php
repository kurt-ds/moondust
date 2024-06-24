<?php

$heading = "ADMIN PAGE";

if (!isLoggedIn()) {
  header("Location: /login");
}

if (!isAdmin()) {
  header('Location: /products?error=unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once "./model/product.model.php";
    require_once "./model/admin.model.php";
    require_once "./model/order.model.php";
    require_once "./model/user.model.php";

    $products = get_all_admin_products($pdo);
    $product_count = get_product_count($pdo);
    $userCount = get_users($pdo);
    $orders = get_all_orders($pdo);
    $statuses = get_order_status($pdo);
    $users = get_all_users($pdo);

    $total_sales = 0;
    $total_orders = count($orders);

    foreach ($orders as $key => $order) {
      $orders[$key]['order_items'] = get_order_items($pdo, $order['order_id']);
      $total_sales += $order['order_total'];
    }

    require "views/admin.view.php";
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists('status_id', $_POST) && array_key_exists('order_id', $_POST)) {
  try {
    require_once "./model/order.model.php";
    require_once "./model/product.model.php";
    
    $status_id = $_POST['status_id'];
    $order_id = $_POST['order_id'];
    
    update_order_status($pdo, $order_id, $status_id);

    if ($status_id == 7) {
      $order_items = get_order_items($pdo, $order_id);
      foreach ($order_items as $order_item) {
          $currentStockAvailable = get_quantity_by_id($pdo, $order_item['product_id'])['stock_available'];
          $newStockAvailable = $currentStockAvailable + $order_item['order_quantity'];
          update_quantity($pdo, $order_item['product_id'], $newStockAvailable);
      }
    }

    header('Location: /admin?status=success');
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists('user_id', $_POST)) {
  try {
    require_once "./model/user.model.php";
    $user_id = $_POST['user_id'];

    make_admin($pdo, $user_id);
    
    header('Location: /admin?makeAdmin=success');
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
}
?>
