<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;
class Verified implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $verified_date;
    public $active;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
//            $this->verified_date = $data['verified_date'];
            $this->verified_date = date("Y-m-d", strtotime($data['verified_date']));
            $this->active = intval($data['active']);

        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'verified_date' => $this->verified_date,
            'active' => $this->active
        ];
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM verified WHERE id = ?');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM verified WHERE plant_id = ? AND active = 1');
        $statement->execute(array($plant_id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $verificationDate = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $verificationDate[] = new self($row);
        }

        return $verificationDate;
    }

    public static function getLastestVerifiedForPlantID($plant_id){
        global $database;
        $statement = $database->prepare('SELECT * FROM verified WHERE plant_id = ? ORDER BY `verified_date` DESC LIMIT 1');
        $statement->execute(array($plant_id));

        $verificationDate = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $verificationDate[] = new self($row);
        }

        return $verificationDate;

    }

    public static function createVerification($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO verified (plant_id, verified_date, active) VALUES (?, NOW(), 1)');
        $statement->execute(array($body['plant_id']));
        $id = $database->lastInsertId();
        return self::getByID($id);
    }

    public static function createSpecificVerification($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO verified (plant_id, verified_date, active) VALUES (?, ?, 1)');
        $statement->execute(array($body['plant_id'], $body['verified_date']));
        $id = $database->lastInsertId();
        return self::getByID($id);
    }

    public static function updateVerification($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE verified SET plant_id = ?, verified_date = ?, active = ? WHERE id = ?');
        $statement->execute(array($body['plant_id'], $body['verified_date'], $body['active'], $body['id']));
        $wholeID = self::getByID($body['id']);
        return $wholeID;
    }



}