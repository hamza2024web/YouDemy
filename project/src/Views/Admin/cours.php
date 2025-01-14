<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\CourController;

$coursFetch = new CourController();
if (isset($_POST["delete"])){
    $id = $_POST["cour_id"];

    $deleteCour = new CourController();
    $deleteCour->deleteCour($id);
}
$resultFetch = $coursFetch->fetchCour();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-blue-600 text-white w-64 min-h-screen p-6">
            <h1 class="text-2xl font-bold text-center mb-6">YouDemy</h1>
            <nav>
                <ul class="space-y-4">
                <li><a href="./dashboard.php" class="flex items-center hover:bg-blue-500 p-2 rounded"><i class="fas fa-tachometer-alt"></i><span class="ml-2">Tableau de bord</span></a></li>
                    <li><a href="./tag.php" class="flex items-center bg-blue-700 p-2 rounded"><i class="fas fa-tags"></i><span class="ml-2">Tags Utilisés</span></a></li>
                    <li><a href="./categorie.php" class="flex items-center bg-blue-700 p-2 rounded"><i class="fas fa-tags"></i><span class="ml-2">Categorie Utilisés</span></a></li>
                    <li><a href="./UsersList.php" class="flex items-center hover:bg-blue-500 p-2 rounded"><i class="fas fa-chart-line"></i><span class="ml-2">Users List</span></a></li>
                    <li><a href="./cours.php" class="flex items-center hover:bg-blue-500 p-2 rounded"><i class="fas fa-chart-line"></i><span class="ml-2">Enseignant Cours</span></a></li>
                    <li><a href="#" class="flex items-center hover:bg-blue-500 p-2 rounded"><i class="fas fa-chart-line"></i><span class="ml-2">Statistique</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">cours Management</h1>
                <p class="text-gray-600 text-lg mt-2">Gérez vos Cours facilement. supprimez des cours en toute simplicité.</p>
            </header>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Cours Existants</h2>
                <table class="table-auto w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-6 py-3 text-left text-sm font-medium">Nom du cour</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">description</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">contenu</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Categorie</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">tag</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">L'Enseignant</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Date De Creation</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($resultFetch as $cour) { ?>
                            <tr class="hover:bg-gray-100 border-t border-gray-200">
                                <td class="px-6 py-4"><?= $cour['titre']; ?></td>
                                <td class="px-6 py-4"><p class="text-gray-700 mb-4"><?= substr($cour['descrption'],0,20); ?>...</p></td>
                                <td class="px-6 py-4"><?= $cour['contenu']; ?></td>
                                <td class="px-6 py-4"><?= $cour['category_name']; ?></td>
                                <td class="px-6 py-4"><?= $cour['tag_name']; ?></td>
                                <td class="px-6 py-4"><?= $cour['enseignant_name']; ?></td>
                                <td class="px-6 py-4"><?= $cour['created_at']; ?></td>
                                <td class="px-6 py-4 space-x-2">
                                    <form action="" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer ce cours ?');">
                                        <input type="hidden" name="cour_id" value="<?= $cour['id']; ?>" />
                                        <button type="submit" name="delete" class="bg-red-500 text-white py-2 px-4 rounded shadow-md flex items-center space-x-2 hover:bg-red-600">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Supprimer</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>