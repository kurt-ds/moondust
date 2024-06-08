<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<?php forEach ($images AS $image)  {?>
  <img src="/<?php echo htmlspecialchars($image['image_url']); ?>" alt="product image" style="width:300px;height:300px;display:inline-block;">
<?php } ?>



<h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
<h3><?php echo htmlspecialchars($product['unit_price']); ?></h3>
<p><?php echo htmlspecialchars($product['product_desc']); ?></p>


<?php forEach ($variations AS $variation)  {?>
  <div>
    <div style="width:30px;height:30px;background-color:<?php echo htmlspecialchars($variation['color']); ?>;border-radius:30px;margin:5px;" ></div>
    <p><?php echo htmlspecialchars($variation['variation_name']); ?></p>
  </div>
<?php } ?>
</body>
</html>