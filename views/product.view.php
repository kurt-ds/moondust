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
        <form action="/cart" method='post' class="product-single__form">
          <div class="flex flex-col gap-2">
            <label class="text-xl text-[#AEA082] mt-2 font-bold" for="variation">Color:</label>
            <select name='variation_id' class="w-[350px] text-[#AEA082] cursor-pointer py-4 rounded-full pl-4 bg-transparent border border-[#AEA082] appearance-none">
              <?php foreach ($variations as $variation) { ?>
                <option value="<?php echo htmlspecialchars($variation['variation_id']); ?>" data-color="<?php echo htmlspecialchars($variation['color']); ?>">
                  <?php echo htmlspecialchars($variation['variation_name']); ?>
                </option>
              <?php } ?>
            </select>
          </div>      
          <p class="text-[#1E1E1E] text-xl mt-4"><?php echo htmlspecialchars($product['product_desc']); ?></p>
          <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id) ?>">
          <input type="hidden" name="user_id" value="<?php echo isLoggedIn() ? htmlspecialchars($_SESSION['user_id']) : 0?>">
          <input type="hidden" name="stock_available" value="<?php echo htmlspecialchars($quantity['stock_available']); ?>">
          <div class="flex items-end gap-4 max-w-[50%] mt-4 mb-6">
              <label for="cart_quantity" class="block text-xl mb-2 font-medium text-gray-700">Quantity</label>
              <input type="number" name="cart_quantity" id="quantity" placeholder="Quantity" class="w-full text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
            </div>
          <h3 class="text-[#1E1E1E] text-xl mt-4">Stocks Available: <?php echo htmlspecialchars($quantity['stock_available']); ?></h3>
          <button type="submit" class="mt-8 uppercase font-bold text-xl border-[#AEA089] bg-[#AEA089] text-white rounded-full w-full py-4">
          Add to cart
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- Modal -->
<div id="stock-modal" class="relative z-[1000] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
        <div>
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-5">
            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Error</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">The quantity requested exceeds the available stock. Please adjust your quantity.</p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-6">
          <button type="button" id="close-modal-btn" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm">Go back to product</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'partials/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const stockModal = document.getElementById("stock-modal");
  const closeModalBtn = document.getElementById("close-modal-btn");
  const productForm = document.querySelector(".product-single__form");
  const stockAvailableInput = document.querySelector('input[name="stock_available"]');
  const quantityInput = document.getElementById("quantity");

  function showModal() {
    stockModal.classList.remove("hidden");
  }

  function hideModal() {
    stockModal.classList.add("hidden");
  }

  function handleFormSubmit(event) {
    const stockAvailable = parseInt(stockAvailableInput.value, 10);
    const requestedQuantity = parseInt(quantityInput.value, 10);

    if (requestedQuantity > stockAvailable) {
      event.preventDefault();
      showModal();
    }
  }

  closeModalBtn.addEventListener("click", hideModal);
  productForm.addEventListener("submit", handleFormSubmit);
});
</script>