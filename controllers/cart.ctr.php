<?php

$heading = "Cart";

function is_input_empty($data): bool {
  forEach ($data as $key => $value) {
      if (!isset($data[$key]) || strlen($data[$key]) === 0) {
          return true;
      }
  }
  return false;
}

if (!isLoggedIn()) {
  header("Location: /login");
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  try {
    require_once "./model/cart.model.php";

    $cart_items = get_cart_by_id($pdo, $_SESSION['user_id']);


    require "views/cart.view.php";

    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $variation = $_POST['variation'];
  $product_id = $_POST['product_id'];
  $user_id = $_POST['user_id'];
  $quantity = $_POST['quantity'];

  
  try {
    require_once "./model/cart.model.php";
    require_once "./model/product.model.php";

    $product = get_product_by_id($pdo, $product_id);

    $total_price = $quantity * $product['unit_price'];



    //Compiling Data into single array        
    $data = [
        'product_id' => $product_id,
        'user_id' => $user_id,
        'variation' => $variation,
        'quantity' => $quantity,
        'total_price' => $total_price
    ];

    //Error Handlers
    $errors = [];

    if (is_input_empty($data)) {
        $errors["empty_input"] = "Fill in all fields!";
    }


    if ($errors) {
        $_SESSION["errors"] = $errors;

        $_SESSION["signup_data"] = $data;
        var_dump($errors);
        die();
    }

    
    set_cart($pdo, $data);
    header("Location: /cart?form=success");
    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}

}