<?php

$host = "localhost";
$dbname = "moondust"; //Subject to change depending on the database
$dbusername = "root";
$dbpassword = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}