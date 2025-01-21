<?php
namespace App\Classes;

class Cour {
    private $titre ;
    private $description;
    private $fileUrl;
    private $enseignant_id;
    private $categoryId;
    private $tagId;

    public function __construct($titre,$description,$fileUrl,$enseignant_id,$categoryId,$tagId)
    {
        $this->titre=$titre;
        $this->description=$description;
        $this->fileUrl=$fileUrl;
        $this->enseignant_id=$enseignant_id;
        $this->categoryId=$categoryId;
        $this->tagId=$tagId;
    }

    public function getTitre(){
        return $this->titre;
    }
    public function getDesc(){
        return $this->description;
    }
    public function getFile(){
        return $this->fileUrl;
    }
    public function getEnseignant(){
        return $this->enseignant_id;
    }
    public function getCat(){
        return $this->categoryId;
    }
    public function getTag(){
        return $this->tagId;
    }

}
?>