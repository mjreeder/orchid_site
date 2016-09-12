<?php

namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;



class Special_Collection implements \JsonSerializable
{
    public $id;
    public $name;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data){
        if(is_array($data)){
            $this->id = intval($data['id']);
            $this->name = intval($data['name']);
        }
    }

    function jsonSerialize(){
        return [
          'id'  => $this->id,
            'name' => $this->name
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM special_collections");
        $statement->execute();

        if($statement->rowCount() <= 0){
            return null;
        }

        $special_collections = [];

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $special_collections[] = new Special_Collection($row);
        }

        return $special_collections;
    }

    static function getByID($id){
        global $database;
        $statement = $database->prepare("SELECT * FROM special_collections WHERE id = ?");
        $statement->execute(array($id));

        if($statement->rowCount() <= 0){
            return null;
        }

        $special_collection = new Special_Collection($statement->fetch(PDO::FETCH_ASSOC));

        return $special_collection;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createSpecialCollection($body){
        global $database;
        $statement = $database->prepare("INSERT INTO special_collections (name) VALUES (?)");
        $statement->execute(array($body['name']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        return $id;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    static function updateSpecialCollection($body){
        global $database;
        $statement = $database->prepare("UPDATE special_collections SET name = ? WHERE id = ?");
        $statement->execute(array($body['name'], $body['id']));
        $id = Special_Collection::getByID($body['id']);
        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */

}