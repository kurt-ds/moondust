<?php

$heading = "Products";

function is_input_empty($data): bool {
  forEach ($data as $key => $value) {
      if (!isset($data[$key]) || strlen($data[$key]) === 0) {
          return true;
      }
  }
  return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once "./model/product.model.php";

    $products = get_all_products($pdo);

    require "views/products.view.php";
    $pdo = null;
    $stmt = null;
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $errors = [];
  //Managing the image
  $image_url = '';
  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg', 'png', 'jpeg');

  if (in_array($fileActualExt, $allowed)) {
      if($fileError === 0) {
          if ($fileSize < 10000000) {
              $fileNameNew = uniqid('', true) . "." . $fileActualExt;
              $fileDestination = 'uploads/' . $fileNameNew;
              $image_url = $fileDestination;
              move_uploaded_file($fileTmpName, $fileDestination);
          } else {
              $errors['file_too_big'] = 'File is too big!';
          }   
      } else {
          $errors['unexpected_error'] = 'There was a problem in uploading the file!';
      }
  } else {
      $errors['invalid_file_type'] = 'Invalid File Type!';
  }
   

  try {
    require_once "./model/product.model.php";
    require_once "./model/user.model.php";


    //Collection of Data
    $product_name = $_POST['product_name'];
    $unit_price = $_POST['unit_price'];
    $product_desc = $_POST['product_desc'];


    //Compiling Data into single array
    $data = [
        'product_name' => $product_name,
        'unit_price' => $unit_price,
        'product_desc' => $product_desc,
        'image_url' => $image_url,
    ];

    //Error Handlers

    if (is_input_empty($data)) {
        $errors["empty_input"] = "Fill in all fields!";
    }


    if ($errors) {
        $_SESSION["errors"] = $errors;

        $_SESSION["signup_data"] = $data;
        var_dump($errors);
        die();
    }

    //set_product

    set_product($pdo, $data);

    $pdo = null;
    $stmt = null;

    header("Location: /admin?form=success");
    die();
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}
}