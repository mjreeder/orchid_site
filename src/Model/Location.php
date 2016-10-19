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
 *      "name",
 *      "room"
 *   }
 *  )
 */
class Location implements \JsonSerializable
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
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $room;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->room = $data['room'];
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'room' => $this->room,
            'name' => $this->name,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM location');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $locations = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $locations[] = new self($row);
        }

        return $locations;
    }

    public static function getTableNameFromID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT name FROM location where id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    public static function getIDFromTableName($tableName)
    {
        global $database;
        $statement = $database->prepare('SELECT id FROM location where name = ?');
        $statement->execute(array($tableName));

        if ($statement->rowCount() <= 0) {
            return;
        }


        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    public static function checkTable($name)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM location WHERE name = ?");
        $statement->execute(array($name));

        if($statement->rowCount() == 1){
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    /* ========================================================== *
     * PUT
     * ========================================================== */

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
