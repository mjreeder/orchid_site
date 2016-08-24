<?php

namespace orchid_site\src\Model;

class Variety implements \JsonSerializable{
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
      $statement = $database->prepare("SELECT * FROM variety WHERE id = $id");
      $statement->execute(array($id));
      if (size($statement) == 1) {
        return new Variety($statement[0]);
      } else if (!$statement) {
           throw new Exception('Variety with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple varities with id '.$id.' found.', 400);
      }
    }

    static function varietyWithNameExists($name) {
        $statement = $database->prepare("SELECT * FROM variety WHERE name = $name");
        $statement->execute(array($id));
        if (sizeof($variety) > 0) {
          return true;
        }
        else {
          return false;
        }
      }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM variety WHERE id = $id");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Variety::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id));
    }

    static function classExistsForId($id){
        $statement = $database->prepare("SELECT * FROM variety WHERE id = $id");
        $statement->execute(array($id));
        if (sizeof($statement) > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getAll()
    {
      $statement = $database->prepare("SELECT * FROM variety");
      $statement->execute(array($id));
  		if (!$statement){
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
