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

    static function getAll()
    {
      $db = DB::getInstance();
  		$subtribe = $db->select('subtribe','*');
  		if (!$reservations){
  			return array();
    }

    }

    static function create($body) {
      if (!$body['name']){
      throw new Exception('Missing required information', 400);
    }
    if (Subtribe::subtribeWithNameExists($body['name'])){
      throw new Exception('Subtribe already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('subtribe',['name'=>$body['name']]);
    $subtribe = Subtribe::getSubtribebyId($id);
    return $subtribe;
    }


  }


}
