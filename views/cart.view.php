<?php require 'partials/head.php'; ?>
<?php require 'partials/navbar.php'; ?>

<main class="cart">
  <div class="min-h-screen">
    <div class="mx-auto max-w-2xl pb-24 pt-16 lg:max-w-7xl">
      <h1 class="text-3xl font-bold tracking-tight text-[#AEA089] sm:text-4xl">Your Cart</h1>
      <?php if (empty($cart_items)) : ?>
        <p class="text-center py-40 text-3xl text-gray-600 mt-4">Your cart is empty.</p>
      <?php else : ?>          
        <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
          <section aria-labelledby="cart-heading" class="lg:col-span-7">
            <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>
            <ul role="list" class="divide-y divide-gray-200 space-y-4">
              <?php foreach ($cart_items as $key => $item) : ?>
                <li class="flex bg-white border rounded-2xl transition-all duration-300 ease-in-out py-6 px-10 sm:py-10 cursor-pointer item" onclick="toggleSelection(event, '<?php echo htmlspecialchars($item["cart_id"]); ?>', <?php echo $item['cart_total']; ?>)">
                  <div class="flex-shrink-0">
                    <img src="<?php echo $item['main_image']; ?>" alt="Product Image" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
                  </div>

                  <div class="ml-4 flex flex-col justify-between sm:ml-6">
                    <div class="relative pr-9 sm:gap-x-6 sm:pr-0">
                      <div class="flex justify-between">
                        <h3 class="text-xl font-bold text-[#AEA089]"><?php echo $item['product_name']; ?></h3>
                        <form action="/cart" method='post' onclick="event.stopPropagation();" class="remove-form hidden">
                          <input type="hidden" name="_method" value="delete" />
                          <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item["cart_id"]); ?>">
                          <button type="submit" class="absolute right-80 top-16 text-red-500 hover:text-red-600 focus:outline-none focus:text-red-600">
                            <svg class="w-10 h-10 fill-red-500" width="24px" height="24px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M960 160h-291.2a160 160 0 0 0-313.6 0H64a32 32 0 0 0 0 64h896a32 32 0 0 0 0-64zM512 96a96 96 0 0 1 90.24 64h-180.48A96 96 0 0 1 512 96zM844.16 290.56a32 32 0 0 0-34.88 6.72A32 32 0 0 0 800 320a32 32 0 1 0 64 0 33.6 33.6 0 0 0-9.28-22.72 32 32 0 0 0-10.56-6.72zM832 416a32 32 0 0 0-32 32v96a32 32 0 0 0 64 0v-96a32 32 0 0 0-32-32zM832 640a32 32 0 0 0-32 32v224a32 32 0 0 1-32 32H256a32 32 0 0 1-32-32V320a32 32 0 0 0-64 0v576a96 96 0 0 0 96 96h512a96 96 0 0 0 96-96v-224a32 32 0 0 0-32-32z" fill="current" /><path d="M384 768V352a32 32 0 0 0-64 0v416a32 32 0 0 0 64 0zM544 768V352a32 32 0 0 0-64 0v416a32 32 0 0 0 64 0zM704 768V352a32 32 0 0 0-64 0v416a32 32 0 0 0 64 0z" fill="current" /></svg>
                          </button>
                        </form>                      
                      </div>
                      <p class="text-sm text-gray-500"><?php echo $item['variation']; ?></p>
                      <p class="text-lg font-medium text-gray-900 mt-4">Unit Price: ₱<?php echo number_format($item['unit_price'], 2); ?></p>
                      <p class="mt-1 text-lg font-medium text-gray-900">Total Price: ₱<?php echo number_format($item['cart_total'], 2); ?></p>
                      <form class="w-[40%] flex gap-2" action="/cart" method='post' onclick="event.stopPropagation();">
                        <input type="hidden" name="_method" value="put" />
                        <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item["cart_id"]); ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($item["user_id"]); ?>">
                        <div class="flex text-lg mt-4 w-[600px] flex-row items-center gap-2">
                          <label class="mr-1" for="quantity-<?php echo $key; ?>">Quantity: </label>
                          <input class="bg-gray-100 rounded-xl px-4 w-full" type="number" id="quantity-<?php echo $key; ?>" name="cart_quantity" value="<?php echo $item['cart_quantity']; ?>" min="1" class="w-16 border-gray-300 rounded-md" oninput="showConfirmButton(this)">
                        </div>
                        <button type='submit' class="ml-4 mt-4 opacity-0 rounded-md border border-transparent bg-[#AEA089] px-4 py-3 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm</button>
                      </form>    
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
            <form action="/payment" method="post" id="selected-items">
              <!-- Hidden inputs for selected items will be added here -->
            </form>
          </section>

          <!-- Order summary -->
          <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8 drop-shadow-xl">
            <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>
            <dl class="mt-6 space-y-4">
              <!-- Subtotal -->
              <div class="flex items-center justify-between">
                <dt class="text-sm text-gray-600">Subtotal</dt>
                <dd class="text-sm font-medium text-gray-900" id="subtotal">₱0.00</dd>
              </div>
              <!-- Shipping estimate -->
              <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                <dt class="flex items-center text-sm text-gray-600">
                  <span>Shipping fee</span>
                </dt>
                <dd class="text-sm font-medium text-gray-900">₱59.00</dd>
              </div>
              <!-- Order total -->
              <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                <dt class="text-base font-medium text-gray-900">Order total</dt>
                <dd class="text-base font-medium text-gray-900" id="order-total">₱59.00</dd>
              </div>
            </dl>

            <!-- Checkout button -->
            <div class="mt-6">
              <button type="submit" form="selected-items" id="checkout-button" class="transition-all duration-300 ease-in-out disabled:bg-gray-400 disabled:cursor-not-allowed w-full rounded-md border border-transparent bg-[#AEA089] px-4 py-3 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50" disabled>Checkout</button>
            </div>
          </section>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require 'partials/footer.php'; ?>

