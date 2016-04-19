<?php

namespace orchid_site\src\Model;

class Variety implements JsonSerializable{
  public $id;
  public $name;


   function __construct($data){
    if (is_array($data)){
      $this->id    = intval($data['id']);
      $this->name  = $data['name'];
    }
    function jsonSerialize(){
      return [
      'id'       => $this->id,
      'name'     => $this->name
    ];
    }
    static function getById($id){
      $db = DB::getInstance();
      $variety = $db->select('variety','*',['id' => $id]);
      if (size($variety) == 1) {
        return new Variety($genus[0]);
      } else if (!$variety) {
           throw new Exception('Variety with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple varities with id '.$id.' found.', 400);
      }
    }

    }


  }


}
