<?php

namespace App\Models;
use App\Models\CourModel;
use PDOException;
use PDO;

class VideoCourModel extends CourModel
{
    public function addCour($cours)
    {
        try {
            $enseignantt = $cours->getEnseignant();
            $enseignantQuery = "SELECT id FROM enseignant WHERE user_id = :user_id";
            $enseignantStmt = $this->conn->prepare($enseignantQuery);
            $enseignantStmt->bindParam(":user_id", $enseignantt);
            $enseignantStmt->execute();
            $enseignant = $enseignantStmt->fetch();
            if (!$enseignant) {
                echo "Enseignant not found. Please ensure !Your Account is registred as a enseignant";
                return null;
            }
            $enseignant_id = $enseignant['id'];
            $categoryId = $cours->getCat();
            $categoryQuery = "SELECT id FROM categorie WHERE id = :id";
            $categoryStmt = $this->conn->prepare($categoryQuery);
            $categoryStmt->bindParam("id", $categoryId);
            $categoryStmt->execute();
            $category_cour_id = $categoryStmt->fetch();
            if (!$category_cour_id) {
                echo "Category not found";
                return null;
            }
            $category_id_cour = $category_cour_id['id'];
            $query = "INSERT INTO cours (titre,descrption,contenu,enseignant_id,category_id)
            VALUES (:titre , :description ,:contenu,:enseignant_id,:category_id)";
            $titre = $cours->getTitre();
            $description = $cours->getDesc();
            $contenu = $cours->getFile();
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":titre", $titre);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":contenu", $contenu);
            $stmt->bindParam(":enseignant_id", $enseignant_id);
            $stmt->bindParam(":category_id", $category_id_cour);
            $isCourInserted = $stmt->execute();
            $courId = $this->conn->lastInsertId();
            if ($isCourInserted && $courId) {
                $attachCourToTag = $this->attachCourToTag($courId, $cours->getTag());
                if ($attachCourToTag) {
                    return $cours;
                }
            }
            return null;
        } catch (PDOException $e) {
            echo "Error adding cours:" . $e->getMessage();
            return null;
        }
    }
    public function search($searchInput){
        $enseigant = $_SESSION["user_id"];
        $query = "SELECT cours.id,cours.titre , cours.descrption ,cours.contenu , cours.enseignant_id,cours.created_at ,users.name as enseignant_name , categorie.category_name , GROUP_CONCAT(tag.tag_name) as tag_name   FROM cours 
        INNER JOIN categorie ON cours.category_id = categorie.id
        INNER JOIN enseignant ON cours.enseignant_id = enseignant.id
        INNER JOIN users ON enseignant.user_id = users.id
        INNER JOIN avoir ON avoir.cour_id = cours.id
        INNER JOIN tag ON avoir.tag_id = tag.id
        WHERE titre like :searchInput AND users.id = :enseignant
        GROUP BY cours.id";
        $stmt = $this->conn->prepare($query);
        $search = "%$searchInput%";
        $stmt->bindParam(":searchInput" , $search);
        $stmt->bindParam(":enseignant",$enseigant);
        $stmt->execute();
        $searchResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $searchResult;
    }
    public function editCour($cours , $id){
        try {
            $enseignantt = $cours->getEnseignant();
            $enseignantQuery = "SELECT id FROM enseignant WHERE user_id = :user_id";
            $enseignantStmt = $this->conn->prepare($enseignantQuery);
            $enseignantStmt->bindParam(":user_id", $enseignantt);
            $enseignantStmt->execute();
            $enseignant = $enseignantStmt->fetch();
            if (!$enseignant) {
                echo "Enseignant not found. Please ensure !Your Account is registred as a enseignant";
                return null;
            }
            $enseignant_id = $enseignant['id'];
            $categoryId = $cours->getCat();
            $categoryQuery = "SELECT id FROM categorie WHERE id = :id";
            $categoryStmt = $this->conn->prepare($categoryQuery);
            $categoryStmt->bindParam("id", $categoryId);
            $categoryStmt->execute();
            $category_cour_id = $categoryStmt->fetch();
            if (!$category_cour_id) {
                echo "Category not found";
                return null;
            }
            $category_id_cour = $category_cour_id['id'];
            $query = "UPDATE cours set titre = :titre , descrption = :description , contenu = :contenu ,enseignant_id = :enseignant, category_id = :catgeory_id
            WHERE id = :id";
            $titre = $cours->getTitre();
            $description = $cours->getDesc();
            $contenu = $cours->getFile();
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":titre",$titre);
            $stmt->bindParam(":description",$description);
            $stmt->bindParam(":contenu",$contenu);
            $stmt->bindParam(":enseignant_id",$enseignant_id);
            $stmt->bindParam(":category_id",$category_id_cour);
            $isCourInserted = $stmt->execute();
            $courId = $this->conn->lastInsertId();
            if ($isCourInserted && $courId){
                $attachCourToTag = $this->attachCourToTag($courId , $cours->getTag());
                if ($attachCourToTag){
                    return $cours;
                }
            }
            return null;
            } catch (PDOException $e) {
                echo "Error Editing cour:" .$e->getMessage();
                return null;
            }
    }

}
