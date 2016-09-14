<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;

class Origin implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $country;
    public $comment;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->country = $data['country'];
            $this->comment = $data['comment'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'country' => $this->country,
            'commment' => $this->comment,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM area');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        };

        $areas = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $areas[] = new Area($row);
        }

        return $areas;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM area WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch());
    }

    public static function getByCountry($country)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM area WHERE country = '$country'");
        $statement->execute(array($country));
        $areas = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $areas[] = new self($row);
        }

        return $areas;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createArea($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO area (plant_id, country) VALUES (?,?)');
        $statement->execute(array($body['plant_id'], $body['country']));
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
