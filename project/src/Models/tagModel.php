<?php
namespace App\Models;
use App\Config\Database;
use App\Classes\tag;
use PDO;

class tagModel {
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function getAllTags(){
        $query = "SELECT * FROM tag";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $tagData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tagData;
    }
    public function setTagName($tag_name){
            $query = "INSERT INTO tag (tag_name) VALUES (?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":tag_name", $tag_name);
            $stmt->execute([$tag_name]);
            $tagId = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare("SELECT * FROM tag where id = ?");
            $stmt->execute([$tagId]);
            $tagData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$tagData){
                return null;
            } else {
                return new tag($tagData["id"] , $tagData["tag_name"]);
            }
    }
    public function editTagById($id , $tag_name_edit){
        $stmt = $this->conn->prepare("UPDATE tag set tag_name = :tag_name_edit WHERE id = :id");
        $stmt->bindParam(":tag_name_edit" , $tag_name_edit);
        $stmt->bindParam(":id" , $id);
        $stmt->execute();
        $newTag = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$newTag){
            return null;
        } else {
            return new tag($newTag["id"] , $newTag["tag_name"]);
        }
    }
    public function deleteTagById($id) {
        $stmt = $this->conn->prepare("DELETE FROM tag WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    
}
?>