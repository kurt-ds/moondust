<?php


include_once 'functions.php';
require_once 'includes/config_session.inc.php';

$routes = include_once 'routes.php';

run($_SERVER['REQUEST_URI'], $routes);