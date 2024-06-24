<?php

$heading = "SIGN UP";

function is_input_empty(array $data) {
  forEach ($data as $key => $value) {
      if (empty($value)) {
          return true;
      }
  }
  return false;
}

function is_invalid_email(string $email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
  } else {
      return false;
  }
}

function is_email_registered(object $pdo, string $email) {
  if (get_email($pdo, $email)) {
      return true;
  } else {
      return false;
  }
}

function is_username_taken(object $pdo, string $username) {
  if (get_user($pdo, $username)) {
      return true;
  } else {
      return false;
  }
}

function is_number_string(object $pdo, $contact_no ){
  if(!validateNumber($pdo, $contact_no)){
    return true;
  } else {
    return false;
  }
}


if (isLoggedIn()) {
  header('Location: /products?error=alreadyLoggedIn');
}



if ($_SERVER['REQUEST_METHOD'] === "GET") {
  require "views/signup.view.php";
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $pwd = $_POST['pwd'];
  $contact_no = $_POST['contact_no'];
  $address = $_POST['address'];

  $data = [
    'username' => $username,
    'email' => $email,
    'pwd'=> $pwd,
    'contact_no' => $contact_no,
    'address' => $address,
    'role_id' => 1
  ];

  try {
    require_once './model/user.model.php';
    require_once "./model/cart.model.php";
    //ERROR HANDLERS
    
    $errors = [];

    if(is_input_empty($data)){
      $errors['empty_input'] = "Fill in all the fields!";
    }
    if(is_invalid_email($email)){
      $errors['invalid_email'] = "Email is invalid!";
    }
    if(is_username_taken($pdo,$username)){
      $errors['taken_username'] = "Username is taken!";
    }
    if(is_email_registered($pdo, $email)){
      $errors['email_registered'] = "Email already exists!";
    }
    if(strlen($pwd) < 8 || strlen($pwd) > 64){
      $errors['invalid_pwd'] = "Invalid password length!";
    }
    if(is_number_string($pdo,$contact_no)){
      $errors['invalid_number'] = "Invalid contact number!";

    }


    if ($errors) {
        $_SESSION['errors_signup'] = $errors;
        header('Location: /signup?signup=failed');
        die();
    }

    //POSTING
    create_user($pdo, $data);

    $result = get_user($pdo, $username);
    $role = get_role($pdo, $result['user_id']);
    $_SESSION['role'] = $role['role_name'];

    $newSessionID = session_create_id();
    $sessionID = $newSessionID . "_" . $result['user_id'];
    session_id($sessionID);

    $cart = get_cart_by_id($pdo, $result['user_id']);
    $_SESSION['cart'] = $cart;

    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['user_username'] = htmlspecialchars($result['username']);
    $_SESSION['last_regeneration'] = time();

    header('Location: /products?signup=success');

    $pdo = null;
    $stmt = null;
    die();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

}