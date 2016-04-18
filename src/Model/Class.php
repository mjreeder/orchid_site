<?php

namespace orchid_site\src\Model;

class Class implements JsonSerializable{
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

    }


  }


}
