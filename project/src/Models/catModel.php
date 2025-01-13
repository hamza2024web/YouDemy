<?php
namespace App\Models;
use App\Config\Database;
use App\Classes\categories;
use PDO;

class catModel {
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function getAllCats(){
        $query = "SELECT * FROM categorie";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $catData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $catData;
    }
    public function setCatName($category_name){
        $query = "INSERT INTO categorie (category_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_name", $category_name);
        $stmt->execute([$category_name]);
        $catId = $this->conn->lastInsertId();

        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$catId]);
        $catData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$catData){
            return null;
        } else {
            return new categories($catData["id"] , $catData["category_name"]);
        }
    }
    public function editCatById($id , $cat_name_edit){
        $stmt = $this->conn->prepare("UPDATE categories set category_name = :cat_name_edit WHERE id = :id");
        $stmt->bindParam(":cat_name_edit" , $cat_name_edit);
        $stmt->bindParam(":id" , $id);
        $stmt->execute();
        $newTag = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$newTag){
            return null;
        } else {
            return new categories($newTag["id"] , $newTag["category_name"]);
        }
    }
    public function deleteCatById($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    }
}
?>