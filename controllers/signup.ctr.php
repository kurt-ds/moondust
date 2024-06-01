<?php

$heading = "SIGN UP";


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
    'address' => $address
  ];

  try {
    require_once './model/user.model.php';
    //ERROR HANDLERS
    $errors = [];



    if ($errors) {
        $_SESSION['errors_signup'] = $errors;
        header('Location: /signup?signup=failed');
        die();
    }

    //POSTING
    create_user($pdo, $data);

    $result = get_user($pdo, $username);

    $newSessionID = session_create_id();
    $sessionID = $newSessionID . "_" . $result['user_id'];
    session_id($sessionID);

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