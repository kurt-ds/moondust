<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<main class="product-single my-32">
  <div class="container mx-auto">
    <div class="grid grid-cols-2 gap-10">
      <div>
        <div thumbsSlider="" class="swiper product-single__thumb">
          <div class="swiper-wrapper">
            <?php
              foreach ($images as $image) {
                echo '<div class="swiper-slide"><img class="!w-full !h-[600px] rounded-3xl mb-8 object-cover" src="/' . htmlspecialchars($image['image_url']) . '" alt="product image" style="width:100px;height:100px;"></div>';
              }
            ?>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>    
        </div>    
        <div class="swiper product-single__main">
          <div class="swiper-wrapper">
            <?php
              foreach ($images as $image) {
                echo '<div class="swiper-slide cursor-pointer"><img class="w-full !h-40 object-cover rounded-3xl" src="/' . htmlspecialchars($image['image_url']) . '" alt="product image"></div>';
              }
            ?>
          </div>
        </div>
      </div>
      <div>
      <h2 class="text-[#AEA082] text-3xl font-bold mb-2"><?php echo htmlspecialchars($product['product_name']); ?></h2>
      <h3 class="text-[#AEA082] text-2xl font-bold mb-2">₱<?php echo htmlspecialchars($product['unit_price']); ?></h3>
      <form action="/cart" method='post'>
        <div class="flex flex-col gap-2">
          <label class="text-xl text-[#AEA082] mt-2 font-bold" for="variation">Color:</label>
          <select name='variation' class="w-[350px] text-[#AEA082] cursor-pointer py-4 rounded-full pl-4 bg-transparent border border-[#AEA082] appearance-none">
            <?php foreach ($variations as $variation) { ?>
              <option value="<?php echo htmlspecialchars($variation['variation_name']); ?>" data-color="<?php echo htmlspecialchars($variation['color']); ?>">
                <?php echo htmlspecialchars($variation['variation_name']); ?>
              </option>
            <?php } ?>
          </select>
        </div>      
        <p class="text-[#1E1E1E] text-xl mt-4"><?php echo htmlspecialchars($product['product_desc']); ?></p>
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id) ?>">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']) ?>">
        <div class="mb-6">
            <label for="quantity" class="block text-xl mb-2 font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="w-full text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
          </div>
        <h3 class="text-[#1E1E1E] text-xl mt-4">Stocks Available: <?php echo htmlspecialchars($quantity['quantity']); ?></h3>
        <button type="submit" class="mt-8 uppercase font-bold text-xl border-[#AEA089] bg-[#AEA089] text-white rounded-full w-full py-4">
        Add to cart
        </button>
        </div>
      </form>
    </div>
  </div>
</main>

<?php require 'partials/footer.php'; ?>