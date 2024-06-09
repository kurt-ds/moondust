<?php require 'partials/head.php'; ?>
<?php require 'partials/navbar.php'; ?>

<?php
// dummy data orders
$orders = [
  [
      'order_date' => '2024-06-01',
      'total_price' => '275.00',
      'order_items' => [
          ['product_name' => 'Product A', 'quantity' => 2, 'unit_price' => 75.00],
          ['product_name' => 'Product B', 'quantity' => 1, 'unit_price' => 150.00],
          ['product_name' => 'Product C', 'quantity' => 3, 'unit_price' => 50.00],
      ],
      'status' => 'Paid',
      'order_number' => '1234567890',
  ],
  [
    'order_date' => '2024-06-01',
    'total_price' => '100.00',
    'order_items' => [
        ['product_name' => 'Product A', 'quantity' => 2, 'unit_price' => 50.00],
        ['product_name' => 'Product B', 'quantity' => 1, 'unit_price' => 50.00],
    ],
    'status' => 'Paid',
    'order_number' => '1234567890',
  ],
];
?>

<main class="profile my-32 min-h-[600px]">
  <div class="container mx-auto">
    <div class="flex flex-row items-start gap-20">
      <div class="profile-info sticky top-32">
        <h1 class="text-3xl font-semibold text-gray-800 mb-2">My Profile</h1>
        <div class="flex flex-col space-y-4">
          <div>
            <label for="username" class="block text-lg font-medium text-gray-500">Username:</label>
            <p id="username" class="text-xl text-gray-900"><?php echo htmlspecialchars($user['username']); ?></p>
          </div>
          <div>
            <label for="email" class="block text-lg font-medium text-gray-500">Email:</label>
            <p id="email" class="text-xl text-gray-900"><?php echo htmlspecialchars($user['email']); ?></p>
          </div>
          <div>
            <label for="contact" class="block text-lg font-medium text-gray-500">Contact:</label>
            <p id="contact" class="text-xl text-gray-900"><?php echo htmlspecialchars($user['contact_no']); ?></p>
          </div>
          <div>
            <label for="address" class="block text-lg font-medium text-gray-500">Address:</label>
            <p id="address" class="text-xl text-gray-900"><?php echo htmlspecialchars($user['address']); ?></p>
          </div>
        </div>
      </div>
      <div class="w-full px-4 sm:px-6 lg:px-8 lg:pb-24">
    <div class="max-w-xl">
      <h2 class="text-3xl font-semibold text-gray-800 mb-2">Order History</h2>
      <p class="mt-2 text-sm text-gray-500">Check the status of recent orders, manage returns, and download invoices.</p>
    </div>
    <div class="mt-10">
      <h2 class="sr-only">Recent orders</h2>
      <div class="space-y-20">
        <?php foreach ($orders as $order) : ?>
          <div>
            <h3 class="sr-only">Order placed on><?php echo date('F d, Y', strtotime($order['order_date'])); ?></h3>
            <div class="rounded-lg bg-white px-4 py-6 sm:flex sm:items-center sm:justify-between sm:space-x-6 sm:px-6 lg:space-x-8">
              <dl class="w-full flex-auto space-y-6 divide-y divide-gray-200 text-sm text-gray-600 sm:grid sm:grid-cols-3 sm:gap-x-6 sm:space-y-0 sm:divide-y-0 lg:flex-none lg:gap-x-8">
                <div class="flex justify-between sm:block">
                  <dt class="font-medium text-gray-900">Date placed</dt>
                  <dd class="sm:mt-1">
                    <time datetime="<?php echo $order['order_date']; ?>"><?php echo date('F d, Y', strtotime($order['order_date'])); ?></time>
                  </dd>
                </div>
                <div class="flex justify-between pt-6 sm:block sm:pt-0">
                  <dt class="font-medium text-gray-900">Order number</dt>
                  <dd class="sm:mt-1"><?php echo $order['order_number']; ?></dd>
                </div>
                <div class="flex justify-between pt-6 font-medium text-gray-900 sm:block sm:pt-0">
                  <dt>Total amount</dt>
                  <dd class="sm:mt-1">₱<?php echo $order['total_price']; ?></dd>
                </div>
              </dl>
            </div>

            <table class="mt-4 w-full text-gray-500 sm:mt-6">
              <caption class="sr-only">
                Products
              </caption>
              <thead class="sr-only text-left text-sm text-gray-500 sm:not-sr-only">
                <tr>
                  <th scope="col" class="py-3 pr-8 font-normal sm:w-2/5 lg:w-1/3">Product</th>
                  <th scope="col" class="hidden w-1/5 py-3 pr-8 font-normal sm:table-cell">Quantity</th>
                  <th scope="col" class="hidden w-1/5 py-3 pr-8 font-normal sm:table-cell">Unit Price</th>
                  <th scope="col" class="hidden py-3 pr-8 font-normal sm:table-cell">Status</th>
                  <th scope="col" class="w-0 py-3 text-right font-normal">Info</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 border-b border-gray-200 text-sm sm:border-t">
                <?php foreach ($order['order_items'] as $item) : ?>
                  <tr>
                    <td class="py-6 pr-8">
                      <div class="flex items-center">
                        <img src="https://dummyimage.com/100x100" alt="Product Image" class="mr-6 h-16 w-16 rounded object-cover object-center">
                        <h3 class="font-medium text-gray-900"><?php echo $item['product_name']; ?></h3>
                      </div>
                    </td>
                    <td class="hidden py-6 pr-8 sm:table-cell"><?php echo $item['quantity']; ?></td>
                    <td class="hidden py-6 pr-8 sm:table-cell">₱<?php echo $item['unit_price']; ?></td>
                    <td class="hidden py-6 pr-8 sm:table-cell"><?php echo $order['status']; ?></td>
                    <td class="whitespace-nowrap py-6 text-right font-medium">
                      <a href="#" class="text-[##AEA089]">View<span class="hidden lg:inline"> Product</span><span class="sr-only">, <?php echo $item; ?></span></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
    </div>
  </div>
</main>

<?php require 'partials/footer.php'; ?>
