<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/database.php';
use PDO;

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
    public $location;
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
    public $special_collection;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $class_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $tribe_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $subtribe_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $genus_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $species_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $phylum_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $variety_name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $dead_date;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $countries_note;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $general_note;
    /**
     * @SWG\Property()
     *
     * @var string
     */

    public $inactive;

    public $family_name;


    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->accession_number = $data['accession_number'];
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
            $this->scientific_name = $data['scientific_name'];
            $this->value = $data['value'];
            $this->parent_one = $data['parent_one'];
            $this->parent_two = $data['parent_two'];
            $this->grex_status = $data['grex_status'];
            $this->hybrid_comment = $data['hybrid_comment'];
            $this->hybrid_status = $data['hybrid_status'];
            $this->origin_comment = $data['origin_comment'];
            $this->location = Location::getTableNameFromId(intval($data['location_id']))['name'];
            $this->dead = $data['dead'];
            $this->special_collection = isset($data['special_collections_id']) ? Special_Collection::getByID(intval($data['special_collections_id']))->{'name'} : null;
            $this->class_name = $data['class_name'];
            $this->tribe_name = $data['tribe_name'];
            $this->subtribe_name = $data['subtribe_name'];
            $this->genus_name = $data['genus_name'];
            $this->species_name = $data['species_name'];
            $this->phylum_name = $data['phylum_name'];
            $this->variety_name = $data['variety_name'];
            $this->dead_date = $data['dead_date'];
            $this->countries_note = $data['countries_note'];
            $this->general_note = $data['general_note'];
            $this->inactive = $data['inactive'];
            $this->family_name = $data['family_name'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'genus' => $this->genus_name,
            'species' => $this->species_name,
            'accession_number' => $this->accession_number,
            'variety' => $this->variety_name,
            'authority' => $this->authority,
            'location' => $this->location,
            'distribution' => $this->distribution,
            'habitat' => $this->habitat,
            'culture' => $this->culture,
            'general_note' => $this->general_note,
            'special_collection' => $this->special_collection,
            'parent_one' => $this->parent_one,
            'parent_two' => $this->parent_two,
            'id' => $this->id,
            'name' => $this->name,
            'scientific_name' => $this->scientific_name,
            'donation_comment' => $this->donation_comment,
            'date_received' => $this->date_received,
            'received_from' => $this->received_from,
            'description' => $this->description,
            'username' => $this->username,
            'inactive_date' => $this->inactive_date,
            'inactive_comment' => $this->inactive_comment,
            'value' => $this->value,
            'grex_status' => $this->grex_status,
            'hybrid_comment' => $this->hybrid_comment,
            'hybrid_status' => $this->hybrid_status,
            'origin_comment' => $this->origin_comment,
            'dead' => $this->dead,
            'class' => $this->class_name,
            'tribe' => $this->tribe_name,
            'subtribe' => $this->subtribe_name,
            'phylum' => $this->phylum_name,
            'dead_date' => $this->dead_date,
            'countries_note' => $this->countries_note,
            'inactive' => $this->inactive,
            'family' => $this->family_name

        ];
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

    public static function getAccessionAndID(){
        global $database;
        $statement = $database->prepare("SELECT accession_number, id FROM plants");
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        $photo = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            array_push($plants, $row);
        }
        return $plants;
    }

    public static function getBlooming()
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id IN (SELECT plant_id FROM blooming WHERE end_date = '0000-00-00')");
        $statement->execute();
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        $photo = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        for($i = 0; $i < count($plants); $i++){
            $statement = $database->prepare("SELECT * FROM photos WHERE plant_id = ?");
            $statement->execute(array($plants[$i]->id));
            array_push($photo, $statement->fetch(PDO::FETCH_ASSOC));
        }

        $returnObject = (object) ['plants' => $plants, 'photo' => $photo];

        return $returnObject;
    }

    public static function getCountries($country)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE id IN (SELECT plant_id FROM plant_country_link WHERE country_id IN (SELECT id FROM country WHERE name = ?))');
        $statement->execute(array($country));
        $allPlants = array();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        $photo = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }

