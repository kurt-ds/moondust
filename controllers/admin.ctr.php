<?php

$heading = "ADMIN PAGE";



//added count details on products and users

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once "./model/product.model.php";
    require_once "./model/admin.model.php";
    require_once "./model/order.model.php";
   
    

    $products = get_all_admin_products($pdo);
    $product_count = get_product_count($pdo);
    $userCount = get_users($pdo);
    $orders = get_all_orders($pdo);
    foreach($orders as $key => $order) {
      $orders[$key]['order_items'] = get_order_items($pdo, $order['order_id']);
    }

    require "views/admin.view.php";
    $pdo = null;
    $stmt = null;


    
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
}