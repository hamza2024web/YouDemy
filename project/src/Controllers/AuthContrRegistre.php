<?php
namespace App\Controllers;
use App\Models\EtudiantAndEnseignant;
use App\Models\UserModel;

class AuthContrRegistre {
    public function signup ($username , $email , $password , $role , $diplomat = null ,$status = null){
        $etudiantAndEnseignant = new EtudiantAndEnseignant();
        $utilisateur = $etudiantAndEnseignant->setEtudiantAndenseignant($username , $email ,$password,$role ,$diplomat,$status);
        $pathUrl = "/src/views/";
        if($utilisateur == null){
            echo "please fields inputs and create your account ...";
        } else {
            if ($utilisateur->getStatus()=="Activation"){
                if($utilisateur->getRole()=="administrateur"){
                    header("location:" . $pathUrl . "auth/login.php");
                }
                else if($utilisateur->getRole()=="etudiant"){
                    header("location:" . $pathUrl . "auth/login.php");
                }
                else if($utilisateur->getRole()=="enseignant"){
                    header("location:" . $pathUrl . "auth/login.php");
                }
            } elseif ($utilisateur->getStatus()=="suspension"){
                header("location:" . $pathUrl . "auth/login.php");
                echo "Votre compte a été suspenser";
            } elseif ($utilisateur->getStatus()=="Not Active"){
                header("location:" . $pathUrl . "auth/login.php");
                echo "Votre compte a été Disactiver";
            }
        }

    }
    public function updateStatus($id , $newstatus){
        $statusModel = new UserModel();
        $statusUpdate = $statusModel->editStatusById($id , $newstatus);
        return $statusUpdate;
    }
}
?>