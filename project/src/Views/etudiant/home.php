<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\CourController;

$fetchCour = new CourController();
$results = $fetchCour->fetchCour();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy - étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-sans">
    <header class="bg-blue-600 text-white p-6">
        <h1 class="text-4xl font-bold text-center">YouDemy - étudiant</h1>
        <p class="text-center mt-2">Trouvez les talents qui feront la différence dans votre entreprise.</p>
        <nav class="mt-4">
            <ul class="flex justify-center space-x-4">
                <li><a href="#" class="hover:underline">Accueil</a></li>
                <li><a href="#" class="hover:underline">Cours</a></li>
                <li><a href="#" class="hover:underline">Témoignages</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Bienvenue, le candidat</h2>
        <p class="text-center text-lg">Connectez-vous avec des enseignants talentueux et passionnés.</p>
        <p class="mt-4 text-center">Utilisez notre plateforme pour avancer dans votre career.</p>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Cours Récentes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($results as $cour) { ?>
                    <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden transform transition-transform hover:scale-105 hover:shadow-xl">
                        <div class="p-6">
                            <!-- enseignanat -->
                            <h3 class="text-lg font-bold text-gray-800 mb-2 truncate"><?= $cour['enseignant_name'] ?></h3>
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
                                <!-- inscription button -->
                                <form action="" method="POST" >
                                    <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                    <button type="submit" name="inscription"
                                        class="inline-flex items-center bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition">
                                        <i class="fas fa-trash-alt mr-2"></i>inscription
                                    </button>
                                </form>
                                <!-- Download Button -->
                                <a href="<?= $cour['contenu']; ?>" download
                                    class="inline-flex items-center bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition">
                                    <i class="fas fa-download mr-2"></i>Télécharger PDF
                                </a>
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