<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<main>
  <div class="products-listing my-32">
    <div class="container mx-auto">
      <h1 class="text-6xl font-bold text-[#AEA089]">All Products:</h1>
      <div class="grid grid-cols-4 gap-6 mt-10">
      <?php forEach ($products as $product) { ?>
        <a class="group" href="/products/<?php echo htmlspecialchars($product["product_id"]); ?>">
        <div class="rounded-3xl w-full h-96 overflow-hidden">
          <img class="object-cover w-full h-full transition-all duration-300 ease-in-out group-hover:scale-110" src="/<?php echo htmlspecialchars($product["main_image"]); ?>" alt="book thumbnail image">
        </div>
        <div class="mt-4">
          <h3 class="text-2xl text-gray-800 font-bold"><?php echo htmlspecialchars($product["product_name"]); ?></h3>
          <h4 class="text-lg text-gray-600">₱<?php echo  htmlspecialchars($product["unit_price"]); ?></h4> 
        </div>
        </a>
      <?php } ?>
      </div>
    </div>
  </div>
</main>

<?php require 'partials/footer.php'; ?>