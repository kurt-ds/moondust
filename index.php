<?php


include_once 'functions.php';

$routes = include_once 'routes.php';

run($_SERVER['REQUEST_URI'], $routes);