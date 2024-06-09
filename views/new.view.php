<?php require 'partials/head.php'; ?>
<?php require 'partials/navbar.php'; ?>

<main class="product-new my-32">
  <div class="container mx-auto">
    <h1 class="text-6xl font-bold text-[#AEA089] mb-10">Add New Product</h1>
    <div class="py-12 px-20 bg-white rounded-3xl">
      <form class="space-y-6 grid grid-cols-2 gap-10" action="/products" method="post" enctype="multipart/form-data">
        <div>
          <div class="mb-6">
            <label for="product_name" class="block text-xl mb-2 font-medium text-gray-700">Product Name</label>
            <input type="text" name="product_name" id="product_name" placeholder="Product Name" class="w-full text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
          </div>
          <div class="mb-6">
            <label for="unit_price" class="block text-xl mb-2 font-medium text-gray-700">Unit Price</label>
            <input type="number" step="0.01" name="unit_price" id="unit_price" placeholder="Unit Price" class="w-full text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
          </div>
          <div class="mb-6">
            <label for="product_desc" class="block text-xl mb-2 font-medium text-gray-700">Product Description</label>
            <textarea name="product_desc" id="product_desc" cols="30" rows="10" placeholder="Product Description" class="w-full text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required></textarea>
          </div>
        </div>
        <div>
          <div class="mb-6">
            <label for="file" class="block text-xl mb-4 font-medium text-gray-700">Product Images</label>
            <input type="file" name="files[]" id="file" multiple class="cursor-pointer mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#AEA089] file:text-white" required>
          </div>
          <div class="space-y-4 mb-2 flex flex-col">
            <div class="flex flex-row items-center gap-4">
              <label class="block text-xl mb-2 font-medium text-gray-700">
                Color Variations
                <button type="button" id="add-variation" class="mt-2 ml-2 inline-flex items-center p-1 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-[#AEA089] focus:outline-none focus:ring-2 focus:ring-offset-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                </button>
            </div>
            </label>
            <div id="variations-container">
              <div class="flex items-center space-x-4 mb-4 variation">
                <input type="color" name="variations[][color]" class="rounded-md border-gray-300 sm:text-sm" required>
                <input type="text" name="variations[][name]" placeholder="Variation Name" class="w-1/2 text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
                <button type="button" class="remove-variation inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <div>
            <button type="submit" class="inline-flex mt-10 w-full justify-center items-center px-6 py-3 border border-transparent text-xl font-bold rounded-md shadow-sm text-white bg-[#AEA089] focus:outline-none focus:ring-2 focus:ring-offset-2">ADD PRODUCT</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require 'partials/footer.php'; ?>

<script>
        const productPage = document.querySelector(".product-new");
if (productPage) {
  document.addEventListener("DOMContentLoaded", () => {
    const variationsContainer = document.getElementById("variations-container");
    const addVariationButton = document.getElementById("add-variation");

    const createVariationElement = () => {
      const div = document.createElement("div");
      div.className = "flex items-center space-x-4 mb-4 variation";
      div.innerHTML = `
        <input type="color" name="variations[][color]" class="rounded-md border-gray-300 sm:text-sm" required>
        <input type="text" name="variations[][name]" placeholder="Variation Name" class="w-1/2 text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]" required>
          <button type="button" class="remove-variation inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                  </svg>        
          </button>
        `;

      div.querySelector(".remove-variation").addEventListener("click", () => {
        if (document.querySelectorAll(".variation").length > 1) {
          div.remove();
        } else {
          alert("At least one variation is required.");
        }
      });

      return div;
    };

    addVariationButton.addEventListener("click", () => {
      const newVariation = createVariationElement();
      variationsContainer.appendChild(newVariation);
    });

    document.querySelectorAll(".remove-variation").forEach((button) => {
      button.addEventListener("click", () => {
        if (document.querySelectorAll(".variation").length > 1) {
          button.parentElement.remove();
        } else {
          alert("At least one variation is required.");
        }
      });
    });
  });
}
</script>