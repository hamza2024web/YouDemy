<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class CourModel {
        private $conn;

        public function __construct()
        {
            $db = new Database();
            $this->conn = $db->connect();
        }

        public function CourModel($cours){
            try{
                $enseignants_id = $_SESSION['user_id'];
                $enseignantQuery = "SELECT id FROM enseignant WHERE user_id = :user_id";
                $enseignantStmt = $this->conn->prepare($enseignantQuery);
                $enseignantStmt->bindParam(":user_id",$enseignants_id);
                $enseignantStmt->execute();
                $enseignant = $enseignantStmt->fetch();
                if (!$enseignant){
                    echo "Enseignant not found. Please ensure !Your Account is registred as a enseignant";
                    return null;
                }
                $enseignant_id = $enseignant['id'];
                $categoryId = $cours->getCat();
                $categoryQuery = "SELECT id FROM categorie WHERE id = :id";
                $categoryStmt = $this->conn->prepare($categoryQuery);
                $categoryStmt->bindParam("id",$categoryId);
                $categoryStmt->execute();
                $category_cour_id = $categoryStmt->fetch();
                if (!$category_cour_id){
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

            } catch (PDOException $e){
                echo "Error adding cours:" .$e->getMessage();
                return null;
            }
        }
        private function attachCourToTag($courId , $tagId){
            try{
                $sql = "INSERT INTO avoir (cour_id , tag_id) 
                VALUES (:cour_id , :tag_id)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":cour_id",$courId);
                $stmt->bindParam(":tag_id",$tagId);
                return $stmt->execute();
            } catch (PDOException $e){
                echo "Error attaching tag to offer:" .$e->getMessage();
                return null;
            }
        }
        public function fetchCours(){
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
        public function deleteCour($id){
            $query = "DELETE FROM avoir WHERE cour_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id",$id);
            $stmt->execute();

            $sql = "DELETE FROM cours WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                return false; 
            }
        }
        public function numbreTotalCours(){
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


}

?>