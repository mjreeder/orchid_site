<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;


class Blooming implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $start_date;
    public $end_date;

    public function __construct($data)
    {
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->start_date = $data['start_date'];
            $this->end_date = $data['end_date'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id'         =>$this->id,
            'plant_id' =>$this->plant_id,
            'start_date' => $this->start_date,
            'end_date'     => $this->end_date
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM blooming");
        $statement->execute();
        if ($statement->rowCount() <= 0){
            return null;
        }

        $blooming = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $blooming[] = new Blooming($row);
        }

        return $blooming;
    }

    static function getByPlantID($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM blooming WHERE plant_id = ?");
        $statement->execute(array($plant_id));
        if($statement->rowCount()<=0){
            return null;
        }

        $blooming = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $blooming[] = new Blooming($row);
        }

        return $blooming;
    }

    static function getByID($id){
        global $database;
        $statement = $database->prepare("SELECT * FROM blooming WHERE id = ?");
        $statement->execute(array($id));
        if($statement->rowCount()<=0){
            return null;
        }

        $blooming = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $blooming[] = new Blooming($row);
        }

        return $blooming;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createBlooming($body){
        global $database;
        $statement = $database->prepare("INSERT INTO blooming (plant_id, start_date) VALUES (?,?) ");
        $statement->execute(array($body['plant_id'], $body['start_date']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updatID = Blooming::getByID($id);
        return $updatID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    static function updateBlooming($body){
        global $database;
        $statement = $database->prepare("UPDATE blooming SET start_date = ?, end_date = ? WHERE id = ?");
        $statement->execute(array($body['start_date'], $body['end_date'], $body['id']));
        $id = Blooming::getByID($body['id']);
        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */



}