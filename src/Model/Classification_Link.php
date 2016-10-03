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
    public $plant_id;
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $class_id;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->plant_id = intval($data['plant_id']);
            $this->class_id = intval($data['class_id']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'plant_id' => $this->plant_id,
            'class_id' => $this->class_id,
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
        $statement = $database->prepare('SELECT * FROM classification_link
        INNER JOIN scientific_class ON classification_link.class_id=scientific_class.id
        INNER JOIN classification ON classification.id=scientific_class.classification_id
        WHERE plant_id = ? ORDER BY rank');
        $statement->execute(array($id));
        $relations = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $relations[] = $row;
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
