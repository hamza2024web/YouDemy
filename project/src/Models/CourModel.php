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
    abstract public function search($searchInput){}

    public function attachCourToTag($courId, $tagId)
    {
        try {
            $sql = "INSERT INTO avoir (cour_id , tag_id) 
                VALUES (:cour_id , :tag_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":cour_id", $courId);
            $stmt->bindParam(":tag_id", $tagId);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error attaching tag to offer:" . $e->getMessage();
            return null;
        }
    }

    public function fetchCours()
    {
        $enseignant = $_SESSION["user_id"];
        $query = "SELECT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,tag.tag_name as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id
            WHERE users.id = :enseignant";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":enseignant", $enseignant);
        $stmt->execute();
        $courFetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $courFetch;
    }
    public function fetchCoursEtudiant()
    {
        $query = "SELECT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,tag.tag_name as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id";
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
        $query = "SELECT DISTINCT cours.id ,cours.titre , cours.descrption ,cours.contenu,cours.category_id,categorie.category_name as category_name ,cours.enseignant_id,users.name as enseignant_name,cours.created_at,tag.tag_name as tag_name FROM cours
            INNER JOIN categorie ON categorie.id = cours.category_id
            INNER JOIN enseignant ON enseignant.id = cours.enseignant_id
            INNER JOIN users ON enseignant.user_id = users.id
            INNER JOIN avoir ON avoir.cour_id = cours.id
            INNER JOIN tag ON avoir.tag_id = tag.id
            INNER JOIN inscription ON inscription.cour_id = cours.id
            INNER JOIN etudiant ON etudiant.id = inscription.etudiant_id
            WHERE etudiant.user_id = :etudiant_id";
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
}
