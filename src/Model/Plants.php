<?php

namespace orchid_site\src\Model;

class Plants
{
    public $id;


    function __construct($data)
    {
        $this->id     = isset($data['id']) ? intval($data['id']) : null;
    }

    public static function createFromData($data){

    }

    public static function createFromPlant($plant){

    }
    //GET ALL
    public static function getAll(){

    }
    // GET BY ID
    public static function getPlantById($plant_id){

    }

    // UPDATE
    public static function update($id){

    }
    //DELETE
    public static function delete($id){

    }

  }
