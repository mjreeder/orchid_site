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
      $db = DB::getInstance();
		  $class = $db->select('class','*',['id' => $id]);
		  if (size($class) == 1) {
			  return new Class($class[0]);
		  } else if (!$class) {
			     throw new Exception('Class with id '.$id.' not found.', 404);
		  } else {
			     throw new Exception('Multiple classes with id '.$id.' found.', 400);
		  }

    }

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

    static function getAll(){
		    $db = DB::getInstance();
		    $class = $db->select('class','*');
		    if (!$reservations){
			      return array();
		        }
    }

    static function classWithNameExists($name) {
        $db = DB::getInstance();
        $class = $db->select('class', '*', ['name' => $name]);
        if (sizeof($class) > 0) {
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
