<?php
namespace App\Controllers;
use App\Models\tagModel;

class tagController {
    public function getTag(){
        $tagModelFetch = new tagModel();
        $tagFetch = $tagModelFetch->getAllTags();
        return $tagFetch;

        if($tagFetch == null){
            echo "please check your code fetch ...";
        } else {
            $pathUrl = "/src/views";
            header("location:" .$pathUrl . "Admin/tag.php");
        }
        
    }
    public function setTag($tag_name){
        $tagModel = new tagModel();
        $tag = $tagModel->setTagName($tag_name);

        if($tag == null){
            echo "please verifiy your input ...";
        } else {
            return $tag;
        }
    }
    public function editTag($id , $tag_name_edit){
        $tagModelEdit = new tagModel();
        $tagEdit = $tagModelEdit->editTagById($id , $tag_name_edit);
        return $tagEdit;
    }
    public function deletetag($id) {
        $tagModelDelete = new tagModel();
        $result = $tagModelDelete->deleteTagById($id);
    }
}
?>