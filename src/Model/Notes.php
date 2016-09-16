<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_erros', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;

class Notes implements \JsonSerializable
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
     * @var string
     */
    public $timestamp;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */
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
        return[
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
        $statement = $database->prepare('SELECT * FROM notes');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $notes = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new self($row);
        }

        return $notes;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM notes WHERE plant_id = ?');
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $notes = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new self($row);
        }

        return $notes;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM notes WHERE id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createNote($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO notes (plant_id, note, timestamp) VALUES (?,?,?)');
        $statement->execute(array($body['plant_id'], $body['note'], $body['timestamp']));
        $id = $database->lastInsertId();
        $updateID = self::getByID($id);
        $statement->closeCursor();

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateNotes($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE notes SET plant_id = ?, note = ?, timestamp = ? WHERE id = ?');
        $statement->execute(array($body['plant_id'], $body['note'], $body['timestamp'], $body['id']));
        $id = self::getByPlantID($body['plant_id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
