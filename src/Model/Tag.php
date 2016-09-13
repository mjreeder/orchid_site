<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;

class Tag implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $note;
    public $active;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->note = $data['note'];
            $this->active = intval($data['active']);
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'plant_id' => $this->plant_id,
            'note' => $this->note,
            'active' => $this->active,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statment = $database->prepare('SELECT * FROM tag');
        $statment->execute();

        if ($statment->rowCount() <= 0) {
            return;
        }

        $tags = [];
        while ($row = $statment->fetch(PDO::FETCH_ASSOC)) {
            $tags[] = new self($row);
        }

        return $tags;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM tag WHERE plant_id = (?)');
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $tags = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $tags;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createTag($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO tag (plant_id, note, active) VALUES (?,?,1)');
        $statement->execute(array($body['plant_id'], $body['note']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        return $id;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateTag($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE tag SET note = (?), active = (?) WHERE plant_id = (?)');
        $statement->execute(array($body['note']));
        $id = self::getByPlantID($body['plant_id']);

        return $id;
    }

    public static function deactiveTag($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE tag SET active = 0 WHERE plant_id = (?)');
        $statement->execute(array($body['plant_id']));
        $id = self::getByPlantID($body['plant_id']);

        return $id;
    }

    public static function activeTag($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE tag SET active = 1 WHERE plant_id = (?)');
        $statement->execute(array($body['plant_id']));
        $id = self::getByPlantID($body['plant_id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
