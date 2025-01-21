<?php

require_once("../vendor/autoload.php");

use App\Controllers\CourController;

$fetchCour = new CourController();
$searchInput = "";
if (isset($_POST['search'])) {
  $searchInput = $_POST['searchInput'];
  $results = $fetchCour->searchCourEtudiant($searchInput);
} else {
  $pagination = isset($_GET['page']) ? (int)$_GET['page'] : 6;
  $results = $fetchCour->paginationVisieur($pagination);
}
if (isset($_POST["inscription"])) {
  header("location:../src/Views/auth/login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Find Your Dream Cours</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-blue-600">Youdemy</h1>
      <nav class="flex items-center space-x-6">
        <div class="flex space-x-4">
          <a href="./Views/auth/login.php">
            <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none shadow-md transition">
              Sign In
            </button>
          </a>
          <a href="./Views/auth/signup.php">
            <button class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:ring focus:ring-green-300 focus:outline-none shadow-md transition">
              Register
            </button>
          </a>
        </div>
      </nav>
    </div>
  </header>

  <main class="flex-grow">
    <section class="bg-gradient-to-br from-blue-500 to-green-500 text-white py-20">
      <div class="container mx-auto text-center space-y-8">
        <h2 class="text-5xl font-extrabold">Find Your Dream Cours</h2>
        <p class="text-lg font-medium">Youdemy connects you to the best opportunities in your field.</p>
        <form method="POST" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-4">
          <input type="text" name="searchInput" placeholder="Search courses by title, teacher, or tag" class="w-full md:w-2/3 px-6 py-3 rounded-lg shadow-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300" value="<?= $searchInput ?>">
          <button type="submit" name="search" class="w-full md:w-1/3 px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-md">
            Search Courses
          </button>
        </form>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto">
        <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Available Courses</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php foreach ($results as $cour) { ?>
            <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden transform transition-transform hover:scale-105 hover:shadow-xl">
              <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">Instructor: <?= $cour['enseignant_name'] ?></h3>
                <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">Title: <?= $cour['titre'] ?></h3>
                <p class="text-sm text-gray-500 mb-1">
                  <i class="fas fa-calendar-alt mr-2"></i>Date: <span class="font-medium"><?= $cour['created_at'] ?></span>
                </p>
                <p class="text-sm text-gray-500 mb-1">
                  <i class="fas fa-folder mr-2"></i>Category: <span class="font-medium"><?= $cour['category_name'] ?></span>
                </p>
                <p class="text-sm text-gray-500 mb-1">
                  <i class="fas fa-tag mr-2"></i>Tag: <span class="font-medium"><?= $cour['tag_name'] ?></span>
                </p>
                <p class="text-sm text-gray-600 mt-4 mb-4 leading-relaxed">Description: <?= substr($cour['descrption'], 0, 100) ?>...</p>
                <div class="flex items-center justify-between">
                  <form action="" method="POST">
                    <button type="submit" name="inscription" class="inline-flex items-center bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition">
                      <i class="fas fa-user-plus mr-2"></i>Inscription
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  </main>
  <div class="pagination mt-8 flex justify-center items-center space-x-4">
    <nav class="flex space-x-4">
      <a href="?page=6"
        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition shadow-md">
        Page 1
      </a>
      <a href="?page=12"
        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition shadow-md">
        Page 2
      </a>
      <a href="?page=36"
        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition shadow-md">
        Page 3
      </a>
    </nav>
  </div>


  <footer class="bg-gray-100 border-t mt-12">
    <div class="container mx-auto px-6 py-4 text-center text-gray-600 text-sm">
      &copy; <?php echo date("Y"); ?> Youdemy. All rights reserved.
    </div>
  </footer>

</body>

</html>