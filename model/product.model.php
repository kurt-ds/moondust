<?php

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function set_product(object $pdo, array $data) {
  $query = "INSERT INTO product (product_name, unit_price, product_desc) VALUES (:product_name, :unit_price, :product_desc);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->bindParam(":unit_price", $data['unit_price']);
  $stmt->bindParam(":product_desc", $data['product_desc']);

  $stmt->execute();
  $query = "SELECT * FROM product WHERE product_name = :product_name;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $product_id = $result['product_id'];
  $item_total = $data['stock_available'] * $data['unit_price'];

  $query = "INSERT INTO inventory_item (product_id, stock_available, item_total) VALUES (:product_id, :stock_available, :item_total);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id",  $product_id);
  $stmt->bindParam(":stock_available", $data['stock_available']);
  $stmt->bindParam(":item_total", $item_total);

  $stmt->execute();


  return $result;
}


function get_all_products(object $pdo) {
  $query = "SELECT p.*, pi.image_url AS main_image 
FROM product p
LEFT JOIN (
  SELECT product_id, MIN(image_id) AS min_id
  FROM product_image
  GROUP BY product_id
) AS min_image ON p.product_id = min_image.product_id
LEFT JOIN product_image pi ON min_image.min_id = pi.image_id;";
  $stmt = $pdo->prepare($query);

  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_all_admin_products(object $pdo) {
  $query = "SELECT p.*, pi.image_url AS main_image, ii.stock_available, ii.item_total
FROM product AS p
LEFT JOIN (
  SELECT product_id, MIN(image_id) AS min_id
  FROM product_image
  GROUP BY product_id
) AS min_image ON p.product_id = min_image.product_id
LEFT JOIN product_image AS pi ON min_image.min_id = pi.image_id
LEFT JOIN inventory_item AS ii ON p.product_id = ii.product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_product_by_name(object $pdo, string $product_name) {
  $query = "SELECT product_id FROM product WHERE product_name = :product_name;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function set_image(object $pdo, $product_id ,string $image_url) {
  $query = "INSERT INTO product_image (product_id, image_url) VALUES (:product_id, :image_url);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->bindParam(":image_url", $image_url);

  $stmt->execute();
}

function set_color(object $pdo, $product_id, $color, $name) {
  $query = "INSERT INTO variation (product_id, variation_name, color) VALUES (:product_id, :variation_name, :color);";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->bindParam(":variation_name", $name);
  $stmt->bindParam(":color", $color);

  $stmt->execute();
}

function get_product_by_id(object $pdo, $product_id) {
  $query = "SELECT * FROM product WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function get_images_by_id(object $pdo, $product_id) {
  $query = "SELECT image_url FROM product_image WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_variations_by_id(object $pdo, $product_id) {
  $query = "SELECT * FROM variation WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_variations_id(object $pdo, $product_id) {
  $query = "SELECT variation_id FROM variation WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function get_quantity_by_id(object $pdo, $product_id) {
  $query = "SELECT stock_available FROM inventory_item WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function delete_images_by_id(object $pdo, $product_id) {
  $images = get_images_by_id($pdo, $product_id);
  foreach ($images as $image) {
    unlink($image['image_url']);
  }
  $query = "DELETE FROM product_image where product_id = :product_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_variations_by_id(object $pdo, $product_id) {
  $query = "DELETE FROM variation where product_id = :product_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_product(object $pdo, array $data) {
  $query = "UPDATE product SET product_name = :product_name, unit_price = :unit_price, product_desc = :product_desc WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $data['product_id']);
  $stmt->bindParam(":product_name", $data['product_name']);
  $stmt->bindParam(":unit_price", $data['unit_price']);
  $stmt->bindParam(":product_desc", $data['product_desc']);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_quantity(object $pdo, $product_id, $stock_available) {
  $product = get_product_by_id($pdo, $product_id);
  $item_total = $stock_available * $product['unit_price'];
  $query = "UPDATE inventory_item SET stock_available = :stock_available, item_total = :item_total WHERE product_id = :product_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->bindParam(":stock_available", $stock_available);
  $stmt->bindParam(":item_total", $item_total);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_images(object $pdo, array $image_urls, $product_id) {
  delete_images_by_id($pdo, $product_id);
  foreach ($image_urls as $image_url) {
    set_image($pdo, $product_id, $image_url);
  }
}

function update_variations(object $pdo, array $variations, $product_id) {

  delete_variations_by_id($pdo, $product_id);
  for ($i = 0; $i < count($variations); $i = $i + 2) {
    $color = $variations[$i]['color'];
    $name = $variations[$i + 1]['name'];
    set_color($pdo, $product_id, $color, $name);
  }
}

function update_variation(object $pdo, array $data) {
  $query = "UPDATE variation SET variation_name = :variation_name, color = :color WHERE variation_id = :variation_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":variation_name", $data['variation_name']);
  $stmt->bindParam(":color", $data['color']);
  $stmt->bindParam(":variation_id", $data['variation_id']);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_product(object $pdo, $product_id) {
  $query = "DELETE FROM product where product_id = :product_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_inventory(object $pdo, $product_id) {
  $query = "DELETE FROM inventory_item where product_id = :product_id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":product_id", $product_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_variation(object $pdo, $variation_id) {
  $query = "DELETE FROM variation where variation_id = :variation_id;";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(":variation_id", $variation_id);
  $stmt->execute();

  $stmt->fetch(PDO::FETCH_ASSOC);
}


// function update_inventory(object $pdo, array $data. $stock_available) {
//   $product = get_product_by_id($pdo, $data['product_id']);
//   $stock_available = get_quantity_by_id($pdo, $data['product_id']);
//   $new_quantity = $stock_available['stock_available'] - $data['stock_available'];
//   $item_total = $new_quantity * $product['unit_price'];
//   $query = "UPDATE inventory_item SET stock_available = stock_available - :stock_available, item_total = :item_total WHERE product_id = :product_id;";
//   $stmt = $pdo->prepare($query);

//   $stmt->bindParam(":product_id", $product_id);
//   $stmt->bindParam(":stock_available", $new_quantity);
//   $stmt->bindParam(":item_total", $item_total);
//   $stmt->execute();

//   $stmt->fetch(PDO::FETCH_ASSOC);
// }