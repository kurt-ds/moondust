<?php

$heading = "New Product";
if (!isLoggedIn()) {
  header("Location: /login");
}

if (!isAdmin()) {
  header('Location: /products?error=unauthorized');
}

require "views/new.view.php";