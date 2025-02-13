<?php

namespace App\Models;
use App\Config\Database;
use PDO;
use PDOException;

abstract class CourModel
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    abstract public function addCour($cours);
    abstract public function search($searchInput);
    abstract public function editCour($cours , $id);

    public function attachCourToTag($courId, $tagId)
    {
        try {
            $sql = "INSERT INTO avoir (cour_id , tag_id) 
                VALUES (:cour_id , :tag_id)";
            $stmt = $this->conn->prepare($sql);
            foreach ($tagId as $tag){
                $stmt->bindParam(":cour_id", $courId);
                $stmt->bindParam(":tag_id", $tag);
                $stmt->execute();
            }
            return $courId;
        } catch (PDOException $e) {
            echo "Error attaching tag to offer:" . $e->getMessage();
            return null;
        }
    }

    public function fetchCours()
    {
        $enseignant = $_SESSION["user_id"];
        $query = "SELECT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,GROUP_CONCAT(tag.tag_name) as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id
            WHERE users.id = :enseignant
            GROUP BY cours.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":enseignant", $enseignant);
        $stmt->execute();
        $courFetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courFetch;
    }
    public function fetchCoursEtudiant()
    {
        $query = "SELECT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,GROUP_CONCAT(tag.tag_name) as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id
            GROUP BY cours.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $courFetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courFetch;
    }
    public function deleteCour($id)
    {
        $query = "DELETE FROM avoir WHERE cour_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $queryInscription = "DELETE from inscription WHERE cour_id = :id";
        $stmt = $this->conn->prepare($queryInscription);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $sql = "DELETE FROM cours WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchMesCours()
    {
        $etudiant_id = $_SESSION["user_id"];
        $query = "SELECT DISTINCT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,GROUP_CONCAT(tag.tag_name) as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id
            INNER JOIN inscription ON inscription.cour_id = cours.id
            INNER JOIN etudiant ON etudiant.id = inscription.etudiant_id
            WHERE etudiant.user_id = :etudiant_id
            GROUP BY cours.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":etudiant_id", $etudiant_id);
        $stmt->execute();
        $courInscript = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courInscript;
    }
    public function numbreTotalCours()
    {
        $query = "SELECT count(*) as numbretotalCour FROM cours";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['numbretotalCour'];
        } else {
            return false;
        }
    }
    public function CountCourEnseignant()
    {
        $enseignant_id = $_SESSION["user_id"];
        $query = "SELECT COUNT(*) as numbreCour FROM cours
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            WHERE users.id = :enseignant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":enseignant_id", $enseignant_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["numbreCour"];
        } else {
            return false;
        }
    }
    public function postuler($idCour)
    {
        try {
            $etudiant_id = $_SESSION["user_id"];
            $sql = "SELECT * FROM etudiant WHERE user_id = :user_id";
            $etudiantStmt = $this->conn->prepare($sql);
            $etudiantStmt->bindParam(":user_id", $etudiant_id);
            $etudiantStmt->execute();
            $etudiant = $etudiantStmt->fetch();
            if (!$etudiant) {
                echo "Etudiant not found! , Please ensure your account is registred or login correctly!";
                return null;
            }
            $etudiant_id_cour = $etudiant["id"];
            $query = "INSERT INTO inscription (etudiant_id , cour_id) VALUES (:idEtudiant , :idCour)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":idEtudiant", $etudiant_id_cour);
            $stmt->bindParam(":idCour", $idCour);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error attaching Cour to Etudiant:" . $e->getMessage();
            return null;
        }
    }
    public function CountInscriptions()
    {
        $enseignant_id = $_SESSION["user_id"];
        $query = "SELECT COUNT(*) as numbreInscription FROM inscription
            INNER JOIN cours ON inscription.cour_id = cours.id
            INNER JOIN enseignant ON cours.enseignant_id = enseignant.id
            WHERE enseignant.user_id = :enseignant_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":enseignant_id", $enseignant_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["numbreInscription"];
        } else {
            return false;
        }
    }
    public function pagination($pagination){
    $query = "SELECT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,GROUP_CONCAT(tag.tag_name) as tag_name FROM cours
        INNER JOIN categorie ON categorie.id = cours.category_id
        INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
        INNER JOIN users ON enseignant.user_id = users.id
        INNER JOIN avoir ON avoir.cour_id = cours.id
        INNER JOIN tag ON avoir.tag_id = tag.id
        GROUP BY cours.id
        Limit $pagination";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $courFetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $courFetch;
    }
    public function fetchEnseignantInscription(){
        session_start();
        $enseignant = $_SESSION["user_id"];
        $query = "SELECT etudiant.id ,users.name as etudiant_name , users.email as etudiant_email , cours.titre ,inscription.date_postuler FROM inscription 
        INNER JOIN etudiant ON inscription.etudiant_id = etudiant.id
        INNER JOIN users ON etudiant.user_id = users.id
        INNER JOIN cours ON inscription.cour_id = cours.id
        INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
        WHERE enseignant.user_id = :enseignant";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":enseignant",$enseignant);
        $stmt->execute();
        $inscription = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $inscription ;
    }
    public function CountCourPlusEtudiant(){
        $query = "SELECT cours.titre , COUNT(inscription.etudiant_id) as numbre_etudiant FROM cours
        INNER JOIN inscription ON cours.id = inscription.cour_id
        GROUP BY cours.id , cours.titre
        ORDER BY  numbre_etudiant DESC
        LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['titre'];
        } else {
            return false;
        }
    }
    public function countTopEnseignant() {
        $query = "SELECT users.name, COUNT(cours.enseignant_id) as topEnseignant FROM cours
        INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
        INNER JOIN users ON users.id = enseignant.user_id
        GROUP BY users.name
        ORDER BY topEnseignant DESC
        LIMIT 3;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false;
        }
    }
    public function repartitionCategorie(){
        $query = "SELECT categorie.category_name , COUNT(cours.category_id) as numbre_categorie FROM cours 
        INNER JOIN categorie ON categorie.id = cours.category_id
        GROUP BY categorie.category_name ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() >0 ){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false ;
        }
    }
    public function CountEtudiants(){
        $query = "SELECT COUNT(etudiant.user_id) AS numbre_etudiant FROM etudiant";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() >0 ){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results["numbre_etudiant"];
        } else {
            return false ;
        }
    }
    public function CountEnseignant(){
        $query = "SELECT COUNT(enseignant.user_id) as numbre_enseignant FROM enseignant";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() >0 ){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results["numbre_enseignant"];
        } else {
            return false ;
        }
    }
    public function cancelInsciption($cour_id){
        $etudiantt_id = $_SESSION["user_id"];
        $queryToGetTheUser = "SELECT etudiant.id FROM etudiant
        INNER JOIN users ON etudiant.user_id = users.id
        WHERE users.id = :etudiant_id";
        $stmt = $this->conn->prepare($queryToGetTheUser);
        $stmt->bindParam(":etudiant_id",$etudiantt_id);
        $stmt->execute();
        $etudiant = $stmt->fetch();
        $etudiantId = $etudiant["id"];
        $query = "DELETE FROM inscription WHERE etudiant_id = :user_id AND cour_id = :cour_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id",$etudiantId);
        $stmt->bindParam(":cour_id",$cour_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
