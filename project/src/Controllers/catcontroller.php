<?php
namespace App\Controllers;
use App\Models\catModel;

class catcontroller {
    public function getCat(){
        $catModelFetch = new catModel();
        $catFetch = $catModelFetch->getAllCats();
        return $catFetch;

        if($catFetch == null){
            echo "please check your code fetch ...";
        } else {
            $pathUrl = "/src/views";
            header("location:" .$pathUrl . "categorie/tag.php");
        }
    }
    public function setCat($category_name){
        $catModel = new catModel();
        $cat = $catModel->setCatName($category_name);

        if($cat == null){
            echo "please verifiy your input ...";
        } else {
            return $cat;
        }
    }
    public function editCat($id , $cat_name_edit){
        $catModelEdit = new catModel();
        $catEdit = $catModelEdit->editCatById($id , $cat_name_edit);
        return $catEdit;
    }
    public function deleteCat($id) {
        $catModelDelete = new catModel();
        $result = $catModelDelete->deleteCatById($id);
    }
}
?>