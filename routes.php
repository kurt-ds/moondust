<?php


return [
  '/' => function (array $params = []) {
    require 'controllers/index.ctr.php';
  },
  '/signup' => function (array $params = []) {
    require 'controllers/signup.ctr.php';
  },
  '/login' => function (array $params = []) {
    require 'controllers/login.ctr.php';
  },
  '/products' => function (array $params = []) {
    if ($params['product_id'] === 0) {
      require 'controllers/products.ctr.php';
    } else {
      require 'controllers/product.ctr.php';
    }
  },
  '/cart' => function (array $params = []) {
    require 'controllers/cart.ctr.php';
  },
  '/admin' => function (array $params = []) {
    require 'controllers/admin.ctr.php';
  },
  '/payment' => function (array $params = []) {
    require 'controllers/payment.ctr.php';
  },
  '/logout' => function (array $params = []) {
    require 'controllers/logout.ctr.php';
  },
  '/new' => function (array $params = []) {
    require 'controllers/new.ctr.php';
  }
];