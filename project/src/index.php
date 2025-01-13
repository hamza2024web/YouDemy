<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Find Your Dream Job</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-blue-600">CareerLink</h1>
      <nav class="hidden md:flex space-x-6">
        <a href="#" class="text-gray-600 hover:text-blue-600">Home</a>
        <a href="#" class="text-gray-600 hover:text-blue-600">Jobs</a>
        <a href="#" class="text-gray-600 hover:text-blue-600">About</a>
        <a href="#" class="text-gray-600 hover:text-blue-600">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-500 to-green-500 text-white py-20">
      <div class="container mx-auto text-center space-y-8">
        <h2 class="text-5xl font-extrabold">Find Your Dream Job</h2>
        <p class="text-lg font-medium">CareerLink connects you to the best opportunities in your field.</p>
        <form action="#" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-4">
          <input type="text" placeholder="Job title, skills, or company" class="w-full md:w-2/3 px-6 py-3 rounded-lg shadow-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300" />
          <button class="w-full md:w-1/3 px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-md">
            Search Jobs
          </button>
        </form>
      </div>
    </section>

    <!-- Call-to-Action Buttons -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto text-center">
        <h3 class="text-3xl font-bold text-gray-800 mb-6">Get Started Today!</h3>
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
          <!-- Sign In Button -->
          <a href="./Views/auth/login.php" class="w-full md:w-auto">
            <button class="w-full md:w-52 py-4 px-6 text-lg font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none shadow-md transition-transform transform hover:scale-105">
              Sign In
            </button>
          </a>
          <!-- Register Button -->
          <a href="./Views/auth/signup.php" class="w-full md:w-auto">
            <button class="w-full md:w-52 py-4 px-6 text-lg font-bold rounded-lg text-white bg-green-600 hover:bg-green-700 focus:ring focus:ring-green-300 focus:outline-none shadow-md transition-transform transform hover:scale-105">
              Register
            </button>
          </a>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 border-t mt-12">
    <div class="container mx-auto px-6 py-4 text-center text-gray-600 text-sm">
      &copy; <?php echo date("Y"); ?> CareerLink. All rights reserved.
    </div>
  </footer>

</body>
</html>
