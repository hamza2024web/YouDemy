<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserControlle {
    public function getUser(){
        $userModelFetch = new UserModel();
        $userfetch = $userModelFetch->getAllUsers();
        return $userfetch;
        if ($userfetch == null){
            echo "please check your fetch ...";
        } else {
            $pathUrl = "/src/views";
            header("location:" .$pathUrl. "Admin/UserList");
        }
    }
}

?>