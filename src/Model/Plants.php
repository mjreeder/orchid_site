<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/database.php';
use PDO;
use Exception;

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "name"
 *   }
 *  )
 */
class Plants implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $name;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $accession_number;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $authority;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $distribution;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $habitat;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $culture;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $donation_comment;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $date_received;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $received_from;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $description;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $username;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $inactive_date;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $inactive_comment;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $size;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $scientific_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $value;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $parent_one;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $parent_two;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $grex_status;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $hybrid_status;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $hybrid_comment;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $origin_comment;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $location_id;
    /**
     * @SWG\Property()
     *
     * @var bool
     */
    public $dead;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $is_donation;

    public $special_collections_id;


    public $class_name;

    public $tribe_name;

    public $subtribe_name;

    public $genus_name;

    public $species_name;

    public $variety_name;

    public $dead_date;


    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->accession_number = intval($data['accession_number']);
            $this->authority = $data['authority'];
            $this->distribution = $data['distribution'];
            $this->habitat = $data['habitat'];
            $this->culture = $data['culture'];
            $this->donation_comment = $data['donation_comment'];
            $this->date_received = $data['date_received'];
            $this->received_from = $data['received_from'];
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
            $this->hybrid_comment = $data['hybrid_comment'];
            $this->hybrid_status = $data['hybrid_status'];
            $this->origin_comment = $data['origin_comment'];
            $this->location_id = intval($data['location_id']);
            $this->dead = $data['dead'];
            $this->special_collections_id = intval($data['special_collections_id']);
            $this->is_donation = $data['is_donation'];
            $this->class_name = $data['class_name'];
            $this->tribe_name = $data['tribe_name'];
            $this->subtribe_name = $data['subtribe_name'];
            $this->genus_name = $data['genus_name'];
            $this->species_name = $data['species_name'];
            $this->variety_name = $data['variety_name'];
            $this->dead_date = $data['dead_date'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'accession_number' => $this->accession_number,
            'authority' => $this->authority,
            'distribution' => $this->distribution,
            'habitat' => $this->habitat,
            'scientific_name' => $this->scientific_name,
            'culture' => $this->culture,
            'donation_comment' => $this->donation_comment,
            'date_received' => $this->date_received,
            'received_from' => $this->received_from,
            'description' => $this->description,
            'username' => $this->username,
            'inactive_date' => $this->inactive_date,
            'inactive_comment' => $this->inactive_comment,
            'size' => $this->size,
            'value' => $this->value,
            'parent_one' => $this->parent_one,
            'parent_two' => $this->parent_two,
            'grex_status' => $this->grex_status,
            'hybrid_comment' => $this->hybrid_comment,
            'hybrid_status' => $this->hybrid_status,
            'origin_comment' => $this->origin_comment,
            'location_id' => $this->location_id,
            'dead' => $this->dead,
            'special_collections_id' => $this->special_collections_id,
            'is_donation' => $this->is_donation,
            'class_name' => $this->class_name,
            'tribe_name' => $this->tribe_name,
            'subtribe_name' => $this->subtribe_name,
            'genus_name' => $this->genus_name,
            'species_name' => $this->species_name,
            'variety_name' => $this->variety_name,
            'dead_date' => $this->dead_date,

        ];
    }

    public static function createPlant($body)
    {
        global $database;
        if (!$body['accession_number'] || !$body['authority'] || !$body['distribution'] ||
       !$body['habitat'] || !$body['culture'] || !$body['donation_comment'] || !$body['date_received'] ||
       !$body['received_from'] || !$body['description'] || !$body['username'] || !$body['inactive_date'] ||
       !$body['inactive_comment'] || !$body['size'] || !$body['value'] || !$body['parent_one'] ||
       !$body['parent_two'] || !$body['grex_status'] || !$body['hybrid_comment'] ||
       !$body['hybrid_status'] || !$body['scientific_name'] || !$body['location_id'] || !$body['origin_comment'] || !$body['name'] || !$body['is_donation']) {
            throw new Exception('Missing required information', 400);
        }

        if (!in_array('special_collections_id', $body)) {
            $body['special_collections_id'] = null;
        }

        $statement = $database->prepare('INSERT INTO plants (accession_number, name, authority, distribution, habitat, culture,
      donation_comment, date_received, received_from, description, username, inactive_date, inactive_comment, size,
      scientific_name, hybrid_status, hybrid_comment, value, parent_one, parent_two, grex_status, origin_comment,
      location_id, dead, special_collections_id, is_donation) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $statement->execute(array($body['accession_number'], $body['name'], $body['authority'], $body['distribution'],
    $body['habitat'], $body['culture'], $body['donation_comment'], $body['date_received'], $body['received_from'],
    $body['description'], $body['username'], $body['inactive_date'], $body['inactive_comment'], $body['size'], $body['scientific_name'],
    $body['hybrid_status'], $body['hybrid_comment'], $body['value'], $body['parent_one'], $body['parent_two'], $body['grex_status'],
    $body['origin_comment'], $body['location_id'], $body['dead'], $body['special_collections_id'], $body['is_donation'], ));

        $id = $database->lastInsertId();
        $statement->closeCursor();

        return $id;
    }

    //GET ALL
    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants');
        $statement->execute();
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getBlooming(){
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id IN (SELECT plant_id FROM blooming WHERE end_date != '0000-00-00')");
        $statement->execute();
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getCountries($country){
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id IN (SELECT plant_id FROM plant_country_link WHERE country_id IN (SELECT id FROM country WHERE name = ?))");
        $statement->execute(array($country));
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function findCommonName($commonName){
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE name = ? LIMIT 1");
        $statement->execute(array($commonName));
        if ($statement->rowCount() <= 0) {
            return false;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }


    public static function getCommonNameFromAlphabet($collectionName){
        global $database;
        $collectionName = 'a';

        $statement = $database->prepare("SELECT * FROM plants WHERE name LIKE 'a%'");
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getSubtribeNames($speciesName){
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE subtribe_name = ?");
        $statement->execute(array($speciesName));

        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getSpecialCollection($collectionName){
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE special_collections_id IN (SELECT id FROM special_collections WHERE name = ?)");
        $statement->execute(array($collectionName));
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    // GET BY ID
    public static function getById($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    public static function getSimilarPlant($species_name)
    {
        global $database;
        $statement = $database->prepare("SELECT id FROM plants WHERE species_name = ?");
        $statement->execute(array($species_name));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $plant_ids = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plant_ids[] = $row;
        }




        return $plant_ids;


    }

    public static function getById2($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $plant_array = array();
        $plant_info = array();

        $plant_array[] = new self($statement->fetch());


        $plant_info[] = Health::getByID($id);
        array_push($plant_array, $plant_info);
        var_dump($plant_array);
        die();
        return $plant_array;
    }

    public static function wildcardSearch($searchItem, $index)
    {
        global $database;
        $limitIndex = ($index - 1) * 30;
        $statement = $database->prepare('DESCRIBE plants');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plantAttributes = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plantAttributes[] = $row;
        }

        $plants = [];
        $whereString = "";
        for ($i = 0; $i < sizeof($plantAttributes); ++$i) {
            $attribute = $plantAttributes[$i]['Field'];
            if($i > 0){
              $whereString .= " OR ";
            }
            $whereString .=" $attribute LIKE '%$searchItem%' ";
        }

        $wildcardStatement = $database->prepare("SELECT * FROM Plants WHERE $whereString LIMIT $limitIndex, 30");
        $wildcardStatement->execute(array($whereString, $limitIndex));
        if (!$wildcardStatement->rowCount() <= 0) {
            while ($row = $wildcardStatement->fetch(PDO::FETCH_ASSOC)) {
                $plants[] = new self($row);
            }
        }

        $allPlants = [];
        $getTotalPlantsCount = $database->prepare("SELECT * FROM Plants WHERE $whereString");
        $getTotalPlantsCount->execute(array($whereString));
        if($getTotalPlantsCount->rowCount()<= 0){
          $numberOfPages = 0;
        }
        else{
          $numberOfPages = ceil(($getTotalPlantsCount->rowCount()) / 30);

        }

        $returnArray = array('pages' => $numberOfPages, 'total' => $getTotalPlantsCount->rowCount(), 'plants' => $plants);
        return $returnArray;
    }

    public static function getNumberOfPages(){
      global $database;
      $statement = $database->prepare('SELECT * FROM plants');
      $statement->execute();
      $allPlants = array();
      if ($statement->rowCount() <= 0) {
          return;
      }
      $plants = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $plants[] = new self($row);
      }

      return ceil(sizeOf($plants) / 30);


    }

    public static function getPaginatedPlants($alpha, $index)
    {
        global $database;
        $limitIndex = ($index - 1) * 30;
        $alpha = $alpha.'%';
        $statement = $database->prepare("SELECT * FROM plants WHERE name LIKE ? LIMIT $limitIndex, 30");
        $statement->execute(array($alpha));
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getAllPaginatedPlants($index){
      global $database;
      $limitIndex = ($index - 1) * 30;
      $statement = $database->prepare("SELECT * FROM plants LIMIT $limitIndex, 30");
      $statement->execute();
      if ($statement->rowCount() <= 0) {
          return;
      }
      $plants = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $plants[] = new self($row);
      }


      $returnArray = array('pages' => Plants::getNumberOfPages(), 'total' => sizeOf(Plants::getAll()), 'plants' => $plants);
      return $returnArray;
    }

    public static function getByAccessionNumber($accession_number)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE accession_number = ?");
        $statement->execute(array($accession_number));
        if ($statement->rowCount() <= 0) {
            header('Content-Type: application/javascript');
            http_response_code(400);

            $response = array(
                "status" => "fail",
                "message" => "There is no accession number for that."
            );
            die(json_encode( (object) $response ));
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function getPlantsByTable($table_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE ? = location_id');
        $statement->execute(array($table_id));

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

    public static function updateLocation($body){

        $location_id =  Location::getIDFromTableName($body['name']);

        $id = $body['id'];
        $newBody = [];
        $newBody['id'] = $id;
        $newBody['location_id'] = ((float)$location_id['id']);

        global $database;
        $statement = $database->prepare('UPDATE plants SET location_id = ? WHERE id = ?');
        $statement->execute(array($newBody['location_id'], $newBody['id']));
        $statement->closeCursor();
        return self::getById($body['id']);
    }

    //UPDATE
    public static function update($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE plants SET name=?, accession_number=?,
        authority=?, distribution=?, habitat=?, scientific_name=?, culture=?, donation_comment=?,
        date_received=?, received_from, description=?, username=?, inactive_comment=?, inactive_date=?,
        size=?, value=?, parent_one=?, parent_two=?, grex_status=?, hybrid_status=?, hybrid_comment=?,
        origin_comment=?, location_id,=? special_collections_id=?, dead=? WHERE id = ?');

        $statement->execute(array($body['name'], $body['accession_number'], $body['authority'], $body['distribution'],
        $body['habitat'], $body['scientific_name'], $body['culture'], $body['donation_comment'], $body['date_received'],
        $body['received_from'], $body['description'], $body['username'], $body['inactive_comment'], $body['inactive_date'],
        $body['size'], $body['value'], $body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_status'],
        $body['hybrid_comment'], $body['origin_comment'], $body['location_id'], $body['special_collections_id'], $body['dead'], ));

        $statement->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateCritical($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET accession_number = ?, name = ?, scientific_name = ?, location_id = ? WHERE id = ?');
        $statment->execute(array($body['accession_number'], $body['name'], $body['scientific_name'], $body['location_id'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function createNewPlant($plantData){
        global $database;

        $bo = $plantData['plant'];
        $body = $bo['data'];


        $statment = $database->prepare('INSERT INTO plants SET accession_number = ?, name = ?, scientific_name = ?, class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, variety_name = ?, authority = ?, species_name = ?, distribution = ?, habitat = ?, origin_comment = ?, received_from = ?, donation_comment = ?, description = ?, parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ?, `location_id` = ?, special_collections_id = ?, date_received = ?');
        $statment->execute(array($body['accession_number'], $body['name'], $body['scientific_name'], $body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['variety_name'], $body['authority'], $body['species_name'], $body['distribution'], $body['habitat'], $body['origin_comment'], $body['received_from'], $body['donation_comment'], $body['description'], $body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['location_id'], $body['special_collections_id'], $body['date_received']));

        $id = $database->lastInsertId();

        $statment->closeCursor();

        return self::getById($id);
    }

    public static function updateCulture($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET distribution = ?, habitat = ?, origin_comment = ? WHERE id = ?');
        $statment->execute(array($body['distribution'], $body['habitat'], $body['origin_comment'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateAccession($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET received_from = ?, donation_comment = ?, date_received = ? WHERE id = ?');
        $statment->execute(array($body['received_from'], $body['donation_comment'], $body['date_received'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateDescription($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET description = ? WHERE id = ?');
        $statment->execute(array($body['description'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateTaxonmic($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, species_name = ?, variety_name = ?, authority = ? WHERE id = ?');
        $statment->execute(array($body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['species_name'], $body['variety_name'], $body['authority'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateHybrid($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET parent_one = ?, parent_two = ?, grex_status = ?,  hybrid_comment = ? WHERE id = ?');
        $statment->execute(array($body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateInactive($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET inactive_date = ?, dead_date = ?, inactive_comment = ? WHERE id = ?');
        $statment->execute(array($body['inactive_date'], $body['dead_date'], $body['inactive_comment'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateSpecialCollection($body){
        global $database;
        $statment = $database->prepare('UPDATE plants SET special_collections_id = (SELECT id FROM special_collections WHERE name = ?) WHERE id = ?');
        $statment->execute(array($body['name'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }



    public static function updateCriticalTable($body){

        $location =  Location::getIDFromTableName($body['name']);
        global $database;
        $statement = $database->prepare('UPDATE plants SET location_id = ? WHERE id = ?');


        $statement->execute(array($location['id'], $body['plant_id']));

        $statement->closeCursor();

        return self::getById($body['plant_id']);
    }

    public static function checkAccessionNumber($accession_number){
        global $database;
        $statement = $database->prepare('SELECT accession_number FROM plants WHERE accession_number = ?');
        $statement->execute(array($accession_number));
        $statement->closeCursor();

        if ($statement->rowCount() <= 0) {
            return false;
        } else {
            return true;
        }

    }





//    public static function updateHyrbid($body){
//        global $database;
//        $statment = $database->prepare('UPDATE plants SET parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ? WHERE id = ?');
//        $statment->execute(array($body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['id']));
//        $statment->closeCursor();
//
//        return self::getById($body['id']);
//    }

//    public static function updateVarifiedDate($body){
//        global $database;
//        $statement  = $database->prepare('UPDATE plants SET last_varified = CURDATE() WHERE id = ?');
//        $statement->execute(array($body['id']));
//        $statement->closeCursor();
//        return self::getById($body['id']);
//    }





    //DELETE
    public static function delete($id)
    {
        global $database;
        $statement = $database->prepare("DELETE FROM plants WHERE id = $id");
        $statement->execute();
        $statement->closeCursor();
        if ($statement->rowCount() > 0) {
            return array('success' => true);
        } else {
            return array('success' => false);
        }
    }
}
