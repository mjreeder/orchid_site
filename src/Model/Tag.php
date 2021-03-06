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
 *      "note",
 *      "active"
 *   }
 *  )
 */
class Tag implements \JsonSerializable
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
     * @var int
     */
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
            return false;
        }

        $tags = [];
        while ($row = $statment->fetch(PDO::FETCH_ASSOC)) {
            $tags[] = new self($row);
        }

        return $tags;
    }

    public static function getAllActive()
    {
        global $database;
        $statment = $database->prepare('SELECT * FROM tag where active = 1');
        $statment->execute();

        if ($statment->rowCount() <= 0) {
            return false;
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
        $statement = $database->prepare('SELECT * FROM tag WHERE plant_id = (?) AND active = 1');
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $tags = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $tags;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM tag WHERE id = (?)');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return false;
        }

        $tags = new self($statement->fetch(PDO::FETCH_ASSOC));

        return $tags;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createTag($body)
    {
        if($body['active'] == 0){

        } else {
            global $database;
            $statement = $database->prepare('INSERT INTO tag (plant_id, note, active) VALUES (?,?,1)');
            $statement->execute(array($body['plant_id'], $body['note']));
            $id = $database->lastInsertId();
            $statement->closeCursor();

            $updateID = Tag::getByID($id);

            return $updateID;
        }

    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateTag($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE tag SET note = ?, active = ? WHERE plant_id = ?');
        $statement->execute(array($body['note'], $body['active'], $body['plant_id']));
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
