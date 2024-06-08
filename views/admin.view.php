<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<ul>
  <?php forEach ($products as $product) { ?>
    <a href="/products/<?php echo htmlspecialchars($product["product_id"]); ?>">
    <img  style="width:300px;height:300px;" src="/<?php echo htmlspecialchars($product["main_image"]); ?>" alt="book thumbnail image">
    <h3>Product Name: <?php echo htmlspecialchars($product["product_name"]); ?></h3>
    <h4>Unit Price: <?php echo  htmlspecialchars($product["unit_price"]); ?></h4> 
    </a>
  <?php } ?>
</ul>

<a href="/new">New Product</a>
</body>
</html>