<?php

$heading = "ADMIN PAGE";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  try {
    require_once "./model/product.model.php";

    $products = get_all_products($pdo);

    require "views/admin.view.php";
    $pdo = null;
    $stmt = null;


    
} catch (PDOException $e) {
    die("Query failed: " . $e->GetMessage());
}

}