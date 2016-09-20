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
 *      "plant_id"
 *      "note",
 *      "timestamp"
 *   }
 *  )
 */
class Bloom_Comment implements \JsonSerializable
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
    public $note;
    /**
     * @SWG\Property()
     *
     * @var date
     */
    public $timestamp;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->note = $data['note'];
            $this->timestamp = $data['timestamp'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'note' => $this->note,
            'timestamp' => $this->timestamp,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM bloom_comment');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        };

        $areas = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $areas[] = new self(($row));
        }

        return $areas;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM bloom_comment WHERE plant_id = (?) ORDER BY TIMESTAMP DESC');
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0) {
            return;
        };

        $areas = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $areas[] = new self($row);
        }

        return $areas;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM bloom_comment WHERE id = (?)');

        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooms = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $blooms;
    }

    public static function getMostRecentPlantId()
    {
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createBloom($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO bloom_comment (plant_id, note, timestamp) VALUES(?,?,?)');
        $statement->execute(array($body['plant_id'], $body['note'], $body['timestamp']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updateID = self::getByID($id);

        return $updateID;
//
//        var_dump($id);
//        die();
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateBloom($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE bloom_comment SET note = (?), timestamp = (?), plant_id = (?) WHERE id = (?)');
        $statement->execute(array($body['note'], $body['timestamp'], $body['plant_id'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }
    /* ========================================================== *
     * DELETE
     * ========================================================== */

    //THERE IS NOT A DELETE. SINCE THE PLANT WILL BE STORED THE DATA ABOUT IT SELF WILL NOT BE DELETED.
}
