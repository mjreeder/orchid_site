<?php
namespace orchid_site\src\Model;
error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Bloom implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $comment;
    public $timestamp;

    public function __construct($data)
    {
        if(is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->comment = $data['comment'];
            $this->timestamp = $data['timestamp'];
        }
    }

    function jsonSerialize(){
        return [
            'id'            => $this->id,
            'plant_id'      => $this->plant_id,
            'comment'       => $this->comment,
            'timestamp'     => $this->timestamp
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM bloom");
        $statement->execute();

        if ($statement->rowCount() <= 0){
            return null;
        };

        $areas = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $areas[] = new Bloom(($row));
        }
        return $areas;
    }

    static function getByPlantID($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM bloom WHERE plant_id = (?)");
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0){
            return null;
        };

        $areas = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $areas[] = new Bloom($row);
        }
        return $areas;
    }

    static function getByID($id){
        global $database;
        $statement = $database->prepare("SELECT * FROM bloom WHERE id = (?)");
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0){
            return null;
        }

        $blooms = new Bloom($statement->fetch(PDO::FETCH_ASSOC));

        return $blooms;
    }

    static function getMostRecentPlantId(){

    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createBloom($body){
        global $database;
        $statement = $database->prepare("INSERT INTO bloom (plant_id, comment) VALUES(?,?)");
        $statement->execute(array($body['plant_id'], $body['comment']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        return$id;
//
//        var_dump($id);
//        die();
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    static function updateBloom($body){
        global $database;
        $statement = $database->prepare("UPDATE bloom SET comment = (?) WHERE id = (?)");
        $statement->execute(array($body['comment'],$body['id']));
        $id = Bloom::getByID($body['id']);
        return $id;
    }
    /* ========================================================== *
     * DELETE
     * ========================================================== */

    //THERE IS NOT A DELETE. SINCE THE PLANT WILL BE STORED THE DATA ABOUT IT SELF WILL NOT BE DELETED.


}
