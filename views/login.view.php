<?php require 'partials/navbar.php'; ?>
<a href="/">HOME</a>

<div>
  <form action="/login" method="post">
    <label for="username">Username: </label>
    <input type="text" name="username" id="username">
    <br>
    <label for="pwd">Password: </label>
    <input type="password" name="pwd" id="pwd">
    <br>
    <button>SUBMIT</button>
  </form>
</div>

<a href="/signup">SIGNUP</a>
</body>
</html>