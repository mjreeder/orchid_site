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
 *      "plant_id",
 *      "timestamp"
 *   }
 *  )
 */
class Potting implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $plant_id;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $timestamp;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM potting');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $potting = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $potting[] = new self($row);
        }

        return $potting;
    }

    public static function getByPlantID($plant_id, $page)
    {
        global $database;
        $offset = intval(($page - 1) * 5);
        $statement = $database->prepare('SELECT * FROM potting WHERE plant_id = ? ORDER BY `potting`.`timestamp` DESC LIMIT 5 OFFSET ' . $offset);
        $statement->execute(array($plant_id));
        $potting = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $potting[] = new self($row);
        }

        return $potting;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM potting WHERE id = ?');
        $statement->execute(array($id));

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

     public static function createPotting($body)
     {
         global $database;
         $statement = $database->prepare('INSERT INTO potting (plant_id, timestamp) VALUE (?,?)');
         $statement->execute(array($body['plant_id'], $body['timestamp']));
         $id = $database->lastInsertId();
         $statement->closeCursor();
         $updateID = self::getByID($id);

         return $updateID;
     }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updatePotting($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE potting SET plant_id = ?, timestamp = ? WHERE id = ?');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETEs
     * ========================================================== */
}
