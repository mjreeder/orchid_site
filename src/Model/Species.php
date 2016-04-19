<?php

namespace orchid_site\src\Model;

class Species implements JsonSerializable{
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
      $species = $db->select('species','*',['id' => $id]);
      if (size($species) == 1) {
        return new Species($species[0]);
      } else if (!$species) {
           throw new Exception('Species with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple species with id '.$id.' found.', 400);
      }
    }

    }


  }


}
