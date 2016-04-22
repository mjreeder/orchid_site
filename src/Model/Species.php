<?php

namespace orchid_site\src\Model;

class Species implements JsonSerializable{
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
      $species = $db->select('species','*',['id' => $id]);
      if (size($species) == 1) {
        return new Species($species[0]);
      } else if (!$species) {
           throw new Exception('Species with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple species with id '.$id.' found.', 400);
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

    static function getAll()
    {
      $db = DB::getInstance();
  		$species = $db->select('species','*');
  		if (!$species){
  			return array();
    }



    }

    static function speciesWithNameExists($name) {
        $db = DB::getInstance();
        $species = $db->select('species', '*', ['name' => $name]);
        if (sizeof($species) > 0) {
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
    if (Species::speciesWithNameExists($body['name'])){
      throw new Exception('Species already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('species',['name'=>$body['name']]);
    $species = Species::getById($id);
    return $species;
    }


  }


}
