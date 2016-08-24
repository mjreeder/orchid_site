<?php
namespace orchid_site\src\Model;

error_reporting( E_ALL);
ini_set("display_errors", true);
class Plants implements \JsonSerializable
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
            $this->inactive_code = intval($data['inactive_code']);
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
            'class_id'         => PlantClass::getById($this->class_id),
            'tribe_id'         => Tribe::getById($this->tribe_id),
            'subtribe_id'      => Subtribe::getById($this->subtribe_id),
            'genus_id'         => Genus::getById($this->genus_id),
            'species_id'       => Species::getById($this->species_id),
            'variety_id'       => Variety::getById($this->variety_id),
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
      if (!$body['accession_number'] || !$body['class_id'] || !$body['tribe_id'] || !$body['subtribe_id'] ||
          !$body['genus_id'] || !$body['variety_id'] || !$body['authority'] || !$body['distribution'] ||
          !$body['habitat'] || !$body['culture'] || !$body['donars'] || !$body['date_received'] ||
          !$body['received_from'] || !$body['description'] || !$body['username'] || !$body['new'] ||
          !$body['inactive_code'] || !$body['inactive_date'] || !$body['inactive_comment'] || !$body['size'] ||
          !$body['value'] || !$body['parent_one'] || !$body['parent_two'] || !$body['grex_status'] || !$body['hybrid_status']){
      throw new Exception('Missing required information', 400);
    }
    if (Plants::plantExistsForId($body['id'])){
      throw new Exception('Plant already exists', 400);
    }
    $db = DB::getInstance();
    $id = $db->insert('plants',['accession_number'=>$body['accession_number'],'class_id'=>$body['class_id'],'tribe_id'=>$body['tribe_id'],
                                'subtribe_id'=>$body['subtribe_id'], 'genus_id'=>$body['genus_id'],'variety_id'=>$body['variety_id'],
                                'authority'=>$body['authority'], 'distribution'=>$body['distribution'],'habitat'=>$body['habitat'],
                                'culture'=>$body['culture'], 'donars'=>$body['donars'],'date_received'=>$body['date_received'],
                                'received_from'=>$body['received_from'], 'description'=>$body['description'],'username'=>$body['username'],
                                'new'=>$body['new'], 'inactive_code'=>$body['inactive_code'],'inactive_date'=>$body['inactive_date'],
                                'inactive_comment'=>$body['inactive_comment'], 'size'=>$body['size'],'value'=>$body['value'],
                                'parent_one'=>$body['parent_one'], 'parent_two'=>$body['parent_two'],'grex_status'=>$body['grex_status'],
                                'hybrid_status'=>$body['hybrid_status']]);
    $plants = Plants::getById($id);
    return $plants;

    }
    //GET ALL
    static function getAll()
    {
      $statement = $database->prepare("SELECT * FROM plants");
      $statement->execute(array($id));
  		if (!$statement){
  			return array();
    }
  }
    // GET BY ID
    static function getById($id)
    {
      var_dump('here');
      $statement = $database->prepare("SELECT * FROM plants WHERE id = $id");
      $statement->execute(array($id));
      if (size($statment) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple plants with id '.$id.' found.', 400);
      }
    }

    // GET BY ACCESSION_NUMBER
    static function getByAccessionNumber($accession_number)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE accession_number = $accession_number");
      $statement->execute(array($accession_number));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with accession_number '. $accession_number .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with accession_number '. $accession_number .' found.', 400);
      }
    }

    // GET BY CLASS_ID
    static function getByClassId($class_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE class_id = $class_id");
      $statement->execute(array($class_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with class_id '. $class_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with class_id '. $class_id .' found.', 400);
      }
    }

    // GET BY TRIBE_ID
    static function getByTribeId($tribe_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE tribe_id = $tribe_id");
      $statement->execute(array($tribe_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with tribe_id '. $tribe_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with tribe_id '. $tribe_id .' found.', 400);
      }
    }

    // GET BY SUBTRIBE_ID
    static function getBySubTribeId($subtribe_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE subtribe_id = $subtribe_id");
      $statement->execute(array($subtribe_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with subtribe_id '. $subtribe_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with subtribe_id '. $subtribe_id .' found.', 400);
      }
    }

    // GET BY GENUS_ID
    static function getByGenusId($genus_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE genus_id = $genus_id");
      $statement->execute(array($genus_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with genus_id '. $genus_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with genus_id '. $genus_id .' found.', 400);
      }
    }

    // GET BY SPECIES_ID
    static function getBySpeciesId($species_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE species_id = $species_id");
      $statement->execute(array($species_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with species_id '. $species_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with species_id '. $species_id .' found.', 400);
      }
    }

    // GET BY VARIETY_ID
    static function getByVarietyId($variety_id)
    {
      $statement = $database->prepare("SELECT * FROM plants WHERE variety_id = $variety_id");
      $statement->execute(array($variety_id));
      if (size($statement) == 1) {
        return new Plants($statement[0]);
      } else if (!$statement) {
           throw new Exception('Plant with variety_id '. $variety_id .' not found.', 404);
      } else {
           throw new Exception('Multiple plants with variety_id '. $variety_id .' found.', 400);
      }
    }

    //UPDATE
    static function update($body){
      $db = DB::getInstance();
      $plants = $db->select('plants', '*', ['id' => $body['id']]);
      if (size($plants) == 1) {
        $db->update('plants', ['accession_number'=>$body['accession_number'],'class_id'=>$body['class_id'],'tribe_id'=>$body['tribe_id'],
                                    'subtribe_id'=>$body['subtribe_id'], 'genus_id'=>$body['genus_id'],'variety_id'=>$body['variety_id'],
                                    'authority'=>$body['authority'], 'distribution'=>$body['distribution'],'habitat'=>$body['habitat'],
                                    'culture'=>$body['culture'], 'donars'=>$body['donars'],'date_received'=>$body['date_received'],
                                    'received_from'=>$body['received_from'], 'description'=>$body['description'],'username'=>$body['username'],
                                    'new'=>$body['new'], 'inactive_code'=>$body['inactive_code'],'inactive_date'=>$body['inactive_date'],
                                    'inactive_comment'=>$body['inactive_comment'], 'size'=>$body['size'],'value'=>$body['value'],
                                    'parent_one'=>$body['parent_one'], 'parent_two'=>$body['parent_two'],'grex_status'=>$body['grex_status'],
                                    'hybrid_status'=>$body['hybrid_status']], ['id' => $body['id']]);
      } else if (!$plants) {
           throw new Exception('Plant with id '.$id.' not found.', 404);
      } else {
           throw new Exception('Multiple plants with id '.$id.' found.', 400);
      }
    }

    //DELETE
    static function delete($id){
      $statement = $database->prepare("DELETE * FROM plants WHERE id = $id");
      if(!$id){
        throw new Exception('Missing required information', 400);
      }
      if(!PlantClass::classExistsForId($id)){
        throw new Exception('Class with id '.$id.' not found', 404);
      }
      $statement->execute(array($id));
    }

    static function plantExistsForId($id){
        $statement = $database->prepare("DELETE * FROM plants WHERE id = $id");
        $statement->execute(array($id));
        if (sizeof($class) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
