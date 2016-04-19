<?php

namespace orchid_site\src\Model;

class Subtribe implements JsonSerializable{
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
      $subtribe = $db->select('subtribe','*',['id' => $id]);
      if (size($subtribe) == 1) {
        return new Subtribe($subtribe[0]);
      } else if (!$subtribe) {
           throw new Exception('Subtribe with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple subtribes with id '.$id.' found.', 400);
      }
    }

    }


  }


}
