<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<?php
// Dummy data for cart items
$cart_items = [
    ['product_name' => 'Stellar Powder Tint ', 'variation' => 'Biscuit Bliss', 'quantity' => 2, 'unit_price' => 75.00],
    ['product_name' => 'Moonstone Kiss lip oil', 'variation' => 'Solana', 'quantity' => 1, 'unit_price' => 150.00],
    ['product_name' => 'Callisto Lip Paint ', 'variation' => 'Peach', 'quantity' => 3, 'unit_price' => 50.00],
];
?>

<main class="cart">
<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Your Cart</h1>
    <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
      <section aria-labelledby="cart-heading" class="lg:col-span-7">
        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

        <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
          <?php foreach ($cart_items as $key => $item) : ?>
            <li class="flex py-6 sm:py-10">
              <div class="flex-shrink-0">
                <img src="https://dummyimage.com/100x100" alt="Product Image" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
              </div>

              <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                <div class="relative pr-9 sm:gap-x-6 sm:pr-0">
                  <div>
                    <div class="flex justify-between">
                      <h3 class="text-sm">
                        <a href="#" class="font-medium text-gray-700 hover:text-gray-800"><?php echo $item['product_name']; ?></a>
                      </h3>
                      <button type="button" class="text-red-500 hover:text-red-600 focus:outline-none focus:text-red-600">Remove</button>
                      <div>
                        <input type="checkbox" id="select-<?php echo $key; ?>" name="selected_items[]" value="<?php echo $key; ?>" class="mt-2 accent-[#8a7f6e]">
                        <label for="select-<?php echo $key; ?>" class="text-sm text-gray-700">Add to checkout</label>
                      </div>                      
                    </div>
                    <p class="text-sm text-gray-500"><?php echo $item['variation']; ?></p>
                    <div class="flex text-sm mt-4">
                      <label class="mr-1" for="quantity-<?php echo $key; ?>">Quantity: </label>
                      <input type="number" id="quantity-<?php echo $key; ?>" name="quantity[]" value="<?php echo $item['quantity']; ?>" min="1" class="w-16 border-gray-300 rounded-md">
                    </div>
                    <p class="mt-1 text-sm font-medium text-gray-900">Price: ₱<?php echo number_format($item['unit_price'], 2); ?></p>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- Order summary -->
      <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>
        <dl class="mt-6 space-y-4">
          <!-- Subtotal -->
          <div class="flex items-center justify-between">
            <dt class="text-sm text-gray-600">Subtotal</dt>
            <dd class="text-sm font-medium text-gray-900">₱450.00</dd>
          </div>
          <!-- Shipping estimate -->
          <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <dt class="flex items-center text-sm text-gray-600">
              <span>Shipping fee</span>
            </dt>
            <dd class="text-sm font-medium text-gray-900">₱55.00</dd>
          </div>
          <!-- Order total -->
          <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <dt class="text-base font-medium text-gray-900">Order total</dt>
            <dd class="text-base font-medium text-gray-900">₱505.00</dd>
          </div>
        </dl>

        <!-- Checkout button -->
        <div class="mt-6">
          <button type="submit" class="w-full rounded-md border border-transparent bg-[#AEA089] px-4 py-3 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</button>
        </div>
      </section>
    </form>
  </div>
</div>
</main>

<?php require 'partials/footer.php'; ?>
