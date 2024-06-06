<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>
<a href="/">HOME</a>
<br>
<a href="/admin">ADMIN</a>
<br>
<a href="/cart">CART</a>
<br>

<ul>
  <?php forEach ($products as $product) { ?>
    <a href="/products/<?php echo htmlspecialchars($product["product_id"]); ?>">
    <img  style="width:300px;height:300px;" src="/<?php echo htmlspecialchars($product["image_url"]); ?>" alt="book thumbnail image">
    <h3>Product Name: " <?php echo htmlspecialchars($product["product_name"]); ?></h3>
    <h4>Unit Price: " <?php echo  htmlspecialchars($product["unit_price"]); ?></h4> 
    </a>
  <?php } ?>
</ul>


</body>
</html>