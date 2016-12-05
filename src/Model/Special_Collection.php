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
 *      "id",
 *      "name"
 *   }
 *  )
 */
class Special_Collection implements \JsonSerializable
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

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM special_collections');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $special_collections = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $special_collections[] = new self($row);
        }

        return $special_collections;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM special_collections WHERE id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $special_collection = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $special_collection;
    }

    public static function getIDFromName($name)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM special_collections WHERE name = ?');
        $statement->execute(array($name));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $special_collection = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $special_collection;
    }

    public static function getPlantsWithSpeicalCollections($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plants WHERE special_collections_id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $special_collections = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $special_collections[] = new Plants($row);
        }

        return $special_collections;
    }






    public static function isName($name){
        global $database;
//        var_dump($name);
        $statement = $database->prepare('SELECT * FROM special_collections WHERE name = ?');
        $statement->execute(array($name));

        if ($statement->rowCount() <= 0) {
            return false;
        }
        return true;

    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createSpecialCollection($body)
    {

            $variable = self::isName($body['name']);

        if($variable == false) {


            global $database;

            $statement = $database->prepare('INSERT INTO special_collections (name) VALUES (?)');
            $statement->execute(array($body['name']));
            $id = $database->lastInsertId();
            $statement->closeCursor();
            $updateID = self::getByID($id);

            return $updateID;

            return self::getIDFromName($body['name']);
        } else {
            return self::getIDFromName($body['name']);
        }


    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateSpecialCollection($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE special_collections SET name = ? WHERE id = ?');
        $statement->execute(array($body['name'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
