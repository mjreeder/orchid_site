<?php
namespace orchid_site\src\Model;


error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/database.php";
use PDO;
use Exception;
class Plants implements \JsonSerializable
{
    public $id;
    public $name;
    public $accession_number;
    public $variety_id;
    public $authority;
    public $distribution;
    public $habitat;
    public $culture;
    public $donation_comment;
    public $date_received;
    public $received_from;
    public $description;
    public $username;
    public $inactive_date;
    public $inactive_comment;
    public $size;
    public $scientific_name;
    public $value;
    public $parent_one;
    public $parent_two;
    public $grex_status;
    public $hybrid_status;
    public $hybrid_notes;
    public $origin_id;
    public $location_id;
    public $dead;
    public $special_collections_id;


    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->accession_number = intval($data['accession_number']);
            $this->variety_id = intval($data['variety_id']);
            $this->authority = $data['authority'];
            $this->distribution = $data['distribution'];
            $this->habitat = $data['habitat'];
            $this->culture = $data['culture'];
            $this->donation_comment = $data['donation_comment'];
            $this->date_received = $data['date_received'];
            $this->received_from = $data['variety_id'];
            $this->description = $data['description'];
            $this->username = $data['username'];
            $this->inactive_date = $data['inactive_date'];
            $this->inactive_comment = $data['inactive_comment'];
            $this->size = $data['size'];
            $this->scientific_name = $data['scientific_name'];
            $this->value = $data['value'];
            $this->parent_one = $data['parent_one'];
            $this->parent_two = $data['parent_two'];
            $this->grex_status = $data['grex_status'];
            $this->hybrid_notes = $data['hybrid_notes'];
            $this->hybrid_status = $data['hybrid_status'];
            $this->origin_id = intval($data['origin_id']);
            $this->location_id = intval($data['location_id']);
            $this->dead = $data['dead'];
            $this->special_collecions_id =$data["special_collections_id"];
        }

    }

    function jsonSerialize()
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'accession_number'       => $this->accession_number,
            'variety_id'             => Variety::getById($this->variety_id),
            'authority'              => $this->authority,
            'distribution'           => $this->distribution,
            'habitat'                => $this->habitat,
            'scientific_name'        => $this->scientific_name,
            'culture'                => $this->culture,
            'donation_comment'       => $this->donation_comment,
            'date_received'          => $this->date_received,
            'received_from'          => $this->received_from,
            'description'            => $this->description,
            'username'               => $this->username,
            'inactive_date'          => $this->inactive_date,
            'inactive_comment'       => $this->inactive_comment,
            'size'                   => $this->size,
            'value'                  => $this->value,
            'parent_one'             => $this->parent_one,
            'parent_two'             => $this->parent_two,
            'grex_status'            => $this->grex_status,
            'hybrid_notes'           => $this->hybrid_notes,
            'hybrid_status'          => $this->hybrid_status,
            'origin_id'               => $this->origin_id,
            'location_id'                => $this->location_id,
            'dead'                   => $this->dead,
            'special_collections_id' => $this->special_collections_id
        ];
    }

    static function createPlant($body){
    global $database;
    var_dump(count(["accession_number", "variety_id", "name", "authority", "distribution","habitat", "culture", "donation_comment", "date_received", "received_from", "description", "username" , "new", "inactive_date", "inactive_comment", "size", "scientific_name", "hybrid_status", "hybrid_notes", "value", "parent_one", "parent_two", "grex_status" ,"origin_id", "location_id", "dead", "special_collections_id"]));
     if (!$body['accession_number'] || !$body['variety_id'] || !$body['authority'] || !$body['distribution'] ||
       !$body['habitat'] || !$body['culture'] || !$body['donation_comment'] || !$body['date_received'] ||  !$body['received_from'] || !$body['description']
       || !$body['username'] || !$body['inactive_date'] || !$body['inactive_comment'] || !$body['size'] || !$body['value']
       || !$body['parent_one'] || !$body['parent_two'] || !$body['grex_status'] || !$body['hybrid_notes'] || !$body['hybrid_status'] || !$body["scientific_name"] || !$body["location_id"] || !$body["origin_id"] || !$body['name']){
      throw new Exception('Missing required information', 400);
    }

    if(!in_array("special_collections_id", $body)){
      $body['special_collections_id'] = null;
    }
    $statement = $database->prepare("INSERT INTO plants (accession_number, variety_id, name, authority, distribution, habitat, culture, donation_comment, date_received, received_from, description, username, inactive_date, inactive_comment, size, scientific_name, hybrid_status, hybrid_notes, value, parent_one, parent_two, grex_status, origin_id, location_id, dead, special_collections_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $statement->execute(array($body["accession_number"], $body["variety_id"], $body["name"], $body["authority"], $body["distribution"], $body["habitat"], $body["culture"], $body["donation_comment"], $body["date_received"], $body["received_from"], $body["description"], $body["username"], $body["inactive_date"], $body["inactive_comment"], $body["size"], $body["scientific_name"], $body["hybrid_status"], $body["hybrid_notes"], $body["value"], $body["parent_one"], $body["parent_two"], $body["grex_status"], $body["origin_id"], $body["location_id"], $body["dead"], $body["special_collections_id"]));
    $id = $database->lastInsertId();
    $statement->closeCursor();

    return $id;

    }

    //GET ALL
    static function getAll()
    {
      global $database;
      $statement = $database->prepare("SELECT * FROM plants");
      $statement->execute();
      $allPlants = array();
      if($statement->rowCount()<=0){
          return null;
      }
      $plants = [];
      while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $plants[] = new Plants($row);
      }
      return $plants;
    }

    // GET BY ID
    static function getById($id)
    {
      global $database;
      $statement = $database->prepare("SELECT * FROM plants WHERE id = $id");
      $statement->execute(array($id));
      if($statement->rowCount()<=0){
          return null;
      }
      return new Plants($statement->fetch());
    }

    static function getPaginatedPlants($alpha, $index){
      global $database;
      $limitIndex = ($index - 1) * 20;
      $statement = $database->prepare("SELECT * FROM plants WHERE name LIKE '$alpha%' LIMIT $limitIndex, 20");
      $statement->execute();
      $allPlants = array();
      if($statement->rowCount()<=0){
          return null;
      }
      $plants = [];
      while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $plants[] = new Plants($row);
      }

      return $plants;
    }

    static function getByAccessionNumber($accession_number)
    {
      global $database;
      $statement = $database->prepare("SELECT * FROM plants WHERE accession_number = $accession_number");
      $statement->execute();
      if($statement->rowCount()<=0){
          return null;
      }
      $plants = [];
      while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $plants[] = new Plants($row);
      }

      return $plants;
    }

    // GET BY VARIETY_ID
    static function getByVarietyId($variety_id)
    {
      global $database;
      $statement = $database->prepare("SELECT * FROM plants WHERE variety_id = $variety_id");
      $statement->execute();
      if($statement->rowCount()<=0){
          return null;
      }
      $plants = [];
      while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $plants[] = new Plants($row);
      }

      return $plants;
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
                                    'hybrid_notes'=>$body['hybrid_notes']], ['id' => $body['id']]);
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
