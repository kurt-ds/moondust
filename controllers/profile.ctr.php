<?php

$heading = "PROFILE";

function get_user_by_id($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        require_once "./model/user.model.php";

        // Assuming you have a function to retrieve user information by user ID
        $userId = $_SESSION['user_id']; // Assuming you store the user ID in the session
        $user = get_user_by_id($pdo, $userId); // Modify this function based on your database schema

        require "views/profile.view.php";
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->GetMessage());
    }
}
?>
