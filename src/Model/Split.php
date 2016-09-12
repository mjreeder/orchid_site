<?php

namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;


class Split implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $timestamp;
    public $recipient;
    public $note;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data){
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->recipient = $data['recipient'];
            $this->note = $data['note'];
        }
    }

    function jsonSerialize(){
        return [
          'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
            'recipient' => $this->recipient,
            'note' => $this->note
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM split");
        $statement->execute();

        if($statement->rowCount() <= 0){
            return null;
        }

        $splits = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $splits[] = new Split($row);
        }

        return $splits;
    }

    static function getByPlantID($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM split WHERE plant_id = (?)");
        $statement->execute(array($plant_id));

        if($statement->rowCount() <= 0){
            return null;
        }

        $splits = new Split($statement->fetch(PDO::FETCH_ASSOC));

        return $splits;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createSplit($body){
        global $database;
        $statement = $database->prepare("INSERT INTO split (plant_id, timestamp, recipient, note) VALUES (?,?,?,?)");
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['recipient'], $body['note']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        return $id;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    static function updateSplit($body){
        global $database;
        $statement = $database->prepare("UPDATE split SET plant_id = ?, timestamp = ?, recipient = ?, note = ? WHERE id = ? ");
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['recipient'], $body['note'], $body['id']));
        $id = Split::getByPlantID($body['plant_id']);
        return $id;
    }
    /* ========================================================== *
     * DELETE
     * ========================================================== */


}