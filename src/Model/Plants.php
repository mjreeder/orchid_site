<?php

namespace orchid_site\src\Model;

class Plants
{
    public $id;
    public $accession_number;
    public $class_id;
    public $tribe_id;
    public $subtribe_id;
    public $genus_id;
    public $species_id;
    public $variety_id;
    public $authority;
    public $distribution;
    public $habitat;
    public $culture;
    public $donars;
    public $date_received;
    public $received_from;
    public $description;
    public $username;
    public $new;
    public $inactive_code;
    public $inactive_date;
    public $inactive_comment;
    public $size;
    public $value;
    public $parent_one;
    public $parent_two;
    public $grex_status;
    public $hybrid_status;


    function __construct($data)
    {
        $this->id                  = isset($data['id']) ? intval($data['id']) : null;
        $this->accession_number    = isset($data['accession_number']) ? intval($data['accession_number']) : null;
        
    }

    static function createFromData($data){

    }

    static function createFromPlant($plant){

    }
    //GET ALL
    static function getAll(){

    }
    // GET BY ID
    static function getPlantById($plant_id){

    }

    // UPDATE
    static function update($id){

    }
    //DELETE
   static function delete($id){

    }

  }