//

    public static function getCount()
    {
        global $database;
        $statement = $database->prepare('SELECT COUNT(*) FROM plants where dead_date IS NULL AND inactive_date IS NULL');
        $statement->execute(array());
        if ($statement->rowCount() <= 0) {
            return;
        }

        $count = $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $count;
    }

    public static function dead_Date() {
//        SELECT dead_date FROM plants where dead_date IS NOT NULL
        global $database;
        $statement = $database->prepare('SELECT DISTINCT(Year(dead_date)) AS dead_date FROM plants WHERE dead_date IS NOT NULL');
        $statement->execute(array());

        $dates = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dates[] = $row;
        }

        $years = [];
        for($i = 0; $i < count($dates); $i++){
            $date_1 = $dates[$i]['dead_date'];
            $year_1 = substr($date_1, 0 , 4);
            $start_date = $year_1 . "-01-01";
            $end_date = $year_1 . "-12-31";
            $years[] = $start_date;
            $years[] = $end_date;
        }

        $return_years = [];

        for($j = 0; $j < count($years); $j = $j + 2){
            $start_date1 = $years[$j];
            $end_date1 = $years[$j+1];

            $statement2 = $database->prepare("SELECT COUNT(*) FROM `plants` WHERE (dead_date BETWEEN ? AND ?)");
            $statement2->execute(array($start_date1, $end_date1));

            $row = $statement2->fetch(PDO::FETCH_ASSOC);

            $message = $start_date1 . " - " . $end_date1 ." => " .  $row['COUNT(*)']. " deaths.";

            $return_years[] = $message;

        }

        return $return_years;
    }


    public static function getDistinctCount()
    {
        global $database;
        $statement = $database->prepare('SELECT COUNT(DISTINCT genus_name) AS genus_number FROM plants;');
        $statement->execute(array());


        $statement2 = $database->prepare('SELECT COUNT(DISTINCT species_name) AS species_number FROM plants;');
        $statement2->execute(array());

        $genus= $statement->fetch(PDO::FETCH_ASSOC);
        $species= $statement2->fetch(PDO::FETCH_ASSOC);

        $object = (object) ["genus" => $genus, 'species' => $species];


        return $object;
    }

    public static function findCommonName($commonName)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE name = ? LIMIT 1');
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

    public static function getCommonNameFromAlphabet($collectionName)
    {
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

    public static function getSubtribeNames($speciesName)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE subtribe_name = ?');
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

    public static function getSpecialCollection($collectionName)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE special_collections_id IN (SELECT id FROM special_collections WHERE name = ?)');
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
        $statement = $database->prepare("SELECT * FROM plants WHERE id = ?");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        return new Plants($statement->fetch(PDO::FETCH_ASSOC));
    }

    public static function getSimilarPlant($species_name)
    {
        global $database;
        $statement = $database->prepare('SELECT id FROM plants WHERE species_name = ?');
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

    public static function collectionTop()
    {
        global $database;

        $statement = $database->prepare('SELECT COUNT(*) as num, P.`special_collections_id`, SP.name   FROM plants P, special_collections SP WHERE P.`special_collections_id` IS NOT NULL AND P.special_collections_id = SP.id GROUP BY P.`special_collections_id` ORDER BY num DESC LIMIT 5');
        $statement->execute();
        $plant_ids = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plant_ids[] = $row;
        }

        return $plant_ids;
    }

    public static function collectionSpecies()
    {
        global $database;

        $statement = $database->prepare('SELECT COUNT(*) as num, `subtribe_name` , `accession_number` FROM plants GROUP BY `subtribe_name` ORDER BY num DESC');
        $statement->execute();
        $plant_ids = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plant_ids[] = $row;
        }

        return $plant_ids;
    }

    public static function getById2($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id = ?");
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
        $whereString = '';
        for ($i = 0; $i < sizeof($plantAttributes); ++$i) {
            $attribute = $plantAttributes[$i]['Field'];
            if ($i > 0) {
                $whereString .= ' OR ';
            }
            $whereString .= " $attribute LIKE '%$searchItem%' ";
        }

        $wildcardStatement = $database->prepare("SELECT * FROM plants WHERE $whereString ORDER BY genus_name, species_name  LIMIT $limitIndex, 30");
        $wildcardStatement->execute(array($whereString, $limitIndex));

        if (!$wildcardStatement->rowCount() <= 0) {
            while ($row = $wildcardStatement->fetch(PDO::FETCH_ASSOC)) {
                $plants[] = new self($row);
            }
        }

        $allPlants = [];
        $getTotalPlantsCount = $database->prepare("SELECT * FROM plants WHERE $whereString");
        $getTotalPlantsCount->execute(array($whereString));
        if ($getTotalPlantsCount->rowCount() <= 0) {
            $numberOfPages = 0;
        } else {
            $numberOfPages = ceil(($getTotalPlantsCount->rowCount()) / 30);
        }

        $returnArray = array('pages' => $numberOfPages, 'total' => $getTotalPlantsCount->rowCount(), 'plants' => $plants);

        return $returnArray;
    }

    public static function getNumberOfPages()
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

        return ceil(sizeOf($plants) / 30);
    }

    public static function getPaginatedPlants($alpha, $index, $itemsPerPage)
    {
        global $database;
        $itemsPerPage = intval($itemsPerPage);
        $limitIndex = ($index - 1) * $itemsPerPage;
        $alpha = $alpha.'%';
        $statement = $database->prepare("SELECT * FROM plants WHERE name LIKE ? LIMIT $limitIndex, $itemsPerPage");
        $statement->execute(array($alpha));
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        $allPlants = [];
        $getTotalPlantsCount = $database->prepare('SELECT * FROM plants WHERE name LIKE ?');
        $getTotalPlantsCount->execute(array($alpha));
        if ($getTotalPlantsCount->rowCount() <= 0) {
            $numberOfPages = 0;
        } else {
            $numberOfPages = ceil(($getTotalPlantsCount->rowCount()) / 30);
        }

        $returnArray = array('pages' => $numberOfPages, 'plants' => $plants);

        return $returnArray;
    }

    public static function getAllPaginatedPlants($index)
    {
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

        $returnArray = array('pages' => self::getNumberOfPages(), 'total' => sizeOf(self::getAll()), 'plants' => $plants);

        return $returnArray;
    }

    public static function getByAccessionNumber($accession_number)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE accession_number = ?');
        $statement->execute(array($accession_number));
        if ($statement->rowCount() <= 0) {
            header('Content-Type: application/javascript');
            http_response_code(400);

            $response = array(
                'status' => 'fail',
                'message' => 'There is no accession number for that.',
            );
            die(json_encode((object) $response));
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
        $statement = $database->prepare('SELECT * FROM plants WHERE location_id = ? AND dead_date IS NULL AND inactive_date IS NULL');
        $statement->execute(array($table_id));

        if ($statement->rowCount() <= 0) {
            return "Table Empty";;
        }

        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        $totalPlantObject = [];

        for ($i = 0; $i < count($plants); $i++){
            $tagged = "";
            $plantID = $plants[$i]->id;
            $tagged = Tag::getByPlantID($plantID);
            if($tagged == NULL){
                $tagged = null;
            }

            $verified = Verified::getByPlantID($plantID);
            if($verified == NULL){
                $verified = null;
            }

            $blooming = Blooming::isBloomingRightNow($plantID);
            if($blooming == NULL){
                $blooming = null;
            }

            $string = $plants[$i]->accession_number;
            $plant = $plants[$i];
            $plantObject = (object) ["info" => $plant, 'tagged' => $tagged, "verified" => $verified, "blooming" =>$blooming];
           array_push($totalPlantObject, $plantObject);
        }

        if(count($plants) == 0){
            return "Table Empty";
        }




        return $totalPlantObject;
    }
    public static function getPlantsFromSubTribe($tribe)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE subtribe_name = ? AND (dead_date IS NULL AND inactive_date IS NULL)');
        $statement->execute(array($tribe));

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $plants = [];
        $photos = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        for($i = 0; $i < count($plants); $i++){
            $statement2 = $database->prepare('SELECT * FROM photos WHERE plant_id = ?');
            $statement2->execute(array($plants[$i]->id));
            $photosRow = $statement2->fetch(PDO::FETCH_ASSOC);
            if($photosRow != false){
                array_push($photos, new Photos($photosRow));
            }

        }

        $returnObject = (object) ['plants' => $plants, 'photos' => $photos];


        return $returnObject;


    }

    public static function updateLocation($body)
    {
        $location_id = Location::getIDFromTableName($body['name']);

        $id = $body['id'];
        $newBody = [];
        $newBody['id'] = $id;
        $newBody['location_id'] = ((float) $location_id['id']);

        global $database;
        $statement = $database->prepare('UPDATE plants SET location_id = ? WHERE id = ?');
        $statement->execute(array($newBody['location_id'], $newBody['id']));
        $statement->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateCritical($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET accession_number = ?, name = ?, scientific_name = ?, location_id = ? WHERE id = ?');
        $statment->execute(array($body['accession_number'], $body['name'], $body['scientific_name'], $body['location_id'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function createNewPlant($plantData)
    {
        global $database;
        $bo = $plantData['plant'];
        $body = $bo['data'];

        $statment = $database->prepare('INSERT INTO plants SET accession_number = ?, name = ?, scientific_name = ?, class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, variety_name = ?, authority = ?, species_name = ?, phylum_name = ?, distribution = ?, habitat = ?, origin_comment = ?, received_from = ?, donation_comment = ?, description = ?, parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ?, `location_id` = ?, special_collections_id = ?, date_received = ?, countries_note = ? ,general_note = ?, username = ?, family_name = ?');

        $statment->execute(array($body['accession_number'], $body['name'], $body['scientific_name'], $body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['variety_name'], $body['authority'], $body['species_name'], $body['phylum_name'], $body['distribution'], $body['habitat'], $body['origin_comment'], $body['received_from'], $body['donation_comment'], $body['description'], $body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['location_id'], $body['special_collections_id'], $body['date_received'], $body['countries_note'], $body['general_note'], $body['username'], $body['family_name']));

        $id = $database->lastInsertId();

        $statment->closeCursor();

        return self::getById($id);
    }

    public static function createPlantWithNewAccessionNumber($plantData)
    {
        global $database;
        $bo = $plantData['plant'];
        $body = $bo['data'];

        //$body['id] -> this is the old id for tha plant
        $statment = $database->prepare('INSERT INTO plants SET accession_number = ?, name = ?, scientific_name = ?, class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, variety_name = ?, authority = ?, species_name = ?, phylum_name = ?, distribution = ?, habitat = ?, origin_comment = ?, received_from = ?, donation_comment = ?, description = ?, parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ?, `location_id` = ?, special_collections_id = ?, date_received = ?, countries_note = ? ,general_note = ?, username = ?, family_name = ?');

        $statment->execute(array($body['new_plant_accession_number'], $body['name'], $body['scientific_name'], $body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['variety_name'], $body['authority'], $body['species_name'], $body['phylum_name'], $body['distribution'], $body['habitat'], $body['origin_comment'], $body['received_from'], $body['donation_comment'], $body['description'], $body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], 4, $body['special_collections_id'], $body['date_received'], $body['countries_note'], $body['general_note'], $body['username'], "HELLO"));

        $id = $database->lastInsertId();

        $statmentPhoto = $database->prepare('SELECT Ph.id, Ph.plant_id, Ph.url, Ph.fileName, Ph.type, Ph.active, Ph.thumb_url FROM photos Ph, Plants P WHERE Ph.active = 1 AND Ph.plant_id = P.id AND P.id = ?;');
        $statmentPhoto->execute(array(8));


        $photos = [];
        while ($row = $statmentPhoto->fetch(PDO::FETCH_ASSOC)) {
            $photos[] = new Photos($row);
        }

        for($i = 0; $i < count($photos); $i++){
            $addPhotos = $database->prepare("INSERT INTO photos SET plant_id = ?, url = ?, fileName = ?, type = ?, active = 1, thumb_url = ? ");
            $addPhotos->execute(array($id, $photos[$i]->url, $photos[$i]->fileName, $photos[$i]->type, $photos[$i]->thumb_url));
        }

        $statment->closeCursor();

        return self::getById($id);
    }

    public static function updateCulture($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET distribution = ?, habitat = ?, origin_comment = ?, countries_note = ? WHERE id = ?');
        $statment->execute(array($body['distribution'], $body['habitat'], $body['origin_comment'], $body['countries_note'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateAccession($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET received_from = ?, donation_comment = ?, date_received = ? WHERE id = ?');
        $statment->execute(array($body['received_from'], $body['donation_comment'], $body['date_received'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateDescription($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET description = ? WHERE id = ?');
        $statment->execute(array($body['description'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }
    //TODO
    public static function updateTaxonmic($data)
    {
        // 1) Phylum -> phylum_name
        // 2) Class -> class_name
        // 3) Family -> family_name
        // 4) Tribe -> tribe_name
        // 5) Sub tribe -> subtribe_name
        // 6)genus -> genus_name
        // 7)species -> species_name
        // 8)variety -> variety_name
        // 9) authority -> authority

        $body = $data['plant'];
        global $database;


        if($body['autofill'] == "true"){

            if($body['authority'] != ""){
                $updateRankings = Plants::getTaxForAuthority($body);
                return Plants::updateAutoFillRankings($updateRankings, "Authority", $body['id']);
            } else if($body['variety_name'] != ""){
                $updateRankings = Plants::getTaxForVariety($body);
                return Plants::updateAutoFillRankings($updateRankings,"Variety", $body['id']);
            } else if($body['species_name'] != ""){
                $updateRankings = Plants::getTaxForSpecies($body);
                return Plants::updateAutoFillRankings($updateRankings, "Species", $body['id']);
            } else if($body['genus_name'] != ""){
                $updateRankings = Plants::getTaxForGenus($body);
                return Plants::updateAutoFillRankings($updateRankings,"Genus", $body['id']);
            } else if($body['subtribe_name'] != ""){
                $updateRankings = Plants::getTaxForSubtribe($body);
                return Plants::updateAutoFillRankings($updateRankings,"Subtribe", $body['id']);
            } else if($body['tribe_name'] != ""){
                $updateRankings = Plants::getTaxForTribe($body);
                return Plants::updateAutoFillRankings($updateRankings,"Tribe", $body['id']);
            } else if($body['family_name'] != ""){
                $updateRankings = Plants::getTaxForFamily($body);
                return Plants::updateAutoFillRankings($updateRankings,"Family", $body['id']);
            } else if($body['class_name'] != ""){
                $updateRankings = Plants::getTaxForClass($body);
                return Plants::updateAutoFillRankings($updateRankings, "Class", $body['id']);
            }
        } else {
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, species_name = ?, variety_name = ?, authority = ?, phylum_name = ?, family_name = ? WHERE id = ?');
            $statment->execute(array($body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], strtolower($body['species_name']), $body['variety_name'], $body['authority'], $body['phylum_name'], $body['family_name'], $body['id']));
            $statment->closeCursor();

            return self::getById($body['id']);
        }

    }
    public static function updateAutoFillRankings ($body, $tax, $id){

        global $database;
        if($tax == "Class"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ?  WHERE id = ?');
            $statment->execute(array($body[0]['class_name'],"","","", $body[0]['phylum_name'], "","","","", $id));
            $statment->closeCursor();
            return self::getById($id);
        }else if($tax == "Family"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], "","","", $body[0]['phylum_name'], $body[0]['family_name'],"","","", $id));
            $statment->closeCursor();
            return self::getById($id);
        }else if($tax == "Genus"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], "", $body[0]['genus_name'],"", $body[0]['phylum_name'], $body[0]['family_name'],"","","", $id));
            $statment->closeCursor();
            return self::getById($id);
        }
        else if($tax == "Tribe"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], $body[0]['tribe_name'], "", "", $body[0]['phylum_name'], $body[0]['family_name'], "","","", $id));
            $statment->closeCursor();
            return self::getById($id);
        }
        else if($tax == "Species"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ?WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], $body[0]['tribe_name'], $body[0]['genus_name'], strtolower($body[0]['species_name']), $body[0]['phylum_name'], $body[0]['family_name'],  $body[0]['subtribe_name'], "", "", $id));
            $statment->closeCursor();
            return self::getById($id);
        } else if($tax == "Subtribe"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], $body[0]['tribe_name'], "", "", $body[0]['phylum_name'], $body[0]['family_name'], $body[0]['subtribe_name'],  "", "", $id));
            $statment->closeCursor();
            return self::getById($id);
        } else if($tax == "Variety"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], $body[0]['tribe_name'], $body[0]['genus_name'], strtolower($body[0]['species_name']), $body[0]['phylum_name'], $body[0]['family_name'], $body[0]['subtribe_name'], $body[0]['variety_name'],  "", $id));
            $statment->closeCursor();
            return self::getById($id);
        } else if($tax == "Authority"){
            $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, genus_name = ?, species_name = ?, phylum_name = ?, family_name = ?, subtribe_name = ?, variety_name = ?, authority = ? WHERE id = ?');
            $statment->execute(array($body[0]['class_name'], $body[0]['tribe_name'], $body[0]['genus_name'], strtolower($body[0]['species_name']), $body[0]['phylum_name'], $body[0]['family_name'], $body[0]['subtribe_name'], $body[0]['variety_name'], $body[0]['authority'], $id));
            $statment->closeCursor();
            return self::getById($id);
        }

    }



    public static function updateHybrid($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET parent_one = ?, parent_two = ?, grex_status = ?,  hybrid_comment = ? WHERE id = ?');
        $statment->execute(array($body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateInactive($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET inactive_date = ?, dead_date = ?, inactive_comment = ? WHERE id = ?');
        $statment->execute(array($body['inactive_date'], $body['dead_date'], $body['inactive_comment'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateSpecialCollection($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET special_collections_id = (SELECT id FROM special_collections WHERE name = ?) WHERE id = ?');
        $statment->execute(array($body['name'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
    }

    public static function updateCriticalTable($body)
    {
        $location = Location::getIDFromTableName($body['name']);
        global $database;
        $statement = $database->prepare('UPDATE plants SET location_id = ? WHERE id = ?');

        $statement->execute(array($location['id'], $body['plant_id']));

        $statement->closeCursor();

        return self::getById($body['plant_id']);
    }

    public static function updateGeneralNotes($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE plants SET general_note = ? WHERE id = ?');

        $statement->execute(array($body['general_note'], $body['plant_id']));

        $statement->closeCursor();

        return self::getById($body['plant_id']);
    }

    public static function checkAccessionNumber($accession_number)
    {
        global $database;
        $statement = $database->prepare('SELECT accession_number FROM plants WHERE accession_number = ?');
        $statement->execute(array($accession_number));
        $statement->closeCursor();

        if ($statement->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getPlantTaxonomyNames($taxonomyName, $tableName)
    {
        global $database;

        $statement = $database->prepare("SELECT DISTINCT $tableName FROM plants WHERE $tableName LIKE ?");
        $statement->execute(array("%$taxonomyName%"));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $taxonomyNames = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $taxonomyNames[] = $row;
        }

        $statement->closeCursor();
        return $taxonomyNames;
    }


    public static function copy($id)
    {
        global $database;
        $plant = self::getById($id);
        $statement = $database->prepare('INSERT INTO plants SET accession_number = ?, name = ?, scientific_name = ?, class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, variety_name = ?, authority = ?, species_name = ?, phylum_name = ?, distribution = ?, habitat = ?, origin_comment = ?, received_from = ?, donation_comment = ?, description = ?, parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ?, `location_id` = ?, special_collections_id = ?, date_received = ?, countries_note = ? ,general_note = ?');
        if(!isset($plant->location_id)){
            $plant->location_id = null;
        }
        if(!isset($plant->special_collections_id)){
            $plant->special_collections_id = null;
        }
        $statement->execute(array($plant->accession_number, $plant->name, $plant->scientific_name, $plant->class_name, $plant->tribe_name, $plant->subtribe_name, $plant->genus_name, $plant->variety_name, $plant->authority, $plant->species_name, $plant->phylum_name, $plant->distribution, $plant->habitat, $plant->origin_comment, $plant->received_from, $plant->donation_comment, $plant->description, $plant->parent_one, $plant->parent_two, $plant->grex_status, $plant->hybrid_comment, $plant->location_id, $plant->special_collections_id, $plant->date_received, $plant->countries_note, $plant->general_note));
        $statement->closeCursor();
        $newId = $database->lastInsertId();
        self::photoCopy($id, $newId);
        self::linkCountriesCopy($id, $newId);
        return self::getById($newId);
    }

    private static function photoCopy($ori_id, $last_id){
        $photos = Photos::getByPlantID($ori_id);
        foreach ($photos as $photo){
            $photo->plant_id = $last_id;
            //To reuse the old model we will create an associative array
            $bodyFake = array();
            $bodyFake["plant_id"] = $photo->plant_id;
            $bodyFake["url"] = $photo->url;
            $bodyFake["type"] = $photo->type;
            $bodyFake["fileName"] = $photo->fileName;
            $bodyFake["thumb_url"] = $photo->thumb_url;
            Photos::createPhoto($bodyFake);
        }
    }

    public static function getTaxForAuthority($tax){

        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name, subtribe_name, genus_name, species_name, variety_name, authority  FROM plants WHERE authority = ? LIMIT 1");
        $statement->execute(array($tax['authority']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }

        return $rankings;
    }

    public static function getTaxForVariety($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name, subtribe_name, genus_name, species_name, variety_name  FROM plants WHERE variety_name = ?  LIMIT 1");
        $statement->execute(array($tax['variety_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] =($row);
        }
        return $rankings;
    }

    public static function getTaxForSpecies($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name, subtribe_name, genus_name, species_name  FROM plants WHERE species_name = ? LIMIT 1");
        $statement->execute(array($tax['species_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }

        return $rankings;
    }

    public static function getTaxForGenus($tax){

        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name, subtribe_name, genus_name  FROM plants WHERE genus_name = ?  LIMIT 1");
        $statement->execute(array($tax['genus_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }
        return $rankings;
    }

    public static function getTaxForSubtribe($tax){
        global $database;

        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name, subtribe_name FROM plants WHERE subtribe_name = ?  LIMIT 1");
        $statement->execute(array($tax['subtribe_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }
        return $rankings;
    }

    public static function getTaxForTribe($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name, tribe_name  FROM plants WHERE tribe_name = ?  LIMIT 1");
        $statement->execute(array($tax['tribe_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }
        return $rankings;
    }

    public static function getTaxForFamily($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name, family_name  FROM plants WHERE family_name = ? LIMIT 1");
        $statement->execute(array($tax['family_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }
        return $rankings;
    }

    public static function getTaxForClass($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name, class_name  FROM plants WHERE class_name = ?  LIMIT 1");
        $statement->execute(array($tax['class_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] = ($row);
        }
        return $rankings;
    }

    public static function getTaxForPhylum($tax){
        global $database;
        $statement = $database->prepare("SELECT phylum_name  FROM plants WHERE phylum_name = ?  LIMIT 1");
        $statement->execute(array($tax['phylum_name']));

        $rankings = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $rankings[] =($row);
        }
        return $rankings;

    }




    private static function linkCountriesCopy($ori_id, $last_id){
        $plantCountryLink = Plant_Country_Link::getByID($ori_id);
        if($plantCountryLink != false){
            $plantCountryLink->plant_id = $last_id;
            //To reuse the old model we will create an associative array
            $bodyFake = array();
            $bodyFake["plant_id"] = $plantCountryLink->plant_id;
            $bodyFake["country_id"] = $plantCountryLink->country_id;
            Plant_Country_Link::createLink($bodyFake);
        }
    }

    public static function deletePlant($body){
        $plant_id = $body['plant_id'];
        global $database;
        $delete1 = $database->prepare("DELETE FROM blooming WHERE plant_id = ?");
        $delete1->execute(array($plant_id));
        $delete2 = $database->prepare("DELETE FROM bloom_comment WHERE plant_id = ?");
        $delete2->execute(array($plant_id));
        $delete3 = $database->prepare("DELETE FROM health WHERE plant_id = ?");
        $delete3->execute(array($plant_id));
        $delete4 = $database->prepare("DELETE FROM pests WHERE plant_id = ?");
        $delete4->execute(array($plant_id));
        $delete5 = $database->prepare("DELETE FROM photos WHERE plant_id = ?");
        $delete5->execute(array($plant_id));
        $delete6 = $database->prepare("DELETE FROM plant_country_link WHERE plant_id = ?");
        $delete6->execute(array($plant_id));
        $delete7 = $database->prepare("DELETE FROM pests WHERE plant_id = ?");
        $delete7->execute(array($plant_id));
        $delete8 = $database->prepare("DELETE FROM potting WHERE plant_id = ?");
        $delete8->execute(array($plant_id));
        $delete9 = $database->prepare("DELETE FROM potting WHERE plant_id = ?");
        $delete9->execute(array($plant_id));
        $delete10 = $database->prepare("DELETE FROM split WHERE plant_id = ?");
        $delete10->execute(array($plant_id));
        $delete11 = $database->prepare("DELETE FROM sprayed WHERE plant_id = ?");
        $delete11->execute(array($plant_id));
        $delete12 = $database->prepare("DELETE FROM tag WHERE plant_id = ?");
        $delete12->execute(array($plant_id));
        $delete13 = $database->prepare("DELETE FROM verified WHERE plant_id = ?");
        $delete13->execute(array($plant_id));

        $statement = $database->prepare('DELETE FROM plants WHERE id = ?');
        $statement->execute(array($plant_id));
        return true;

    }


}
