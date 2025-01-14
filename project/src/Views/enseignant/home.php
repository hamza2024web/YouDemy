<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\CourController;

$coursFetch = new CourController();
if (isset($_POST['delete'])) {
    $id = $_POST['cour_id'];

    $courControlle = new CourController();
    $courControlle->deleteCour($id);
}
$resultsCours = $coursFetch->fetchCour();
$countCour = new CourController();
$resultCount = $countCour->NombreDeCoursEnseignant();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignant - YouDemy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 via-blue-100 to-gray-200 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-8 shadow-lg">
        <div class="max-w-screen-xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-4 animate-pulse">YouDemy - Enseignant</h1>
            <p class="text-lg font-medium">Trouvez les talents qui feront la différence dans votre entreprise.</p>
            <nav class="mt-6">
                <ul class="flex justify-center space-x-8 text-lg font-medium">
                    <li><a href="#" class="hover:underline">Accueil</a></li>
                    <li><a href="./cours.php" class="hover:underline">Cours</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto mt-12 p-8">

        <!-- Introduction Section -->
        <section class="text-center">
            <h2 class="text-4xl font-semibold mb-4 text-gray-800">Bienvenue sur YouDemy</h2>
            <p class="text-xl text-gray-600 mb-4">Connectez-vous avec des étudiants talentueux et passionnés.</p>
            <p class="text-lg text-gray-500">Utilisez notre plateforme pour publier et gérer vos cours facilement.</p>
        </section>

        <!-- Add a Course Button -->
        <div class="flex justify-center mt-8">
            <a href="./cours.php" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 px-6 rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-800 focus:outline-none transform transition-transform hover:scale-110">
                Ajouter un Cours
            </a>
        </div>

        <!-- Recent Courses Section -->
        <section class="mt-16">
            <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Cours Récents</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($resultsCours as $cour) { ?>
                    <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden transform transition-transform hover:scale-105 hover:shadow-xl">
                        <div class="p-6">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-800 mb-2 truncate"><?= $cour['titre'] ?></h3>
                            <!-- Date -->
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="fas fa-calendar-alt mr-2"></i>Date de création:
                                <span class="font-medium"><?= $cour['created_at'] ?></span>
                            </p>
                            <!-- Category -->
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="fas fa-folder mr-2"></i>Catégorie:
                                <span class="font-medium"><?= $cour['category_name'] ?></span>
                            </p>
                            <!-- Tag -->
                            <p class="text-sm text-gray-500 mb-1">
                                <i class="fas fa-tag mr-2"></i>Tag:
                                <span class="font-medium"><?= $cour['tag_name'] ?></span>
                            </p>
                            <!-- Description -->
                            <p class="text-sm text-gray-600 mt-4 mb-4 leading-relaxed"><?= substr($cour['descrption'], 0, 100) ?>...</p>
                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <!-- Download Button -->
                                <a href="<?= $cour['contenu']; ?>" download
                                    class="inline-flex items-center bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition">
                                    <i class="fas fa-download mr-2"></i>Télécharger PDF
                                </a>
                                <!-- Edit & Delete Buttons -->
                                <div class="flex space-x-2">
                                    <!-- Edit -->
                                    <a href="edit.php?id=<?= $cour['id']; ?>"
                                        class="inline-flex items-center bg-yellow-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-yellow-600 transition">
                                        <i class="fas fa-edit mr-2"></i>Modifier
                                    </a>
                                    <!-- Delete -->
                                    <form action="" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer ce cours ?');">
                                        <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                        <button type="submit" name="delete"
                                            class="inline-flex items-center bg-red-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-red-600 transition">
                                            <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </section>
        <section class="mt-16 bg-white shadow-xl rounded-lg p-8 max-w-md mx-auto">
            <h1 class="text-3xl font-semibold mb-6 text-center text-gray-800">Statistiques</h1>
            <div class="flex items-center justify-center space-x-4">
                <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-6 px-12 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold">Nombre de cours</h3>
                    <p class="text-4xl font-extrabold"><?= $resultCount ?></p>
                </div>
            </div>
            <p class="mt-4 text-lg text-gray-600 text-center">Ce chiffre reflète le nombre total de cours que vous avez publiés sur la plateforme.</p>
        </section>


        <!-- Contact Section -->
        <section class="mt-16">
            <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Contactez-Nous</h2>
            <form class="bg-white shadow-xl rounded-lg p-8 max-w-lg mx-auto">
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="name">Nom</label>
                    <input type="text" id="name" class="mt-1 p-4 w-full border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Votre nom" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                    <input type="email" id="email" class="mt-1 p-4 w-full border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Votre email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="message">Message</label>
                    <textarea id="message" class="mt-1 p-4 w-full border rounded-lg focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Votre message" required></textarea>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 px-6 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-800 focus:outline-none w-full">
                    Envoyer
                </button>
            </form>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-6 mt-16">
        <p>&copy; 2025 YouDemy. Tous droits réservés.</p>
    </footer>

</body>

</html>