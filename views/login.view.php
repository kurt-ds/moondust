<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<?php if (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
    <?php if (isset($_SESSION['errors_login']) && !empty($_SESSION['errors_login'])): ?>
        <div class="flex flex-col justify-center w-max mx-auto relative top-56">
            <div class="bg-red-100 px-40 border border-red-400 text-red-700 py-3 rounded relative" role="alert">
                <?php foreach ($_SESSION['errors_login'] as $error): ?>
                    <span class="block sm:inline"><?php echo $error; ?></span><br>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="flex flex-col items-center justify-center h-[900px]">
  <div class="text-center flex flex-col gap-1 mb-6">
    <h2 class="text-[#AEA089] text-3xl font-bold">Login</h2>
    <p class="text-xl">Don’t have an account?  
      <a class="underline" href="/signup">Sign up here.</a>
    </p>
  </div>
  <form action="/login" method="post">
    <div class="flex flex-col gap-1 mb-2">
      <label class="text-[#AEA089] font-bold" for="username">Username: </label>
      <input type="text" name="username" id="username" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
    </div>
    <div class="flex flex-col gap-1 mb-2">
      <label class="text-[#AEA089] font-bold" for="pwd">Password: </label>
      <input type="password" name="pwd" id="pwd" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
    </div>
    
    <button type="submit" class="mt-8 uppercase font-bold text-xl border-[#AEA089] bg-[#AEA089] text-white rounded-full w-full py-4">
    Sign in
    </button>
  </form>
</div>

<?php require 'partials/footer.php' ?>
