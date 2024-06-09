<header class="header sticky top-0 z-[1000] bg-[#FAF6F2] py-8 border-b border-gray-200">
    <div class="container mx-auto">
        <div class="flex flex-row items-center justify-between">
            <img class="w-44 h-7 object-contain" src="/public/img/logo/logo-moondust.png" alt="moondust">
            <nav>
                <ul class="flex flex-row gap-4 items-center justify-center">
                    <li>
                        <a class="text-lg text-[#1E1E1E]" href="/">Home</a>
                    </li>
                    <li>
                        <a class="text-lg text-[#1E1E1E]" href="/products">Products</a>
                    </li>                                
                </ul>
            </nav>
            <div class="flex gap-4">
                <a href="/cart">
                    <img class="w-6 h-6" src="/public/img/icons/icon-cart.svg" alt="icon cart">
                </a>
                <button class="header-user">
                    <img class="w-6 h-6" src="/public/img/icons/icon-user.svg" alt="icon user">
                    <?php
                    $loggedIn = isset($_SESSION['user_id']);
                    $loginFailed = isset($_GET['login']) && $_GET['login'] === 'failed';
                    ?>
                    <ul class="header-user__auth">
                        <?php if ($loggedIn) { ?>
                            <li>
                                <a href="/profile">Profile</a>
                            </li>
                            <li>
                                <a href="/logout">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="/login">Login</a>
                            </li>
                            <li>
                                <a href="/signup">Signup</a>
                            </li>
                        <?php } ?>
                    </ul>
                </button>
            </div>
        </div>
    </div>
</header>

<?php if ($loginFailed): ?>
    <div class="fixed inset-0 -translate-y-64 flex items-center justify-center -z-10">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Login failed. Please check your credentials and try again.</span>
        </div>
    </div>
<?php endif; ?>