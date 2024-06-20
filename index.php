<?php
// Determine the relative path from the document root to the current directory
$webRoot = realpath(dirname(__FILE__));
$serverRoot = realpath($_SERVER['DOCUMENT_ROOT']);

$pathToWebRoot = '';
if ($webRoot && $serverRoot) {
    if ($webRoot !== $serverRoot) {
        $pathToWebRoot = substr($webRoot, strlen($serverRoot) + 1);
    }
}

include_once 'functions.php';
require_once 'includes/config_session.inc.php';

$routes = include_once 'routes.php';

run($_SERVER['REQUEST_URI'], $routes);
