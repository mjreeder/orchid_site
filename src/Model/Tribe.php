<?php

namespace orchid_site\src\Model;

class Tribe implements \JsonSerializable{
  public $id;
  public $name;


   function __construct($data){
    if (is_array($data)){
      $this->id    = intval($data['id']);
      $this->name  = $data['name'];
    }
  }

    function jsonSerialize(){
      return [
      'id'       => $this->id,
      'name'     => $this->name
     ];
    }

    static function getById($id){
      $statement = $database->prepare("SELECT * FROM tribe WHERE id = $id");
      $statement->execute(array($id));
      if (size($statement) == 1) {
        return new Tribe($statement[0]);
      } else if (!$statement) {
           throw new Exception('Tribe with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple tribes with id '.$id.' found.', 400);
      }
    }

    static function tribeWithNameExists($name) {
        $statement = $database->prepare("SELECT * FROM tribe WHERE name = $name");
        $statement->execute(array($id));
        if (sizeof($statement) > 0) {
          return true;
        }
        else {
          return false;
        }
    }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM tribe WHERE id = $id");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Tribe::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id));
    }

    static function classExistsForId($id){
        $statement = $database->prepare("SELECT * FROM tribe WHERE id = $id");
        $statement->execute(array($id));
        if (sizeof($class) > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getAll()
    {
      $statement = $database->prepare("SELECT * FROM tribe");
      $statement->execute(array($id));
      $db = DB::getInstance();
  		$tribe = $db->select('tribe','*');
  		if (!$tribe){
  			return array();
    }

    }

    static function create($body) {
      if (!$body['name']){
      throw new Exception('Missing required information', 400);
    }
    if (Tribe::tribeWithNameExists($body['name'])){
      throw new Exception('Tribe already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('tribe',['name'=>$body['name']]);
    $tribe = Tribe::getById($id);
    return $tribe;
    }
}
