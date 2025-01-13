<?php
require_once ("../../../vendor/autoload.php");
use App\Controllers\AuthController;

if(isset($_POST["submit"])){
    if(empty($_POST["email"]) && empty($_POST[$password])){
        echo "email or password is empty";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $authcontroller = new AuthController();
        $authcontroller->login($email , $password);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleForms() {
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      loginForm.classList.toggle('hidden');
      registerForm.classList.toggle('hidden');
    }
  </script>
</head>
<body>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                    <!-- Login Form -->
                    <form id="login-form" class="space-y-4" action="" method="POST">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-extrabold">Sign in</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">Sign in to your account and explore a world of possibilities. Your Career begins here.</p>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">email</label>
                            <div class="relative flex items-center">
                                <input name="email" type="text" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter user name" />
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter password" />
                            </div>
                        </div>
                        <div class="!mt-8">
                            <button type="submit" name="submit" class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                Log in
                            </button>
                        </div>

                        <p class="text-sm !mt-8 text-center text-gray-800">Don't have an account <a href="../auth/signup.php" onclick="toggleForms()" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
                    </form>
                </div>

                <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                    <img src="https://readymadeui.com/login-image.webp" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Login or Register" />
                </div>
            </div>
        </div>
    </div>
</body>

</html>