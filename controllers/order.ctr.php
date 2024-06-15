<?php

$heading = "Order";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  require "views/order.view.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    require_once "./model/cart.model.php";

    var_dump($_POST);

    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
      die("Query failed: " . $e->GetMessage());
  }
}