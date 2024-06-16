<?php

$heading = "Order";

function is_input_empty($data): bool {
  forEach ($data as $key => $value) {
      if (!isset($data[$key]) || strlen($data[$key]) === 0) {
          return true;
      }
  }
  return false;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  require "views/order.view.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    require_once "./model/cart.model.php";
    require_once "./model/order.model.php";
    require_once "./model/product.model.php";

    $user_id = $_POST['user_id'];
    $status = 1;
    $order_total = $_POST['total_price'];
    $cart_items = $_POST['cart_items'];
    $order_items = [];

    foreach ($cart_items as $cart_id) {
      $order_items[] = get_cart($pdo, $cart_id);
    }

    $data = [
      'user_id' => $user_id,
      'status' => $status,
      'order_total' => $order_total
    ];

    $errors = [];

    if (is_input_empty($data)) {
      $errors["empty_input"] = "Fill in all fields!";
    }

    //Update Inventory to new stock and new total_price
    foreach ($order_items as $order_item) {
      $current_quantity = get_quantity_by_id($pdo, $order_item['product_id'])['quantity'];
      if ($current_quantity < $order_item['quantity']) {
        $errors['Stock Unavaialable'] = 'No stock available for that quantity!';
        break;
      }
      $new_quantity = $current_quantity - $order_item['quantity'];
      update_quantity($pdo, $order_item['product_id'], $new_quantity);
    }

    if ($errors) {
      $_SESSION["errors"] = $errors;

      $_SESSION["signup_data"] = $data;
      var_dump($errors);
      die();
    }


    $order_id = set_order($pdo, $data);

    foreach ($order_items as $order_item) {
      set_order_item($pdo, $order_item, $order_id);
    }

    foreach ($cart_items as $cart_id) {
      delete_cart($pdo, $cart_id);
    }


    header("Location: /products?order=success");
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
      die("Query failed: " . $e->GetMessage());
  }
}