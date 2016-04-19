<?php

namespace orchid_site\src\Model;

class Tribe implements JsonSerializable{
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
      $tribe = $db->select('tribe','*',['id' => $id]);
      if (size($genus) == 1) {
        return new Tribe($tribe[0]);
      } else if (!$tribe) {
           throw new Exception('Tribe with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple tribes with id '.$id.' found.', 400);
      }
    }

    }


  }


}
