<?php
namespace App\Controllers;
use App\Classes\Cour;
use App\Models\CourModel;
use App\Models\PdfCourModel;
use App\Models\VideoCourModel;
use App\Models\SearchModel;

class CourController {
    public function addCourPdf ($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId){
        $cours = new Cour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        
        $CourModel = new PdfCourModel();
        $cour = $CourModel->addCour($cours);
        if(!$cour){
            echo "Traitemnt error";
        } else {
            $pathUrl = "/src/Views/";
            header("location:" .$pathUrl. "enseignant/home.php");
            exit();
        }
    }
    public function addCourVideo ($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId){
        $cours = new Cour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        
        $CourModel = new VideoCourModel();
        $cour = $CourModel->addCour($cours);
        if(!$cour){
            echo "Traitemnt error";
        } else {
            $pathUrl = "/src/Views/";
            header("location:" .$pathUrl. "enseignant/home.php");
            exit();
        }
    }

    public function editCourVideo($id,$titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId){
        $cours = new Cour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        $UpdateCour = new VideoCourModel();
        $resultUpdate = $UpdateCour->editCour($cours , $id);
        return $resultUpdate;
    }
    public function editCourPdf($id,$titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId){
        $cours = new Cour($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId);
        $UpdateCour = new PdfCourModel();
        $resultUpdate = $UpdateCour->editCour($cours , $id);
        return $resultUpdate;
    }
    
    public function fetchCour(){
        $courFetchModel = new PdfCourModel();
        $courFetch = $courFetchModel->fetchCours();
        return $courFetch;
    }
    public function fetchCourEtudiant(){
        $courFetchEtudiant = new PdfCourModel();
        $courFetchEtudiant = $courFetchEtudiant->fetchCoursEtudiant();
        return $courFetchEtudiant;
    }
    public function deleteCour($id){
        $courDelete = new PdfCourModel();
        $courIsDeleted = $courDelete->deleteCour($id);
        return $courIsDeleted;
    }
    public function numbreCours(){
        $numbreCours = new PdfCourModel();
        $countCours = $numbreCours->numbreTotalCours();
        return $countCours;
    }
    public function NombreDeCoursEnseignant(){
        $countCour = new PdfCourModel();
        $countCoursEnseignant = $countCour->CountCourEnseignant();
        return $countCoursEnseignant;
    }
    public function inscription($idCour){
        $inscriptionCour = new PdfCourModel();
        $EtudiantPostuler = $inscriptionCour->postuler($idCour);
        return $EtudiantPostuler;
       
    }
    public function deleteInscription($cour_id){
        $deleteIinscription = new PdfCourModel();
        $resultOfDelete = $deleteIinscription->cancelInsciption($cour_id); 
        $pathUrl = "/src/views/";
        header("location:" . $pathUrl . "etudiant/home.php");
    }
    public function CountInscription(){
        $CountInscription = new PdfCourModel();
        $countInscriptions = $CountInscription->CountInscriptions();
        return $countInscriptions;
    }
    public function fetchCoursInscript(){
        $fetchCoursInscript = new PdfCourModel();
        $coursInscript = $fetchCoursInscript->fetchMesCours();
        return $coursInscript;
    }
    public function searchCourEtudiant($searchInput){
        $serchResult = new PdfCourModel();
        $searchResults = $serchResult->search($searchInput);
        return $searchResults;
    }
    public function searchCourEnseignant($searchInput){
        $searchResult = new VideoCourModel();
        $searchResults = $searchResult->search($searchInput);
        return $searchResults ;
    }
    public function paginationVisieur($pagination){
        $courFetchEtudiant = new PdfCourModel();
        $courFetchEtudiant = $courFetchEtudiant->pagination($pagination);
        return $courFetchEtudiant;
    }
    public function fetchInscription(){
        $inscriptionFetch = new PdfCourModel();
        $inscriptionForEnseignant = $inscriptionFetch->fetchEnseignantInscription();
        return $inscriptionForEnseignant;
    }
    public function courPlusEtudiant(){
        $plusEtudiant = new PdfCourModel();
        $countPlusEtudiant = $plusEtudiant->CountCourPlusEtudiant();
        return $countPlusEtudiant;
    }
    public function TopEnseignant(){
        $TopEnseignant = new PdfCourModel();
        $countTopEnseignant = $TopEnseignant->countTopEnseignant();
        return $countTopEnseignant;
    }
    public function categorieNumbre(){
        $numbreCategorie = new PdfCourModel();
        $numbreRepartitionCategorie = $numbreCategorie->repartitionCategorie();
        return $numbreRepartitionCategorie;
    }
    public function CountEtudiant(){
        $numbreOfEtudiants = new PdfCourModel();
        $results = $numbreOfEtudiants->CountEtudiants();
        return $results;
    }
    public function CountEnseignant(){
        $numbreOfEnseignant = new PdfCourModel();
        $results = $numbreOfEnseignant->CountEnseignant();
        return $results;
    }
}

?>