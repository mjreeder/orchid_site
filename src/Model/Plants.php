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
            $this->special_collecions_id = $data['special_collections_id'];
            $this->is_donation = $data['is_donation'];
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

    // GET BY ID
    public static function getById($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch());
    }

    public static function getPlantAttributes()
    {
        global $database;
        $statement = $database->prepare('DESCRIBE plants');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }
        $plantAttributes = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plantAttributes[] = $row;
        }

        $attributes = [];
        for ($i = 0; $i < sizeof($plantAttributes); ++$i) {
            $attribute = $plantAttributes[$i]['Field'];
            // var_dump($attribute);
            if (strpos($attribute, '_') == true) {
                $attribute = str_replace('_', ' ', $attribute);

            }
            array_push($attributes, $attribute);
        }

        return $attributes;
    }

    public static function wildcardSearch($searchItem)
    {
        global $database;
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
        for ($i = 0; $i < sizeof($plantAttributes); ++$i) {
            $attribute = $plantAttributes[$i]['Field'];
            $wildcardStatement = $database->prepare("SELECT * FROM Plants WHERE $attribute LIKE '%$searchItem%'");
            $wildcardStatement->execute();
            if (!$wildcardStatement->rowCount() <= 0) {
                while ($row = $wildcardStatement->fetch(PDO::FETCH_ASSOC)) {
                    $plants[] = new self($row);
                }
            }
        }

        return $plants;
    }

    public static function getPaginatedPlants($alpha, $index)
    {
        global $database;
        $limitIndex = ($index - 1) * 20;
        $statement = $database->prepare("SELECT * FROM plants WHERE name LIKE '$alpha%' LIMIT $limitIndex, 20");
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

    public static function getByAccessionNumber($accession_number)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plants WHERE accession_number = $accession_number");
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
