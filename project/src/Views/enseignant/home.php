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
                    <div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition-transform hover:scale-105 hover:shadow-2xl">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-blue-600 mb-4 truncate"><?= $cour['titre'] ?></h3>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Date de création:</span> <?= $cour['created_at'] ?> </p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">categorie:</span> <?= $cour['category_name'] ?> </p>
                            <p class="text-gray-600 mb-2"><span class="font-medium">tag:</span> <?= $cour['tag_name'] ?> </p>
                            <p class="text-gray-700 mb-4"><?= substr($cour['descrption'], 0, 100) ?>...</p>
                            <div class="flex justify-between items-center mt-4">
                                <a href="<?= $cour['contenu']; ?>" download class="bg-green-500 text-white py-2 px-4 rounded shadow-md hover:bg-green-600">
                                    Télécharger le PDF
                                </a>
                            </div>

                            <div class="flex justify-between mt-4">
                                <a href="edit.php?id=<? echo $cour['id']; ?>" class="bg-yellow-500 text-white py-2 px-4 rounded shadow-md flex items-center space-x-2 hover:bg-yellow-600">Modifier</a>

                                <form action="" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer ce cours ?');">
                                    <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                    <button type="submit" name="delete" class="bg-red-500 text-white py-2 px-4 rounded shadow-md flex items-center space-x-2 hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Supprimer</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
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