<script>
  let subtotal = 0;

  function toggleSelection(event, cartId, itemTotal) {
    event.preventDefault();
    const itemElement = event.currentTarget;
    const removeForm = itemElement.querySelector('.remove-form');

    // Toggle the selection style
    itemElement.classList.toggle('bg-blue-50');

    // Toggle the remove button visibility
    removeForm.classList.toggle('hidden');

    // Check if the item is selected
    const inputElement = document.getElementById('selected-' + cartId);
    if (inputElement) {
      // Remove the input if the item is deselected
      inputElement.remove();
      subtotal -= itemTotal;
    } else {
      // Add the hidden input if the item is selected
      const newInputElement = document.createElement('input');
      newInputElement.type = 'hidden';
      newInputElement.id = 'selected-' + cartId;
      newInputElement.name = 'selected_items[]';
      newInputElement.value = cartId;
      document.getElementById('selected-items').appendChild(newInputElement);
      subtotal += itemTotal;
    }

    updateOrderSummary();
    toggleCheckoutButton();
  }

  function updateOrderSummary() {
    const shippingFee = 59;
    const orderTotal = subtotal + shippingFee;
    document.getElementById('subtotal').innerText = '₱' + subtotal.toFixed(2);
    document.getElementById('order-total').innerText = '₱' + orderTotal.toFixed(2);
  }

  function toggleCheckoutButton() {
    const selectedItems = document.querySelectorAll('#selected-items input');
    const checkoutButton = document.getElementById('checkout-button');
    if (selectedItems.length > 0) {
      checkoutButton.disabled = false;
    } else {
      checkoutButton.disabled = true;
    }
  }

  function showConfirmButton(inputElement) {
    const form = inputElement.closest('form');
    const button = form.querySelector('button[type="submit"]');
    const originalQuantity = inputElement.defaultValue;
    const currentQuantity = inputElement.value;

    if (currentQuantity !== originalQuantity) {
      button.classList.remove('opacity-0');
    } else {
      button.classList.add('opacity-0');
    }
  }
</script>
