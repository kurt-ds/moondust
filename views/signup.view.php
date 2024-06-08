<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php'; ?>
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
        <input type="text" name="username" id="username" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="pwd">Email: </label>
        <input type="email" name="email" id="email" placeholder="text@gmail.com" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="pwd">Password: </label>
        <input type="password" name="pwd" id="pwd" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>

      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="contact_no">Contact NO: </label>
        <input type="text" name="contact_no" id="contact_no" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <div class="flex flex-col gap-1 mb-2">
        <label class="text-[#AEA089] font-bold" for="address">Address: </label>
        <input type="text" name="address" id="address" class="w-[540px] text-xl px-4 py-2 mt-1 rounded-md border bg-transparent placeholder-[#AEA089] border-[#AEA089] focus:outline-[#AEA089]">
      </div>
      
      <button type="submit" class="mt-8 uppercase font-bold text-xl border-[#AEA089] bg-[#AEA089] text-white rounded-full w-full py-4">Sign up </button>
    </form>
  </div>

  <?php require 'partials/footer.php' ?>