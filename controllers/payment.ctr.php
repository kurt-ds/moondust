<?php

$heading = "Payment";

if (!isLoggedIn()) {
  header("Location: /login");
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  require "views/order.view.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    require_once "./model/cart.model.php";

    $selected_items = $_POST['selected_items'];
    $cart_items = [];
    foreach ($selected_items as $cart_id) {
      $cart_items[] = get_full_cart($pdo, $cart_id);
    }

    $count = count($cart_items);
    $subtotal  = 0;
    $shipping_fee = 59;

    foreach($cart_items as $cart_item) {
      $subtotal = $subtotal + $cart_item['cart_total'];
    }



    require "views/payment.view.php";

    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
}