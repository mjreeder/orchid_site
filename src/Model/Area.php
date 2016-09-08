<?php
namespace orchid_site\src\Model;
error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Area implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $continent;
    public $area;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->continent = $data['continent'];
            $this->area = $data['area'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'continent' => $this->continent,
            'area' => $this->area
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll()
    {

        global $database;
        $statement = $database->prepare("SELECT * FROM area");
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return null;
        };

        $areas = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $areas[] = new Area($row);
        }
        return $areas;
    }

    static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM area WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return null;
        }
        return new Area($statement->fetch());
    }

    static function getByContinent($continent)
    {
        global $database;
        $sql = ("SELECT * FROM area WHERE continent = '$continent'");
        $statement = $database->prepare("SELECT * FROM area WHERE continent = '$continent'");
        $statement->execute(array($continent));
        $areas = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $areas[] = new Area($row);
        }
        return $areas;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createArea($body){
        global $database;
        $statement = $database->prepare("INSERT INTO area (plant_id, continent, area) VALUES (?,?,?)");
        $statement->execute(array($body['plant_id'], $body['continent'], $body['area']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        return $id;

    }


    /* ========================================================== *
     * PUT
     * ========================================================== */

    /* ========================================================== *
     * DELETE
     * ========================================================== */


}
?>