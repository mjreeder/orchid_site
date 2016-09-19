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
 *      "start_date",
 *      "end_date"
 *   }
 *  )
 */
class Blooming implements \JsonSerializable
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
    public $start_date;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $end_date;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->start_date = $data['start_date'];
            $this->end_date = $data['end_date'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming WHERE plant_id = ?');
        $statement->execute(array($plant_id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming WHERE id = ?');
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createBlooming($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO blooming (plant_id, start_date) VALUES (?,?) ');
        $statement->execute(array($body['plant_id'], $body['start_date']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updatID = self::getByID($id);

        return $updatID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateBlooming($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE blooming SET start_date = ?, end_date = ? WHERE id = ?');
        $statement->execute(array($body['start_date'], $body['end_date'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
