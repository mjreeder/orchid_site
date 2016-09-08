<?php

namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";

use PDO;

class Potting implements \JsonSerializable
{
    public $plant_id;
    public $timestamp;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['plant_id']);
            $this->timestamp  = $data['timestamp'];
        }
    }

    function jsonSerialize()
    {
        return [
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp
        ];
    }


    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll()
    {
      global $database;
        $statement = $database->prepare("SELECT * FROM potting");
        $statement->execute();

        if ($statement->rowCount() <= 0){
            return null;
        }

        $potting = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $potting[] = new Potting($row);
        }

        return $potting;
    }

    static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM potting WHERE plant_id = $plant_id");
        $statement->execute(array($plant_id));
        $potting = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $potting[] = new Potting($row);
        }

        return $potting;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

     static function createPotting($body)
     {
         global $database;
         $statement = $database->prepare("INSERT INTO potting (plant_id) VALUE (?)");
         $statement->execute(array($body['plant_id']));
         $id = $database->lastInsertId();
         $statement->closeCursor();
         return $id;
     }


    /* ========================================================== *
     * PUT
     * ========================================================== */


    /* ========================================================== *
     * DELETEs
     * ========================================================== */

}
