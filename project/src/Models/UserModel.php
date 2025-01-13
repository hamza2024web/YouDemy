<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class UserModel {
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findUserByEmail($email){
        $query = "SELECT users.id , users.email , users.password , users.role ,users.status
        FROM users WHERE users.email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email",$email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function loginSession($email ,$password){
        $userData = $this->findUserByEmail($email);
        if (!$userData){
            return false;
        }
        if ($userData){
            return $userData;
        }
        if(password_verify($password , $userData['password'])){
            session_start();
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['email'] = $userData['email'];
            $_SESSION['role'] = $userData['role'];
            $_SESSION['status'] = $userData['status'];

            error_log("Login successfly for email: $email");
            return $userData;

        } else {
            return false;
        }
    }
    public function getUsers(){
        
    }
}

?>