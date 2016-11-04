<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;
use Exception;
/**
 * @SWG\Definition(
 *  required={
 *      "plant_id",
 *      "class_id"
 *   }
 *  )
 */
class Classification_Link implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    public $class;
    public $tribe;
    public $subtribe;
    public $genus;
    public $species;
    public $variety;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->class = $data['class'];
            $this->tribe = $data['tribe'];
            $this->subtribe = $data['subtribe'];
            $this->genus = $data['genus'];
            $this->species = $data['species'];
            $this->variety = $data['variety'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'plant_id' => $this->id,
            'class' => $this->class,
            'tribe' => $this->tribe,
            'subtribe' => $this->subtribe,
            'genus' => $this->genus,
            'species' => $this->species,
            'variety' => $this->variety
        ];
    }

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM classification_link');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }

        $classificationLinks = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $classificationLinks[] = new self($row);
        }

        return $classificationLinks;
    }

    public static function getPlantsByScientificClassId($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM classification_link
        RIGHT JOIN PLANTS ON classification_link.plant_id=plants.id
        WHERE class_id = ?');
        $statement->execute(array($id));
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new Plants($row);
        }
        $statement->closeCursor();

        return $plants;
    }

    public static function getPlantHierarchy($id)
    {
      //
        global $database;
        $statement = $database->prepare('SELECT `id`, `class_name` AS `class`, `tribe_name` AS `tribe`, `subtribe_name` AS `subtribe`, `genus_name` AS `genus`, `species_name` AS `species`, `variety_name` AS `variety` FROM plants WHERE id = 1');
        $statement->execute(array($id));
        $relations = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $item = new Classification_Link($row);
            $relations[] = $item;
        }
        $statement->closeCursor();

        return $relations;
    }

    public static function createClassificationLink($body)
    {
        global $database;
        if (!$body['class_id']) {
            throw new Exception('Missing required information', 404);
        }

        $statement = $database->prepare('INSERT INTO classification_link (plant_id, class_id) VALUES (?,?)');
        $statement->execute(array($body['plant_id'], $body['class_id']));
        $statement->closeCursor();
        if ($statement->rowCount() > 0) {
            return array('success' => true);
        } else {
            return array('success' => false);
        }
    }

    public static function editClassification($body, $id)
    {
        global $database;
        $statement = $database->prepare('UPDATE classification SET name = ?, rank = ? WHERE id = ?');
        $statement->execute(array($id, $body['name'], $body['rank'], $id));
        $statement->closeCursor();

        return self::getById($id);
    }
}
