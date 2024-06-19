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
} else if (($_SERVER['REQUEST_METHOD'] === 'POST' && array_key_exists('_method', $_POST)) && $_POST['_method'] === 'put') {
    $errors = [];
    $image_urls = [];

    $files = $_FILES['files'];

    $folder = "uploads/";
    $names = $files['name'];
    $tmp_names = $files['tmp_name'];
    $sizes = $files['size'];
    $fileErrors = $files['error'];
    $types = $files['type'];


    for ($i = 0; $i < count($names); $i++) {
        $fileName = $names[$i];
        $fileTmpName = $tmp_names[$i];
        $fileSize = $sizes[$i];
        $fileError = $fileErrors[$i];
        $fileType = $types[$i];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'png', 'jpeg');

        if ($_FILES['files']['name'][0] != "") {
            if (in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = $folder . $fileNameNew;
                        $image_urls[] = $fileDestination;
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
        }
    }

    try {
        require_once "./model/product.model.php";
        require_once "./model/order.model.php";
        require_once "./model/cart.model.php";

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $unit_price = $_POST['unit_price'];
        $product_desc = $_POST['product_desc'];
        $quantity = $_POST['quantity'];
        $variations = $_POST['variations'];
        $new_variations = [];
        if (array_key_exists('new_variations', $_POST)) {
            $new_variations = $_POST['new_variations'];
        }


        //Compiling Data into single array        
        $data = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'unit_price' => $unit_price,
            'product_desc' => $product_desc
        ];

        //Error Handlers

        if (is_input_empty($data)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if (count($variations) == 0) {
            $errors["no_variant"] = "Please add variations of the product!";
        }

        if ($errors) {
            $_SESSION["errors"] = $errors;

            $_SESSION["signup_data"] = $data;
            var_dump($errors);
            die();
        }


        update_product($pdo, $data);
        update_quantity($pdo, $data['product_id'], $quantity);

        if ($image_urls) {
            update_images($pdo, $image_urls, $data['product_id']);
        }

        $old_variation_ids = get_variations_id($pdo, $data['product_id']);
        $current_variation_ids = [];



        for ($i = 0; $i < count($variations); $i = $i + 3) {
            $variation_id = $variations[$i]['variation_id'];
            $current_variation_ids[] = $variation_id;
            $color = $variations[$i + 1]['color'];
            $variation_name = $variations[$i + 2]['name'];
            $variation = [
                'variation_id' => $variation_id,
                'color' => $color,
                'variation_name' => $variation_name
            ];
            update_variation($pdo, $variation);
        }

        foreach ($old_variation_ids as $old_id) {
            $id = (string) $old_id['variation_id'];
            if (!in_array($id, $current_variation_ids)) {
                remove_order_variation($pdo, $id);
                remove_cart_variation($pdo, $id);
                delete_variation($pdo, $id);
            }
        }

        for ($i = 0; $i < count($new_variations); $i = $i + 2) {
            $color = $new_variations[$i]['color'];
            $name = $new_variations[$i + 1]['name'];
            set_color($pdo, $data['product_id'], $color, $name);
        }

        header("Location: /admin?form=success");
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->GetMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $image_urls = [];

    $files = $_FILES['files'];

    $folder = "uploads/";
    $names = $files['name'];
    $tmp_names = $files['tmp_name'];
    $sizes = $files['size'];
    $fileErrors = $files['error'];
    $types = $files['type'];

    if ($_FILES['files']['name'][0] == "") {
        $errors['no_image'] = "Please upload an image!";
    }

    for ($i = 0; $i < count($names); $i++) {
        $fileName = $names[$i];
        $fileTmpName = $tmp_names[$i];
        $fileSize = $sizes[$i];
        $fileError = $fileErrors[$i];
        $fileType = $types[$i];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'png', 'jpeg');

        if (in_array($fileActualExt, $allowed)) {
            if($fileError === 0) {
                if ($fileSize < 10000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = $folder . $fileNameNew;
                    $image_urls[] = $fileDestination;
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
    }


   

    try {
        require_once "./model/product.model.php";
        require_once "./model/user.model.php";


        //Collection of Data
        $product_name = $_POST['product_name'];
        $unit_price = $_POST['unit_price'];
        $product_desc = $_POST['product_desc'];
        $quantity = $_POST['quantity'];
        $variations = $_POST['variations'];


        //Compiling Data into single array
        $data = [
            'product_name' => $product_name,
            'unit_price' => $unit_price,
            'product_desc' => $product_desc,
            'quantity' => $quantity
        ];

        //Error Handlers

        if (is_input_empty($data)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if (count($variations) == 0) {
            $errors["no_variant"] = "Please add variations of the product!";
        }


        if ($errors) {
            $_SESSION["errors"] = $errors;

            $_SESSION["signup_data"] = $data;
            var_dump($errors);
            die();
        }

        //set_product

        $product = set_product($pdo, $data);

        foreach ($image_urls as $image_url) {
            set_image($pdo, $product['product_id'], $image_url);
        }


        for ($i = 0; $i < count($variations); $i = $i + 2) {
            $color = $variations[$i]['color'];
            $name = $variations[$i + 1]['name'];
            set_color($pdo, $product['product_id'], $color, $name);
        }

        $pdo = null;
        $stmt = null;

        header("Location: /admin?form=success");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->GetMessage());
    }
}