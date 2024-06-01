<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $heading ?></title>
    <link rel="stylesheet" href="/styles/reset.css?v=<?php echo time(); ?>" type="text/css">
</head>
<body>
    <h1>Welcome, <?php echo ucfirst($_SESSION['user_username'] ?? "GUEST"); ?>  </h1>
    <nav><?php echo $heading ?></nav>