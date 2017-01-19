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

    public $special_collection;

    public $class_name;

    public $tribe_name;

    public $subtribe_name;

    public $genus_name;

    public $species_name;

    public $phylum_name;

    public $variety_name;

    public $dead_date;

    public $countries_note;

    public $general_note;

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
        }
    }

    public function jsonSerialize()
    {
        return [
            'accession_number' => $this->accession_number,
            'genus' => $this->genus_name,
            'variety_name' => $this->variety_name,
            'authority' => $this->authority,
            'location' => $this->location,
            'distribution' => $this->distribution,
            'habitat' => $this->habitat,
            'culture' => $this->culture,
            'general note' => $this->general_note,
            'special collection' => $this->special_collection,
            'parent one' => $this->parent_one,
            'parent two' => $this->parent_two,
            'id' => $this->id,
            'name' => $this->name,
            'scientific name' => $this->scientific_name,
            'donation comment' => $this->donation_comment,
            'date received' => $this->date_received,
            'received from' => $this->received_from,
            'description' => $this->description,
            'username' => $this->username,
            'inactive date' => $this->inactive_date,
            'inactive comment' => $this->inactive_comment,
            'value' => $this->value,
            'grex hybrid' => $this->grex_status,
            'hybrid comment' => $this->hybrid_comment,
            'hybrid status' => $this->hybrid_status,
            'origin comment' => $this->origin_comment,
            'dead' => $this->dead,
            'class' => $this->class_name,
            'tribe' => $this->tribe_name,
            'subtribe' => $this->subtribe_name,
            'species' => $this->species_name,
            'phylum' => $this->phylum_name,
            'dead date' => $this->dead_date,
            'countries note' => $this->countries_note,
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
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
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

        return new self($statement->fetch(PDO::FETCH_ASSOC));
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

        $statement = $database->prepare('SELECT COUNT(*) as num, `tribe_name`, `accession_number` FROM plants GROUP BY `tribe_name` ORDER BY num DESC');
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

        $wildcardStatement = $database->prepare("SELECT * FROM plants WHERE $whereString LIMIT $limitIndex, 30");
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
    public static function getPlantsFromSubTribe($tribe)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE tribe_name = ?');
        $statement->execute(array($tribe));

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new self($row);
        }

        return $plants;
    }
//

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

        $statment = $database->prepare('INSERT INTO plants SET accession_number = ?, name = ?, scientific_name = ?, class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, variety_name = ?, authority = ?, species_name = ?, phylum_name = ?, distribution = ?, habitat = ?, origin_comment = ?, received_from = ?, donation_comment = ?, description = ?, parent_one = ?, parent_two = ?, grex_status = ?, hybrid_comment = ?, `location_id` = ?, special_collections_id = ?, date_received = ?, countries_note = ? ,general_note = ?');

        $statment->execute(array($body['accession_number'], $body['name'], $body['scientific_name'], $body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['variety_name'], $body['authority'], $body['species_name'], $body['phylum_name'], $body['distribution'], $body['habitat'], $body['origin_comment'], $body['received_from'], $body['donation_comment'], $body['description'], $body['parent_one'], $body['parent_two'], $body['grex_status'], $body['hybrid_comment'], $body['location_id'], $body['special_collections_id'], $body['date_received'], $body['countries_note'], $body['general_note']));

        $id = $database->lastInsertId();

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
    public static function updateTaxonmic($body)
    {
        global $database;
        $statment = $database->prepare('UPDATE plants SET class_name = ?, tribe_name = ?, subtribe_name = ?, genus_name = ?, species_name = ?, variety_name = ?, authority = ?, phylum_name = ? WHERE id = ?');
        $statment->execute(array($body['class_name'], $body['tribe_name'], $body['subtribe_name'], $body['genus_name'], $body['species_name'], $body['variety_name'], $body['authority'], $body['phylum_name'], $body['id']));
        $statment->closeCursor();

        return self::getById($body['id']);
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

        if ($statement->rowCount() <= 0) {
            return false;
        } else {
            return true;
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

    //DELETE
    public static function delete($id)
    {
        global $database;
        $statement = $database->prepare("DELETE FROM plants WHERE id = ?");
        $statement->execute(array($id));
        $statement->closeCursor();
        if ($statement->rowCount() > 0) {
            return array('success' => true);
        } else {
            return array('success' => false);
        }
    }
}
