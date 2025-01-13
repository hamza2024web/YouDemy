<?php
namespace App\Models;
use App\Classes\Users;
use App\Config\Database;
use PDO;


class EtudiantAndEnseignant {
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function setEtudiantAndenseignant($username , $email ,$password,$role,$diplomat){
        try{
            $hashedPassword = password_hash($password , PASSWORD_DEFAULT);
            $query = "INSERT INTO users (`name` , email , `password` , `role`) 
            VALUES (?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$username , $email ,$hashedPassword ,$role]);
            $userId = $this->conn->lastInsertId();
            if ($role === 'etudiant'){
                $this->addEtudiant($userId , ['deplome' => $diplomat]);
            } elseif ($role === 'enseignant'){
                $this->addEnseignant($userId);
            }
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Users($userData['email'] , $userData['password'] ,$userData['role']);
        } catch (\PDOException $e){
            error_log("Databse error:" .$e->getMessage());
            return null;
        }
    }

    private function addEtudiant($userId ,$data){
        $sql = "INSERT INTO etudiant (deplome ,user_id) VALUES (? , ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$data['deplome'] , $userId]);
    }

    private function addEnseignant($userId){
        $sql = "INSERT INTO enseignant (user_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
    }

}
?>