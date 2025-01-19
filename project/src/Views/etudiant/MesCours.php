<?php
require_once("../../../vendor/autoload.php");
session_start();

use App\Controllers\CourController;

$fetchCours = new CourController();
$results = $fetchCours->fetchCoursInscript();
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
        <h1 class="text-4xl font-bold text-center">YouDemy - étudiant</h1>
        <p class="text-center mt-2">Trouvez les talents qui feront la différence dans votre entreprise.</p>
        <nav class="mt-4">
            <ul class="flex justify-center space-x-4">
                <li><a href="./home.php" class="hover:underline">Accueil</a></li>
                <li><a href="./MesCours.php" class="hover:underline">Mes cours</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Bienvenue, l'Etudiant <?= $_SESSION["email"] ?></h2>
        <p class="text-center text-lg">Connectez-vous avec des enseignants talentueux et passionnés.</p>
        <p class="mt-4 text-center">Utilisez notre plateforme pour avancer dans votre career.</p>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Cours Récentes</h2>
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
                                <?php if (preg_match($pattern, $cour["contenu"])) { ?>
                                    <a href="<?= $cour['contenu']; ?>" download
                                        class="inline-flex items-center bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition">
                                        <i class="fas fa-download mr-2"></i>Télécharger PDF
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= $cour['contenu']; ?>" download
                                        class="inline-flex items-center bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition">
                                        <i class="fas fa-download mr-2"></i>Watch VIDEO
                                    </a>
                                <?php } ?>
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