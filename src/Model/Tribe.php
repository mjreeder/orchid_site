<?php

namespace orchid_site\src\Model;

class Tribe implements JsonSerializable{
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
      $tribe = $db->select('tribe','*',['id' => $id]);
      if (size($genus) == 1) {
        return new Tribe($tribe[0]);
      } else if (!$tribe) {
           throw new Exception('Tribe with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple tribes with id '.$id.' found.', 400);
      }
    }

<<<<<<< 204185d0d74bef4dfb2ab68c3dfe7289d8b83979
    static function tribeWithNameExists($name) {
        $db = DB::getInstance();
        $tribe = $db->select('tribe', '*', ['name' => $name]);
        if (sizeof($tribe) > 0) {
          return true;
        }
        else {
          return false;
        }
    }

=======
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
    
>>>>>>> Add delete functions to existing model
    static function getAll()
    {
      $db = DB::getInstance();
  		$tribe = $db->select('tribe','*');
  		if (!$reservations){
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


}
