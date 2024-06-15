<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<main>
  <h1>Invoice and Contact Info</h1>
  <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
    <?php foreach($cart_items as $cart_item) { ?>
      <li class="flex py-6 sm:py-10">
                <div class="flex-shrink-0">
                  <img src="<?php echo $cart_item['main_image']  ?>" alt="Product Image" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
                </div>

                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                  <div class="relative pr-9 sm:gap-x-6 sm:pr-0">
                    <div>
                      <div class="flex justify-between">
                        <h3 class="text-sm">
                          <a href="#" class="font-medium text-gray-700 hover:text-gray-800"><?php echo $cart_item['product_name']; ?></a>
                        </h3>                      
                      </div>
                      <p class="text-sm text-gray-500"><?php echo $cart_item['variation']; ?></p>
    
                      <p class="mt-1 text-sm font-medium text-gray-900">Unit Price: ₱<?php echo number_format($cart_item['unit_price'], 2); ?></p>
                      <p class="mt-1 text-sm font-medium text-gray-900">Total Price: ₱<?php echo number_format($cart_item['total_price'], 2); ?></p>
                    </div>
                  </div>
                </div>
              </li>
    <?php } ?>
  </ul>

  <form action="/order" method='post'>
    <h1>Payment Method</h1>
    <p>Cash On Delivery</p>
    <?php foreach($cart_items as $cart_item) { ?>
      <input type="hidden" name="order_items[]" value="<?php echo $cart_item['cart_id']; ?>">
    <?php } ?>
    <p>Subtotal (<?php echo htmlspecialchars($count) ?> items)   ₱<?php echo htmlspecialchars($subtotal) ?></p>
    <p>Shipping  ₱<?php echo htmlspecialchars($shipping_fee) ?></p>
    <div>
      <label for="total_price">Total Price: ₱</label>
      <input type="number" name='total_price' value='<?php echo htmlspecialchars($subtotal + $shipping_fee) ?>' readonly> 
    </div>
    <button type="submit" >Place Order</button>
  </form>


</main>

<?php require 'partials/footer.php' ?>