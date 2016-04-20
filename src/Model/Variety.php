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

    static function varietyWithNameExists($name) {
        $db = DB::getInstance();
        $variety = $db->select('variety', '*', ['name' => $name]);
        if (sizeof($variety) > 0) {
          return true;
        }
        else {
          return false;
    static function delete($id){
      $db = DB::getInstance();
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Class::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $db->delete('class', ['id' => $id]);
    }

    static function classExistsForId($id){
      $db = DB::getInstance();
        $class = $db->select('class', '*', ['id' => $id]);
        if (sizeof($class) > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getAll()
    {
      $db = DB::getInstance();
  		$variety = $db->select('variety','*');
  		if (!$reservations){
  			return array();
    }

    }

    static function create($body) {
      if (!$body['name']){
      throw new Exception('Missing required information', 400);
    }
    if (Variety::varietyWithNameExists($body['name'])){
      throw new Exception('Variety already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('variety',['name'=>$body['name']]);
    $variety = Variety::getById($id);
    return $variety;
    }


  }


}
