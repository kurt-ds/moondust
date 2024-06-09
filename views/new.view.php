<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<form class="book-new__form" action="/products" method='post' enctype='multipart/form-data'>
        <input type="text" name='product_name' placeholder="Product Name: " required>
        <br>
        <input type="number"  step="0.01" name='unit_price' placeholder="Unit Price: " required>
        <br>
        <textarea name="product_desc" id=" product_desc" cols="30" rows="10" placeholder=" Product Description: " required></textarea>
        <br>
        <input type="number" name="quantity" placeholder="Quantity: "required>
        <br>
        <input type="file" name='files[]' id='file' multiple required>
        <br>
        <div>
                <div>
                        <input type="color" name="variations[][color]" required>
                        <input type="text" name="variations[][name]" placeholder="Variation Name" required>
                </div>
                <div>
                        <input type="color" name="variations[][color]" required>
                        <input type="text" name="variations[][name]" placeholder="Variation Name" required>
                </div>
                <div>
                        <input type="color" name="variations[][color]" required>
                        <input type="text" name="variations[][name]" placeholder="Variation Name" required>
                </div>
                <!-- This button should add another color variation form -->
                <button>ADD COLOR</button> 
        </div>
        <button type="submit" >Submit</button>
</form>        

<?php require 'partials/footer.php' ?>