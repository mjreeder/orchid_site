<?php

namespace orchid_site\src\Model;

class PlantStatus implements \JsonSerializable{
  public $plant_id;
  public $name;
  public $bloom;
  public $pests;
  public $timestamp;


   function __construct($data){
    if (is_array($data)){
      $this->plant_id    = intval($data['plant_id']);
      $this->name        = $data['name'];
      $this->bloom       = (bool) $data['bloom'];
      $this->pests       = $data('pests');
      $this->timestamp   = intval($data['timestamp']);
    }
  }

    function jsonSerialize(){
      return [
			'plant_id' => $this->plant_id,
      'name'     => Plants::getById($this->plant_id),
      'bloom'    => $this->bloom,
      'timestamp'=> $this->timestamp
		  ];
    }

    static function getById($id){
      $statement = $database->prepare("SELECT * FROM plant status WHERE id = $id");
      $statement->execute(array($id));
      if (size($statement) == 1) {
        return new PlantStatus($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant Status with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple plant statuses with id '.$id.' found.', 400);
      }
    }

    static function getAll($id){
      $statement = $database->prepare("SELECT * FROM plant status");
      $statement->execute(array($id));
  		if (!$statement){
  			return array();
    }
  }

    static function delete($id){
      $statement = $database->prepare("DELETE * FROM plant status");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!PlantStatus::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id));
    }

    static function plantStatusExistsForId($id){
      $statement = $database->prepare("SELECT * FROM plant status WHERE id = $id");
      $statement->execute(array($id));
        if (sizeof($statement) > 0) {
            return true;
        } else {
            return false;
        }
    }


  static function plantStatusWithNameExists($name) {
      $statement = $database->prepare("SELECT * FROM plant status WHERE name = $name");
      if (sizeof($statement) > 0) {
        return true;
      }
      else {
        return false;
      }
  }

  static function create($body) {
    if (!$body['name'] || !$body['bloom'] || !$body['pests'] || !$body['timestamp']){
    throw new Exception('Missing required information', 400);
  }
  if (PlantStatus::plantStatusWithNameExists($body['name'])){
    throw new Exception('Plant Status already exists', 400);
  }
  $db = DB::getInstance();
  $id = $db->insert('plant status',['name'=>$body['name'], 'bloom'=>$body['bloom'], 'pests'=>$body['pests'], 'timestamp'=>$body['timestamp']]);
  $plantStatus = PlantStatus::getById($id);
  return $plantStatus;
  }
}
