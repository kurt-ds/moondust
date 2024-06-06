<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<form class="book-new__form" action="/products" method='post' enctype='multipart/form-data'>
        <input type="text" name='product_name' placeholder="Product Name: ">
        <br>
        <input type="number"  step="0.01" name='unit_price' placeholder="Unit Price: ">
        <br>
        <textarea name="product_desc" id=" product_desc" cols="30" rows="10" placeholder=" Product Description: "></textarea>
        <br>
        <input type="file" name='file' id='file'>
        <br>
        <button type="submit" >Submit</button>
</form>        

<?php require 'partials/footer.php' ?>