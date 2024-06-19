<?php

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function create_user(object $pdo, array $data) {
    $query = "INSERT INTO user (username, email, pwd, contact_no, address, role_id) VALUES (:username, :email, :pwd, :contact_no, :address, :role_id);";
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
    $stmt->bindParam(":role_id", $data['role_id']);

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

function get_role(object $pdo, $user_id) {
    $query = "SELECT r.role_name FROM user AS u
    JOIN role AS r ON u.role_id = r.role_id
    WHERE u.user_id = :user_id;";
    
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user_id", $user_id);
    
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_all_users(object $pdo) {
    $query = "SELECT u.user_id, u.username, r.role_id, r.role_name FROM user as u
LEFT JOIN role as r ON u.role_id = r.role_id;";
    $stmt = $pdo->prepare($query);


    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function make_admin(object $pdo, $user_id) {
    $query = "UPDATE user SET role_id = 2 WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user_id", $user_id);

    $stmt->execute();
}