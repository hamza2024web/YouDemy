<?php
namespace App\Controllers;
use App\Classes\Cour;
use App\Models\CourModel;

class CourController {
    public function addCour ($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId){
        $cours = new Cour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        
        $CourModel = new CourModel();
        $cour = $CourModel->CourModel($cours);
        if(!$cour){
            echo "Traitemnt error";
        } else {
            $pathUrl = "/src/Views/";
            header("location:" .$pathUrl. "enseignant/home.php");
            exit();
        }
    }
    public function fetchCour(){
        $courFetchModel = new CourModel();
        $courFetch = $courFetchModel->fetchCours();
        return $courFetch;
    }
    public function deleteCour($id){
        $courDelete = new CourModel();
        $courIsDeleted = $courDelete->deleteCour($id);
        return $courIsDeleted;
    }
}

?>