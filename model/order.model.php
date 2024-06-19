<?php 

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function set_order(object $pdo, array $data) {
  $query = "INSERT INTO c_order (user_id, status, order_total) VALUES (:user_id, :status, :order_total)";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":user_id", $data['user_id']);
  $stmt->bindParam(":status", $data['status']);
  $stmt->bindParam(":order_total", $data['order_total']);

  $stmt->execute();

  // Get the ID of the newly inserted order
  $new_order_id = $pdo->lastInsertId('c_order'); // Assuming 'c_order' has the auto-incrementing ID

  return $new_order_id;
}

function get_order(object $pdo, $order_id) {
  $query = "SELECT * FROM  WHERE cart_id = :cart_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":cart_id", $cart_id);
  
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function set_order_item(object $pdo, array $data, $order_id) {
  $query = "INSERT INTO order_item (order_id, product_id, variation_id, quantity) VALUES (:order_id, :product_id, :variation_id, :quantity)";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":order_id", $order_id);
  $stmt->bindParam(":product_id", $data['product_id']);
  $stmt->bindParam(":variation_id", $data['variation_id']);
  $stmt->bindParam(":quantity", $data['quantity']);

  $stmt->execute();
}

function get_all_orders(object $pdo) {
  $query = "SELECT o.order_id, u.username, o.status as status_id , o.order_date, o.order_total, s.name as status
FROM c_order AS o
LEFT JOIN order_status as s ON o.status = s.status_id
LEFT JOIN user as u ON o.user_id = u.user_id;";
  $stmt = $pdo->prepare($query);
  
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_order_items(object $pdo, $order_id) {
  $query = "SELECT p.product_name, p.unit_price, oi.quantity, p.unit_price * oi.quantity AS order_price
FROM order_item as oi
JOIN product as p ON oi.product_id = p.product_id
WHERE oi.order_id = :order_id;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":order_id", $order_id);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_orders_by_user(object $pdo, $user_id) {
  $query = "SELECT o.order_id, u.username, o.status as status_id, o.order_date, o.order_total, s.name as status
FROM c_order AS o
LEFT JOIN order_status as s ON o.status = s.status_id
LEFT JOIN user as u ON o.user_id = u.user_id
WHERE o.user_id = :user_id;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function remove_order_variation(object $pdo, $variation_id) {
  $query = "UPDATE order_item SET variation_id = NULL WHERE variation_id = :variation_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":variation_id", $variation_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function cancel_order(object $pdo, $order_id) {
  $query = "UPDATE c_order SET status = 11 WHERE order_id = :order_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":order_id", $order_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_order_status(object $pdo) {
  $query = "SELECT status_id, name FROM order_status;";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function update_order_status(object $pdo, $order_id, $status_id) {
  $query = "UPDATE c_order SET status = :status_id WHERE order_id = :order_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":order_id", $order_id);
  $stmt->bindParam(":status_id", $status_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}