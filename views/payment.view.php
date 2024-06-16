<?php require 'partials/head.php'; ?>
<?php require 'partials/navbar.php'; ?>

<main class="min-h-screen">
  <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
    <h1 class="text-3xl font-bold tracking-tight text-[#AEA089] sm:text-4xl">Invoice and Contact Info</h1>
    <div class="grid grid-cols-2 lg:items-start lg:gap-x-12 xl:gap-x-16">
    <ul role="list" class="divide-y mt-12">
      <?php foreach ($cart_items as $cart_item) { ?>
        <li class="flex bg-white mt-8 first-of-type:mt-0 border rounded-2xl transition-all duration-300 ease-in-out py-6 px-10 sm:py-10">
          <div class="flex-shrink-0">
            <img src="<?php echo $cart_item['main_image']; ?>" alt="Product Image" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
          </div>
          <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
            <div class="relative pr-9 sm:gap-x-6 sm:pr-0">
              <div>
                <div class="flex justify-between">
                  <h3 class="text-xl font-bold text-[#AEA089]"><?php echo $cart_item['product_name']; ?></h3>
                </div>
                <p class="text-sm text-gray-500"><?php echo $cart_item['variation']; ?></p>
                <p class="text-lg font-medium text-gray-900 mt-4">Quantity: <?php echo $cart_item['quantity']; ?></p>
                <p class="mt-1 text-lg font-medium text-gray-900">Unit Price: ₱<?php echo number_format($cart_item['unit_price'], 2); ?></p>
                <p class="mt-1 text-lg font-medium text-gray-900">Total Price: ₱<?php echo number_format($cart_item['total_price'], 2); ?></p>
              </div>
            </div>
          </div>
        </li>
      <?php } ?>
    </ul>

    <form action="/order" method="post" class="mt-12 bg-white rounded-xl py-8 px-10 border border-gray-200">
      <h1 class="text-3xl font-bold tracking-tight text-[#AEA089] sm:text-4xl mb-6">Payment Method</h1>
      <p class="text-lg font-medium text-gray-900">Cash On Delivery</p>
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <?php foreach ($cart_items as $cart_item) { ?>
        <input type="hidden" name="cart_items[]" value="<?php echo $cart_item['cart_id']; ?>">
      <?php } ?>
      <div class="mt-6">
        <p class="text-lg font-medium text-gray-900">Subtotal (<?php echo htmlspecialchars($count); ?> items): ₱<?php echo htmlspecialchars($subtotal); ?></p>
        <p class="text-lg font-medium text-gray-900">Shipping: ₱<?php echo htmlspecialchars($shipping_fee); ?></p>
        <div class="mt-4">
          <label for="total_price" class="text-lg font-medium text-gray-900">Total Price: ₱</label>
          <input type="number" name="total_price" value="<?php echo htmlspecialchars($subtotal + $shipping_fee); ?>" readonly class="border-0 bg-white text-lg font-medium text-gray-900">
        </div>
      </div>
      <button type="submit" class="mt-6 w-full rounded-md border border-transparent bg-[#AEA089] px-4 py-3 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50">Place Order</button>
    </form>
    </div>    
  </div>
</main>

<?php require 'partials/footer.php'; ?>
