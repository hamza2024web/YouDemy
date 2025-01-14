<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\CourController;

$coursFetch = new CourController();
if(isset($_POST['delete'])){
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
    <title>enseignant - YouDemy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-8 shadow-lg">
        <div class="max-w-screen-xl mx-auto text-center">
            <h1 class="text-5xl font-extrabold mb-4">YouDemy - Enseignant</h1>
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
            <p class="text-lg text-gray-500">Utilisez notre plateforme pour publier vos cours et gérer vos cours facilement.</p>
        </section>

        <!-- Add a Course Button -->
        <div class="flex justify-center mt-8">
            <a href="./cours.php" class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none transform transition-transform hover:scale-105">
                Ajouter un Cours
            </a>
        </div>

        <!-- Recent Courses Section -->
        <section class="mt-16">
            <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Cours Récents</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($resultsCours as $cour) { ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform hover:scale-105 hover:shadow-xl">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-blue-600 mb-4"><?= $cour['titre'] ?></h3>
                            <p class="text-gray-600 mb-2"><span class="font-medium">Date de création:</span> <?= $cour['created_at'] ?> </p>
                            <p class="text-gray-700 mb-4"><?= substr($cour['descrption'], 0, 100) ?>...</p>
                            <div class="flex justify-between items-center mt-4">
                                <button class="bg-blue-600 text-white py-2 px-4 rounded shadow-md hover:bg-blue-700 focus:outline-none">
                                    Inscription
                                </button>
                                <a href="<?= $cour['contenu']; ?>" download class="bg-green-600 text-white py-2 px-4 rounded shadow-md hover:bg-green-700">
                                    Télécharger le PDF
                                </a>
                            </div>

                            <!-- Modify and Delete as Buttons with Icons -->
                            <div class="flex justify-between mt-4">
                                <form action="" method="POST" >
                                    <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                    <button type="submit" name="edit" class="bg-yellow-600 text-white py-2 px-4 rounded shadow-md flex items-center space-x-2 hover:bg-yellow-700">
                                        <i class="fas fa-trash-alt"></i>
                                        <span class="hidden sm:inline">Modefier</span>
                                    </button>
                                </form>

                                <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                    <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                    <button type="submit" name="delete" class="bg-red-600 text-white py-2 px-4 rounded shadow-md flex items-center space-x-2 hover:bg-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                        <span class="hidden sm:inline">Supprimer</span>
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
            <form class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="name">Nom</label>
                    <input type="text" id="name" class="mt-1 p-4 w-full border rounded-lg" placeholder="Votre nom" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                    <input type="email" id="email" class="mt-1 p-4 w-full border rounded-lg" placeholder="Votre email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2" for="message">Message</label>
                    <textarea id="message" class="mt-1 p-4 w-full border rounded-lg" rows="4" placeholder="Votre message" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none w-full">
                    Envoyer
                </button>
            </form>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-6 mt-16">
        <p>&copy; 2025 YouDemy. Tous droits réservés.</p>
    </footer>

</body>

</html>