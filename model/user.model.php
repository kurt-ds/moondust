<?php

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function create_user(object $pdo, array $data) {
    $query = "INSERT INTO user (username, email, pwd, contact_no, address) VALUES (:username, :email, :pwd, :contact_no, :address);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost'=> 12
    ];

    $hashedPwd = password_hash($data['pwd'], PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $data['username']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":contact_no", $data['contact_no']);
    $stmt->bindParam(":address", $data['address']);

    $stmt->execute();
}

function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM user WHERE username = :username;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email){
    $query = "SELECT * FROM user WHERE email = :email;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":email", $email);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}