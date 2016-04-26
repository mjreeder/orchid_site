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
      $statement = $database->prepare("SELECT * FROM genus WHERE id = $id");
      $statement->execute(array($id))
      if (size($statement) == 1) {
        return new Genus($statement[0]);
      } else if (!$statement) {
           throw new Exception('Genus with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple genera with id '.$id.' found.', 400);
      }
    }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM genus WHERE id = $id");
      if(!$statement){
        throw new Exception('Missing required information', 400);
      }
      if(!Class::classExistsForId($id)){
        throw new Exception('Genus with id '.$id.' not found', 404);
      }
      $statement->execute(array($id))
    }

    static function classExistsForId($id){
        $statement = $database->prepare("SELECT * FROM genus WHERE id = $id");
        $statement->execute(array($id))
        if (sizeof($statement) > 0) {
            return true;
        } else {
            return false;
        }
    }

  }
  static function getAll(){
      $statement = $database->prepare("SELECT * FROM genus");
      $statement->execute(array($id))
		  if (!$statement){
			       return array();
		  }
  }

  static function genusWithNameExists($name) {
      $statement = $database->prepare("SELECT * FROM genus WHERE name = $name");
      $statement->execute(array($id))
      if (sizeof($statement) > 0) {
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
