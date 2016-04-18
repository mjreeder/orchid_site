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
        $this->class_id            = isset($data['class_id']) ? intval($data['class_id']) : null;
        $this->tribe_id            = isset($data['tribe_id']) ? intval($data['tribe_id']) : null;
        $this->subtribe_id         = isset($data['subtribe_id ']) ? intval($data['subtribe_id ']) : null;
        $this->genus_id            = isset($data['genus_id']) ? intval($data['genus_id']) : null;
        $this->species_id          = isset($data['species_id']) ? intval($data['species_id']) : null;
        $this->variety_id          = isset($data['variety_id']) ? intval($data['variety_id']) : null;
        $this->authority           = isset($data['authority']) ? $data['authority'] : null;
        $this->distribution        = isset($data['distribution']) ? $data['distribution'] : null;
        $this->habitat             = isset($data['habitat']) ? $data['habitat'] : null;
        $this->culture             = isset($data['culture']) ? $data['culture'] : null;
        $this->donars              = isset($data['donars']) ? $data['donars'] : null;
        $this->date_received       = isset($data['date_received']) ? $data['date_received'] : null;
        $this->received_from       = isset($data['received_from']) ? $data['variety_id'] : null;
        $this->description         = isset($data['description']) ? $data['description'] : null;
        $this->username            = isset($data['username']) ? $data['username'] : null;
        $this->new                 = isset($data['new']) ? $data['new'] : null;
        $this->inactive_code       = isset($data['inactive_code']) ? intval(data['inactive_code']) : null;
        $this->inactive_date       = isset($data['inactive_date']) ? (new \DateTime($data['inactive_date']))->format('Y-m-d H:i:s') : (new \DateTime('now'))->format('Y-m-d H:i:s');
        $this->inactive_comment    = isset($data['inactive_comment']) ? $data['inactive_comment'] : null;
        $this->size                = isset($data['size']) ? $data['size'] : null;
        $this->value               = isset($data['value']) ? $data['value'] : null;
        $this->parent_one          = isset($data['parent_one']) ? $data['parent_one'] : null;
        $this->parent_two          = isset($data['parent_two']) ? $data['parent_two'] : null;
        $this->grex_status         = isset($data['grex_status']) ? $data['grex_status'] : null;
        $this->hybrid_status       = isset($data['hybrid_status']) ? $data['hybrid_status'] : null;
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
