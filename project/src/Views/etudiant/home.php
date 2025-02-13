<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\CourController;

session_start();

$fetchCour = new CourController();

if (isset($_POST["inscription"])) {
    $idCour = $_POST["cour_id"];
    header("location:./MesCours.php");
    $inscription = new CourController();
    $inscription->inscription($idCour);
}
$searchInput = "";
if (isset($_POST['search'])) {
    $searchInput = $_POST['searchInput'];
    $results = $fetchCour->searchCourEtudiant($searchInput);
} else {
    $results = $fetchCour->fetchCourEtudiant();
}
$pattern = '/^.*\.pdf$/i';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">

    <header class="bg-blue-600 text-white p-6">
        <h1 class="text-5xl font-extrabold mb-4 animate-pulse text-center">YouDemy - Etudiant</h1>
        <p class="text-center mt-2">Trouvez les talents qui feront la différence dans votre entreprise.</p>
        <nav class="mt-4">
            <ul class="flex justify-center space-x-4">
                <li><a href="./home.php" class="hover:underline">Accueil</a></li>
                <li><a href="./MesCours.php" class="hover:underline">Mes cours</a></li>
            </ul>
        </nav>
        <div class="absolute top-4 right-8">
            <a href="../auth/logout.php">
                <button class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring focus:ring-red-300 focus:outline-none shadow-md transition">
                    Logout
                </button>
            </a>
        </div>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Bienvenue, l'Etudiant <?= $_SESSION["email"] ?></h2>
        <p class="text-center text-lg">Connectez-vous avec des enseignants talentueux et passionnés.</p>
        <p class="mt-4 text-center">Utilisez notre plateforme pour avancer dans votre career.</p>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Cours Récentes</h2>


            <form method="POST" class="mb-8">
                <div class="flex justify-center">
                    <input type="text" name="searchInput" class="border border-gray-300 rounded-l-lg p-2 w-1/2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Rechercher un cours par titre, enseignant ou tag..." value="<?= $searchInput ?>">
                    <button type="submit" name="search" class="bg-blue-500 text-white px-4 rounded-r-lg hover:bg-blue-600">
                        Rechercher
                    </button>
                </div>
            </form>

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
                            <p class="text-sm text-gray-600 mt-4 mb-4 leading-relaxed"><?= substr($cour['descrption'], 0, 100) ?>...</p>
                            <div class="flex items-center justify-between">
                                <form action="" method="POST">
                                <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                    <button type="submit" name="inscription" class="inline-flex items-center bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition">
                                        <i class="fas fa-user-plus mr-2"></i>Inscription
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Contactez-Nous</h2>
            <form class="bg-white shadow-lg rounded-lg p-6">
                <div class="mb-4">
                    <label class="block text-gray-700" for="name">Nom</label>
                    <input type="text" id="name" class="mt-1 p-2 w-full border rounded" placeholder="Votre nom" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="email">Email</label>
                    <input type="email" id="email" class="mt-1 p-2 w-full border rounded" placeholder="Votre email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700" for="message">Message</label>
                    <textarea id="message" class="mt-1 p-2 w-full border rounded" rows="4" placeholder="Votre message" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Envoyer</button>
            </form>
        </section>
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; 2025 CreeLink. Tous droits réservés.</p>
    </footer>
</body>

</html>