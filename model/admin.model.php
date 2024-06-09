<?php 

declare(strict_types=1);

require_once './includes/dbh.inc.php';

function get_users(object $pdo): int {
    try {
      $query = "SELECT COUNT(*) as user_count FROM user";
      $stmt = $pdo->prepare($query);
  
  
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $count['user_count'];
    } catch(PDOException $e) {
    
      return 0; 
    }
  }





function get_product_count(object $pdo): int {
    try {
      $query = "SELECT COUNT(*) as product_count FROM product";
      $stmt = $pdo->prepare($query);
  
  
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $count['product_count'];
    } catch(PDOException $e) {
      return 0; 
    }
  }






