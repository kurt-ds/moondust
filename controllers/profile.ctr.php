<?php

$heading = "PROFILE";

function get_user_by_id($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

if (!isLoggedIn()) {
    header("Location: /login");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        require_once "./model/user.model.php";
        require_once "./model/order.model.php";

        // Assuming you have a function to retrieve user information by user ID
        $userId = $_SESSION['user_id']; // Assuming you store the user ID in the session
        $user = get_user_by_id($pdo, $userId); // Modify this function based on your database schema
        $orders = get_orders_by_user($pdo, $userId);
        foreach($orders as $key => $order) {
            $orders[$key]['order_items'] = get_order_items($pdo, $order['order_id']);
          }

        require "views/profile.view.php";
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->GetMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once "./model/order.model.php";


        $order_id = $_POST['order_id'];

        cancel_order($pdo, $order_id);

        header("Location: /profile"); 
        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->GetMessage());
    }

}
?>
