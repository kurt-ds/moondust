<?php 

declare(strict_types=1);

require_once './includes/dbh.inc.php';
require_once './model/product.model.php';
require_once "./model/user.model.php";


function set_cart(object $pdo, array $data) {
  $query = "INSERT INTO cart_item (product_id, user_id, variation_id, quantity, total_price) VALUES (:product_id, :user_id, :variation_id,  :quantity, :total_price)";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $data['product_id']);
  $stmt->bindParam(":user_id", $data['user_id']);
  $stmt->bindParam(":variation_id", $data['variation_id']);
  $stmt->bindParam(":quantity", $data['quantity']);
  $stmt->bindParam(":total_price", $data['total_price']);

  $stmt->execute();
}

function get_cart(object $pdo, $cart_id) {
  $query = "SELECT * FROM cart_item WHERE cart_id = :cart_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":cart_id", $cart_id);
  
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function get_cart_by_id(object $pdo, $user_id) {
  $query = "SELECT c.cart_id, c.user_id, p.product_name, p.unit_price ,c.quantity, v.variation_name as variation, c.total_price, pi.image_url AS main_image
FROM cart_item AS c
LEFT JOIN product as p ON c.product_id = p.product_id
LEFT JOIN (
  SELECT product_id, MIN(image_id) AS min_id
  FROM product_image
  GROUP BY product_id
) AS min_image ON p.product_id = min_image.product_id
LEFT JOIN product_image AS pi ON min_image.min_id = pi.image_id
LEFT JOIN variation as v ON c.variation_id = v.variation_id
WHERE c.user_id = :user_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":user_id", $user_id);
  
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_full_cart(object $pdo, $cart_id) {
  $query = "SELECT c.cart_id, c.user_id, p.product_name, p.unit_price ,c.quantity, v.variation_name as variation, c.total_price, pi.image_url AS main_image
FROM cart_item AS c
LEFT JOIN product as p ON c.product_id = p.product_id
LEFT JOIN (
  SELECT product_id, MIN(image_id) AS min_id
  FROM product_image
  GROUP BY product_id
) AS min_image ON p.product_id = min_image.product_id
LEFT JOIN product_image AS pi ON min_image.min_id = pi.image_id
LEFT JOIN variation as v ON c.variation_id = v.variation_id
WHERE c.cart_id = :cart_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":cart_id", $cart_id);
  
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function delete_cart(object $pdo, $cart_id) {
  $query = "DELETE FROM cart_item where cart_id = :cart_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":cart_id", $cart_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_cart(object $pdo, array $data) {
  $query = "UPDATE cart_item SET quantity = :quantity, total_price = :total_price WHERE cart_id = :cart_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":cart_id", $data['cart_id']);
  $stmt->bindParam(":quantity", $data['quantity']);
  $stmt->bindParam(":total_price", $data['total_price']);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function remove_cart_variation(object $pdo, $variation_id) {
  $query = "UPDATE cart_item SET variation_id = NULL WHERE variation_id = :variation_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":variation_id", $variation_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}



