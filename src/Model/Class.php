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
      $statement = $database->prepare("SELECT * FROM class WHERE id = $id");
      $statement->execute(array($id))
		  if (size($statement) == 1) {
			  return new Class($statement[0]);
		  } else if (!$statement) {
			     throw new Exception('Class with id '.$id.' not found.', 404);
		  } else {
			     throw new Exception('Multiple classes with id '.$id.' found.', 400);
		  }

    }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM class WHERE id = $id");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Class::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id))
    }

    static function classExistsForId($id){
        $statement = $database->prepare("SELECT * FROM class WHERE id = $id");
        $statement->execute(array($id))
        if (sizeof($class) > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getAll(){
      $statement = $database->prepare("SELECT * FROM class");
      $statement->execute(array($id))
		    if (!$statement){
			      return array();
		        }
    }

    static function classWithNameExists($name) {
        $statement = $database->prepare("SELECT * FROM class WHERE name = $name");
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
		if (Class::classWithNameExists($body['name'])){
			throw new Exception('Class already exists', 400);
		}
		$db = DB::getInstance();
		$id = $db->insert('class',['name'=>$body['name']]);
		$class = Class::getById($id);
		return $class;
    }




}
}
