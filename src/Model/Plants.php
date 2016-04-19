<?php

namespace orchid_site\src\Model;

class Plants implements JsonSerializable
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

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->accession_number = intval($data['accession_number']);
            $this->class_id = intval($data['class_id']);
            $this->tribe_id = intval($data['tribe_id']);
            $this->subtribe_id = intval($data['subtribe_id ']);
            $this->genus_id = intval($data['genus_id']);
            $this->species_id = intval($data['species_id']);
            $this->variety_id = intval($data['variety_id']);
            $this->authority = $data['authority'];
            $this->distribution = $data['distribution'];
            $this->habitat = $data['habitat'];
            $this->culture = $data['culture'];
            $this->donars = $data['donars'];
            $this->date_received = $data['date_received'];
            $this->received_from = $data['variety_id'];
            $this->description = $data['description'];
            $this->username = $data['username'];
            $this->new = $data['new'];
            $this->inactive_code = intval(data['inactive_code']);
            $this->inactive_date = $data['inactive_date'];
            $this->inactive_comment = $data['inactive_comment'];
            $this->size = $data['size'];
            $this->value = $data['value'];
            $this->parent_one = $data['parent_one'];
            $this->parent_two = $data['parent_two'];
            $this->grex_status = $data['grex_status'];
            $this->hybrid_status = $data['hybrid_status'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id'               => $this->id,
            'accession_number' => $this->accession_number,
            'class_id'         => Class::findById($this->class_id),
            'tribe_id'         => Tribe::findById($this->tribe_id),
            'subtribe_id'      => Subtribe::findById($this->subtribe_id),
            'genus_id'         => Genus::findById($this->genus_id),
            'species_id'       => Species::findById($this->species_id),
            'variety_id'       => Variety::findById($this->variety_id),
            'authority'        => $this->authority,
            'distribution'     => $this->distribution,
            'habitat'          => $this->habitat,
            'culture'          => $this->culture,
            'donars'           => $this->donars,
            'date_received'    => $this->date_received,
            'received_from'    => $this->received_from,
            'description'      => $this->description,
            'username'         => $this->username,
            'new'              => $this->new,
            'inactive_code'    => $this->inactive_code,
            'inactive_date'    => $this->inactive_date,
            'inactive_comment' => $this->inactive_comment,
            'size'             => $this->size,
            'value'            => $this->value,
            'parent_one'       => $this->parent_one,
            'parent_two'       => $this->parent_two,
            'grex_status'      => $this->grex_status,
            'hybrid_status'    => $this->hybrid_status
        ];
    }
    static function create($body){

    }
    //GET ALL
    static function getAll()
    {
    }
    // GET BY ID
    static function getById($id)
    {
      $db = DB::getInstance();
      plants = $db->select('plants','*',['id' => $id]);
      if (size($plants) == 1) {
        return new Plants($plants[0]);
      } else if (!$plants) {
           throw new Exception('Plant with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple plants with id '.$id.' found.', 400);
      }
    }
    }

    // UPDATE
    static function update($id)
    {
    }
    //DELETE
    static function delete($id)
   {
   }
}
