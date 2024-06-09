<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>

<?php if (isset($_GET['signup']) && $_GET['signup'] === 'failed'): ?>
    <?php if (isset($_SESSION['errors_signup']) && !empty($_SESSION['errors_signup'])): ?>
        <div class="flex flex-col justify-center w-max mx-auto relative top-24">
            <div class="bg-red-100 px-40 border border-red-400 text-red-700 py-3 rounded relative" role="alert">
                <?php foreach ($_SESSION['errors_signup'] as $error): ?>
                    <span class="block sm:inline"><?php echo $error; ?></span><br>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

  <div class="flex flex-col items-center justify-center h-[900px]">
    <div class="text-center flex flex-col gap-1 mb-6">
      <h2 class="text-[#AEA089] text-3xl font-bold">Create Account</h2>
      <p class="text-xl">Already have an account?  
        <a class="underline" href="/login">Log in here.</a>
      </p>
    </div>    
    <form action="/signup" method="post">
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="username">Username: </label>
        <input required type="text" name="username" id="username" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="pwd">Email: </label>
        <input required type="email" name="email" id="email" placeholder="text@gmail.com" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="pwd">Password: </label>
        <input required type="password" name="pwd" id="pwd" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>

      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="contact_no">Contact NO: </label>
        <input required type="text" name="contact_no" id="contact_no" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="address">Address: </label>
        <input required type="text" name="address" id="address" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <button type="submit" class="mt-8 uppercase font-bold text-xl border-[#AEA089] bg-[#AEA089] text-white rounded-full w-full py-4">Sign up </button>
    </form>
  </div>

  <?php require 'partials/footer.php' ?>