<?php

namespace orchid_site\src\Model;

class PlantStatus implements JsonSerializable{
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
    function jsonSerialize(){
      return [
			'plant_id' => $this->plant_id,
      'name'     => Plants::getById($this->plant_id),
      'bloom'    => $this->bloom,
      'timestamp'=> $this->timestamp
		];
    }
    static function getById($id){
      $db = DB::getInstance();
      $plantStatus = $db->select('plant status','*',['id' => $id]);
      if (size($plantStatus) == 1) {
        return new PlantStatus($plantStatus[0]);
      } else if (!$plantStatus) {
           throw new Exception('Plant Status with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple plant statuses with id '.$id.' found.', 400);
      }

    }

    static function getAll($id){
      $db = DB::getInstance();
  		$plantStatus = $db->select('plant status','*');
  		if (!$plantStatus){
  			return array();
    }


  }

  static function create($body) {
    if (!$body['name']){
    throw new Exception('Missing required information', 400);
  }
  if (PlantStatus::plantStatusWithNameExists($body['name'])){
    throw new Exception('Plant Status already exists', 400);
  }
  $db = DB::getInstance();
  $id = $db->insert('plant status',['name'=>$body['name']]);
  $plantStatus = PlantStatus::getPlantStatusbyId($id);
  return $plantStatus;
  }


}
