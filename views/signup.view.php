<?php require 'partials/navbar.php'; ?>
<a href="/">HOME</a>

  <div class="signup-form-container">
    <form action="/signup" method="post">
      <label for="username">Username: </label>
      <input type="text" name="username" id="username">
      <br>
      <label for="email">Email: </label>
      <input type="email" name="email" id="email">
      <br>
      <label for="pwd">Password: </label>
      <input type="password" name="pwd" id="pwd">
      <br>
      <label for="contact_no">Contact NO: </label>
      <input type="text" name="contact_no" id="contact_no">
      <br>
      <label for="address">Address: </label>
      <input type="text" name="address" id="address">
      <br>
      <button>SUBMIT</button>
    </form>
  </div>

<a href="/login">LOGIN</a>
</body>
</html>