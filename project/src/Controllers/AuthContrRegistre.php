<?php
namespace App\Controllers;
use App\Models\EtudiantAndEnseignant;

class AuthContrRegistre {
    public function signup ($username , $email , $password , $role , $diplomat = null ,$status = null){
        $etudiantAndEnseignant = new EtudiantAndEnseignant();
        $utilisateur = $etudiantAndEnseignant->setEtudiantAndenseignant($username , $email ,$password,$role ,$diplomat,$status);

        if($utilisateur == null){
            echo "please fields inputs and create your account ...";
        } else {
            if ($utilisateur->getStatus()=="Activation"){
                $pathUrl = "/src/views/";
                if($utilisateur->getRole()=="administrateur"){
                    header("location:" . $pathUrl . "Admin/dashboard.php");
                }
                else if($utilisateur->getRole()=="etudiant"){
                    header("location:". $pathUrl . "etudiant/home.php");
                }
                else if($utilisateur->getRole()=="enseignant"){
                    header("location:". $pathUrl ."enseignant/home.php");
                }
            } elseif ($utilisateur->getStatus()=="suspension"){
                echo "Votre compte a été suspenser";
            } elseif ($utilisateur->getStatus()=="Not Active"){
                echo "Votre compte a été Disactiver";
            }
        }

    }
}
?>