<?php
declare(strict_types=1);

function isAuthorized(int $user_id) {
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $user_id) {
        return true;
    } else {
        return false;
    }
}


function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function urlLs($value) {
    return $_SERVER["REQUEST_URI"] === $value;
}

function run(string $url, array $routes): void
{
    $uri = parse_url("$url");
    $path = $uri['path'];
    $path_array = explode('/', $path);

    $regex_product_id = "/\/products\/\d+$/";
    $product_id = 0;
    $path2 = '';

    if ((preg_match($regex_product_id, $path, $matches))) {
        $path = '/' . $path_array[1];
        $product_id = $path_array[2];
    }

    
    if (false === array_key_exists($path, $routes)) {
        http_response_code(404);
        echo "404-NOT FOUND";
        return;
    }

    $callback = $routes[$path];
    $params = [];
    if (!empty($uri['query'])){
        parse_str($uri['query'], $params);
    }

    $params['product_id'] = $product_id;
    $params['path2'] = $path2;
    $callback($params);
}