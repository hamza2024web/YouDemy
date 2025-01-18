<?php
require_once("../../../vendor/autoload.php");

use App\Controllers\catcontroller;
use App\Config\Database;

$catControllerFetch = new catcontroller();

if (isset($_POST["add"])) {
    if (empty($_POST["cat"])) {
        echo "veuilleez saiser le nom de categorie";
    } else {
        $category_name = $_POST["cat"];

        $catController = new catcontroller();
        $catController->setCat($category_name);
    }
}
if (isset($_POST["editCat"])) {
    $id = $_POST['id'];
    $cat_name_edit = $_POST['cat'];

    $tagControllerEdit = new catcontroller();
    $tagControllerEdit->editCat($id, $cat_name_edit);
}
if (isset($_POST["deleteCate"])) {
    $id = $_POST['id'];

    $catControllerDelete = new catcontroller();
    $catControllerDelete->deleteCat($id);
}
$results = $catControllerFetch->getCat();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tags Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-blue-600 text-white w-64 min-h-screen p-6">
            <h1 class="text-2xl font-bold text-center mb-6">CareerLink</h1>
            <nav>
                <ul class="space-y-4">
                <li><a href="./dashboard.php" class="flex items-center hover:bg-blue-500 p-3 rounded transition duration-300"><i class="fas fa-tachometer-alt"></i><span class="ml-2">Tableau de bord</span></a></li>
                    <li><a href="./tag.php" class="flex items-center hover:bg-blue-500 p-3 rounded transition duration-300"><i class="fas fa-tags"></i><span class="ml-2">Tags Utilisés</span></a></li>
                    <li><a href="./categorie.php" class="flex items-center hover:bg-blue-500 p-3 rounded transition duration-300"><i class="fas fa-tags"></i><span class="ml-2">Categorie Utilisés</span></a></li>
                    <li><a href="./UsersList.php" class="flex items-center hover:bg-blue-500 p-3 rounded transition duration-300"><i class="fas fa-chart-line"></i><span class="ml-2">Users List</span></a></li>
                    <li><a href="./cours.php" class="flex items-center bg-blue-700 p-3 rounded transition duration-300"><i class="fas fa-chart-line"></i><span class="ml-2">Enseignant Cours</span></a></li>
                    <li><a href="./statistique.php" class="flex items-center hover:bg-blue-500 p-3 rounded transition duration-300"><i class="fas fa-chart-line"></i><span class="ml-2">Statistique</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">Categorie Management</h1>
                <p class="text-gray-600 text-lg mt-2">Gérez vos tags facilement. Ajoutez, modifiez ou supprimez des tags en toute simplicité.</p>
            </header>

            <!-- Tag Form -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Ajouter ou Modifier un Categorie</h2>
                <form id="tag-form" class="space-y-6" action="" method="POST">
                    <input type="hidden" name="id" id="catIdInput">

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="tagInput">Nom du categorie</label>
                        <input name="cat" type="text" id="catInput" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600 focus:ring-2 focus:ring-blue-400" placeholder="Entrez le nom du tag" />
                    </div>

                    <div>
                        <button id="addCat" type="submit" name="add" class="w-full py-3 px-4 text-sm font-semibold tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-lg">
                            Ajouter un categorie
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tag Table -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">categpries Existants</h2>
                <table class="table-auto w-full border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Nom du Tag</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($results as $result) { ?>
                            <tr class="hover:bg-gray-100 border-t border-gray-200">
                                <td class="px-6 py-4"><?= $result['id']; ?></td>
                                <td class="px-6 py-4" id="<?= 'catName' . $result['id'] ?>"><?= $result['category_name']; ?></td>
                                <td class="px-6 py-4 space-x-2">
                                    <button onclick="edit(<?= $result['id']; ?>)" type="button" class="px-3 py-2 text-sm font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                                        Modifier
                                    </button>
                                    <button onclick="deleteCat(<?= $result['id']; ?>)" class="px-3 py-2 text-sm font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function edit(id) {
            document.getElementById('addCat').name = 'editCat';
            document.getElementById('addCat').innerHTML = 'Modifier';
            let name = document.getElementById('catName' + id).innerHTML;
            document.getElementById('catInput').value = name;
            document.getElementById('catIdInput').value = id;
        }

        function deleteCat(id) {
            document.getElementById('addCat').name = 'deleteCate';
            document.getElementById('addCat').innerHTML = 'Delete';
            let name = document.getElementById('catName' + id).innerHTML;
            document.getElementById('catInput').value = name;
            document.getElementById('catIdInput').value = id;
            
            return confirm('Are you sure?');
        }
    </script>
</body>

</html>