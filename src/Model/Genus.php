<?php

namespace orchid_site\src\Model;

class Genus implements JsonSerializable{
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
      $genus = $db->select('genus','*',['id' => $id]);
      if (size($genus) == 1) {
        return new Genus($genus[0]);
      } else if (!$genus) {
           throw new Exception('Genus with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple genera with id '.$id.' found.', 400);
      }
    }

    static function delete($id){
      $db = DB::getInstance();
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Class::classExistsForId($id)){
        throw new Exception('Genus with id '.$id.' not found', 404);
      }
      $db->delete('genus', ['id' => $id]);
    }

    static function classExistsForId($id){
      $db = DB::getInstance();
        $genus = $db->select('genus', '*', ['id' => $id]);
        if (sizeof($genus) > 0) {
            return true;
        } else {
            return false;
        }
    }

  }
  static function getAll(){
		$db = DB::getInstance();
		$genus = $db->select('genus','*');
		if (!$reservations){
			return array();
		}
}

  static function genusWithNameExists($name) {
      $db = DB::getInstance();
      $genus = $db->select('genus', '*', ['name' => $name]);
      if (sizeof($genus) > 0) {
        return true;
      }
      else {
        return false;
      }
  }

static function create($body) {
  if (!$body['name']){
  throw new Exception('Missing required information', 400);
}
if (Genus::genusWithNameExists($body['name'])){
  throw new Exception('Genus already exists', 400);
}
$db = DB::getInstance();
$id = $db->insert('genus',['name'=>$body['name']]);
$genus = Genus::getById($id);
return $genus;
}
