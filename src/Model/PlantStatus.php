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

    }


  }


}
