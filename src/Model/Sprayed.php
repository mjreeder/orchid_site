<?php

namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Sprayed implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $timestamp;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data){
        if(is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
        }
    }

    function jsonSerialize(){
        return[
          'id'  =>$this->id,
            'plant_id' =>$this->plant_id,
            'timestamp' => $this->timestamp
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM sprayed");
        $statement->execute();

        if($statement->rowCount() <= 0){
            return null;
        }

        $sprayed = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $sprayed[] = new Sprayed($row);
        }

        return $sprayed;
    }

    static function getByPlantID($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM sprayed WHERE plant_id = ?");
        $statement->execute(array($plant_id));

        if($statement->rowCount() <= 0){
            return null;
        }

        $sprayed = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $sprayed[] = new Sprayed($row);
        }

        return $sprayed;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createSprayed($body){
        global $database;
        $statement = $database->prepare("INSERT INTO sprayed (plant_id, timestamp) VALUES (?,?)");
        $statement->execute(array($body['plant_id'], $body['timestamp']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        return $id;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    static function updateSpray($body){
        global $database;
        $statement = $database->prepare("UPDATE sprayed SET plant_id = (?), timestamp = (?) WHERE id = (?)");
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['id']));
        $id = Sprayed::getByPlantID($body['plant_id']);
        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}