<?php

namespace orchid_site\src\Model;

class Subtribe implements \JsonSerializable{
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
      $statement = $database->prepare("SELECT * FROM subtribe WHERE id = $id");
      $statement->execute(array($id));
      if (size($statement) == 1) {
        return new Subtribe($statement[0]);
      } else if (!$statement) {
           throw new Exception('Subtribe with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple subtribes with id '.$id.' found.', 400);
      }
    }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM subtribe WHERE id = $id");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!Subtribe::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id));
    }

    static function classExistsForId($id){
        $statement = $database->prepare("SELECT * FROM subtribe WHERE id = $id");
        $statement->execute(array($id));
        if (sizeof($class) > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getAll()
    {
      $statement = $database->prepare("SELECT * FROM subtribe");
      $statement->execute(array($id));
  		if (!$subtribe){
  			return array();
    }

    }

    static function subtribeWithNameExists($name) {
        $statement = $database->prepare("SELECT * FROM subtribe WHERE name = $name");
        $statement->execute(array($id))
;        if (sizeof($subtribe) > 0) {
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
    if (Subtribe::subtribeWithNameExists($body['name'])){
      throw new Exception('Subtribe already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('subtribe',['name'=>$body['name']]);
    $subtribe = Subtribe::getById($id);
    return $subtribe;
    }
}
