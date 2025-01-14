<?php
session_start();
require_once("../../../vendor/autoload.php");
use App\Controllers\catcontroller;
use App\Controllers\tagController;
use App\Controllers\CourController;

$fetchCats = new catcontroller();
$resultsCats = $fetchCats->getCat();

$fetchTags = new tagController();
$resultsTags = $fetchTags->getTag();

if(isset($_POST["add"])){
    if(empty($_POST["tag"]) || empty($_POST["categorie"]) || empty($_POST["titre"]) || empty($_FILES["contenu"]) || empty($_POST["discription"])){
        echo "Please fields your inputs ...";
    } else {
        $uploadDir = "../../uploads/";
        $fileName = basename($_FILES["contenu"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        if($fileType !== "pdf"){
            die("only PDF files are allowed");
        }

        if(move_uploaded_file($_FILES["contenu"]["tmp_name"],$targetFilePath)){
            $titre = $_POST["titre"];
            $description = $_POST["discription"];
            $categoryId = $_POST["categorie"];
            $tagId = $_POST["tag"];
            $fileUrl = "/uploads/" .$fileName;
            $enseignant_id = $_SESSION["user_id"];
            $addCour = new CourController();
            $addCour->addCour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Offres</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg">
        <form id="cour-form" class="space-y-6" action="" method="POST" enctype="multipart/form-data">
            <div class="mb-6">
                <h3 class="text-gray-800 text-4xl font-extrabold">Add Offres</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Add your offre here, and explore more passionate candidates in our platform.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div>
                    <label for="tag" class="block text-gray-700 font-medium mb-2">Tags</label>
                    <select name="tag" id="tag" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a Tag</option>
                        <?php
                        foreach ($resultsTags as $resultTag) {
                            echo "<option value='{$resultTag['id']}'>{$resultTag['tag_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="categorie" class="block text-gray-700 font-medium mb-2">Categories</label>
                    <select name="categorie" id="categorie" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a Category</option>
                        <?php
                        foreach ($resultsCats as $resultCat) {
                            echo "<option value='{$resultCat['id']}'>{$resultCat['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <label for="titre" class="block text-gray-700 font-medium mb-2">Titre</label>
                <input name="titre" id="titre" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter post title">
            </div>
            <div>
                <label for="contenu" class="block text-gray-700 font-medium mb-2">Contenu</label>
                <input name="contenu" type="file" id="contenu" accept=".pdf" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter Contenu"></textarea>
            </div>
            <div>
                <label for="discription" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="discription" id="discription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter description"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" name="add" class="w-full py-3 px-6 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    Add cours
                </button>
            </div>
        </form>
    </div>
</body>

</html>
