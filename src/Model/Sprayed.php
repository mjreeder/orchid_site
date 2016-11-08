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
class Sprayed implements \JsonSerializable
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
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $note;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->note = $data['note'];
        }
    }

    public function jsonSerialize()
    {
        return[
          'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
            'note' => $this->note
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM sprayed');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $sprayed = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sprayed[] = new self($row);
        }

        return $sprayed;
    }

    public static function getByPlantID($plant_id, $page)
    {
        global $database;
        $offset = intval(($page - 1) * 5);
        $statement = $database->prepare('SELECT * FROM sprayed WHERE plant_id = ? ORDER BY `sprayed`.`id` DESC LIMIT 5 OFFSET ' . $offset);
        $statement->execute(array($plant_id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $sprayed = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sprayed[] = new self($row);
        }

        return $sprayed;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM sprayed WHERE id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $sprayed = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sprayed[] = new self($row);
        }

        return $sprayed;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createSpray($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO sprayed (plant_id, timestamp, note) VALUES (?,?,?)');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['note']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        $updateID = Sprayed::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateSpray($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE sprayed SET plant_id = (?), timestamp = (?), note = ? WHERE id = (?)');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['note'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
