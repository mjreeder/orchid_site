<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;
/**
 * @SWG\Definition(
 *  required={
 *      "classification_id",
 *      "name"
 *   }
 *  )
 */
class ScientificClass implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $classification_id;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $scientifc_class_name;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->classification_id = intval($data['classification_id']);
            $this->scientifc_class_name = $data['scientifc_class_name'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'classification_id' => $this->classification_id,
            'scientifc_class_name' => $this->scientifc_class_name,
        ];
    }

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM scientific_class');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }

        $scientificClasses = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $scientificClasses[] = new Classification($row);
        }

        return $scientificClasses;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM scientific_class WHERE id = $id");
        $statement->execute(array($id));
        $scientificClasses = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $scientificClasses[] = new Bloom($row);
        }

        return $scientificClasses;
    }

    public static function createScientificClass($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO scientific_class (classification_id, scientifc_class_name) VALUES (?,?)');
        $statement->execute(array($body['classification_id'], $body['scientifc_class_name']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        return $id;
    }

    public static function editScientificClass($body, $id)
    {
        global $database;
        $statement = $database->prepare('UPDATE scientific_class SET classification_id = ?, scientifc_class_name = ? WHERE id = ?');
        $statement->execute(array($body['classification_id'], $body['scientifc_class_name'], $id));
        $statement->closeCursor();

        return self::getById($id);
    }
}
