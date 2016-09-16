<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;

class Pests implements \JsonSerializable
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
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
            'note' => $this->note,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM pests');
        $statement->execute();
        $pestControl = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $pestControl[] = new self($row);
        }

        return $pestControl;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM pests WHERE plant_id = $plant_id");
        $statement->execute();
        $pestControl = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $pestControl[] = new self($row);
        }

        return $pestControl;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM pests WHERE id = $id");
        $statement->execute();
        $pestControl = [];

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createPestControl($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO pests (plant_id, note, timestamp) VALUES (?,?,?)');
        $statement->execute(array($body['plant_id'], $body['note'], $body['timestamp']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        $updateID = self::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updatePest($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE pests SET plant_id = ?, timestamp = ?, note = ? WHERE id =?');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['note'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
