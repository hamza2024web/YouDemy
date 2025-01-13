<?php
session_start();
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruteurs - CreeLink</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-blue-600 text-white p-6">
        <h1 class="text-4xl font-bold text-center">CreeLink - Candidat</h1>
        <p class="text-center mt-2">Trouvez les talents qui feront la différence dans votre entreprise.</p>
        <nav class="mt-4">
            <ul class="flex justify-center space-x-4">
                <li><a href="#" class="hover:underline">Accueil</a></li>
                <li><a href="#" class="hover:underline">Offres d'emploi</a></li>
                <li><a href="#" class="hover:underline">Témoignages</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto mt-8 p-4">
        <h2 class="text-3xl font-semibold mb-6 text-center">Bienvenue, le candidat <?= $email ?></h2>
        <p class="text-center text-lg">Connectez-vous avec des candidats talentueux et passionnés.</p>
        <p class="mt-4 text-center">Utilisez notre plateforme pour publier vos offres d'emploi et gérer les candidatures facilement.</p>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Offres d'Emploi Récentes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <div class="p-4">
                        <h3 class="font-bold text-xl">Développeur Web</h3>
                        <p class="text-gray-600">Localisation : Paris</p>
                        <p class="mt-2">Rejoignez notre équipe dynamique pour développer des applications web innovantes.</p>
                        <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded">Postuler</button>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <div class="p-4">
                        <h3 class="font-bold text-xl">Designer UI/UX</h3>
                        <p class="text-gray-600">Localisation : Lyon</p>
                        <p class="mt-2">Nous cherchons un designer créatif pour améliorer l'expérience utilisateur de nos produits.</p>
                        <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded">Postuler</button>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                    <div class="p-4">
                        <h3 class="font-bold text-xl">Chef de Projet</h3>
                        <p class="text-gray-600">Localisation : Marseille</p>
                        <p class="mt-2">Nous recherchons un chef de projet expérimenté pour diriger nos initiatives stratégiques.</p>
                        <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded">Postuler</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Témoignages de Recruteurs</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <p class="italic">"CreeLink m'a permis de trouver des candidats qualifiés rapidement!"</p>
                    <p class="font-bold mt-2">- Marie Dupont, Responsable RH</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <p class="italic">"Un excellent service, je recommande vivement!"</p>
                    <p class="font-bold mt-2">- Jean Martin, Directeur Technique</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <p class="italic">"Une plateforme facile à utiliser pour gérer nos recrutements."</p>
                    <p class="font-bold mt-2">- Claire Leroy, Chargée de Recrutement</p>
                </div>
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
