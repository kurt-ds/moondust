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


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once "./model/cart.model.php";

    $cart_items = get_cart_by_id($pdo, $_SESSION['user_id']);


    require "views/cart.view.php";

    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
} else if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) && $_POST['_method'] == 'delete') {
  $cart_id = $_POST['cart_id'];
  try {
    require_once "./model/cart.model.php";

    delete_cart($pdo, $cart_id);

    header("Location: /cart?delete=success");
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
      die("Query failed: " . $e->GetMessage());
  }
} else if (($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) && $_POST['_method'] == 'put') {
  try {
    require_once "./model/cart.model.php";
    require_once "./model/product.model.php";


    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $user_id = $_POST['user_id'];
    $cart = get_cart($pdo, $cart_id);
    $product = get_product_by_id($pdo, $cart['product_id']);
    $cart_total = $cart_quantity * $product['unit_price'];

    $data = [
      'cart_id' => $cart_id,
      'cart_quantity' => $cart_quantity,
      'cart_total' => $cart_total   
    ];

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

    update_cart($pdo, $data);

    header("Location: /cart?update=success");
    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
      die("Query failed: " . $e->GetMessage());
  }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $variation_id = $_POST['variation_id'];
  $product_id = $_POST['product_id'];
  $user_id = $_POST['user_id'];
  $cart_quantity = $_POST['cart_quantity'];

  
  try {
    require_once "./model/cart.model.php";
    require_once "./model/product.model.php";

    $product = get_product_by_id($pdo, $product_id);

    $cart_total = $cart_quantity * $product['unit_price'];



    //Compiling Data into single array        
    $data = [
        'product_id' => $product_id,
        'user_id' => $user_id,
        'variation_id' => $variation_id,
        'cart_quantity' => $cart_quantity,
        'cart_total' => $cart_total
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