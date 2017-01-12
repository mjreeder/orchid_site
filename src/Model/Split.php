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
 *      "plant_id",
 *      "timestamp",
 *      "recipient",
 *      "note"
 *   }
 *  )
 */
class Split implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $plant_id;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $timestamp;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $recipient;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $note;

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->recipient = $data['recipient'];
            $this->note = $data['note'];
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
            'recipient' => $this->recipient,
            'note' => $this->note,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM split');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $splits = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $splits[] = new self($row);
        }

        return $splits;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM split WHERE plant_id = (?)');
        $statement->execute(array($plant_id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        $splits = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $splits[] = new self($row);
        }

        return $splits;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM split WHERE id = (?)');
        $statement->execute(array($id));

        if ($statement->rowCount() <= 0) {
            return;
        }

        return new self($statement->fetch(PDO::FETCH_ASSOC));
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createSplit($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO split (plant_id, timestamp, recipient, note) VALUES (?,?,?,?)');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['recipient'], $body['note']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        $updateID = self::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateSplit($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE split SET plant_id = ?, timestamp = ?, recipient = ?, note = ? WHERE id = ? ');
        $statement->execute(array($body['plant_id'], $body['timestamp'], $body['recipient'], $body['note'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    public static function addLetter($id, $firstLetter=false)
    {
        global $database;
        $plant = null;
        $statement = $database->prepare('SELECT * FROM `plants` WHERE `id` = ?');
        $statement->execute(array($id));

        //TODO Remove loop
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plant = new Plants($row);
        }

        $asciiCode = 64; //A code in ASCII -1

        //See if last character is a alphabetical character
        if(ctype_alpha($plant->accession_number[strlen($plant->accession_number) - 1])){
            $accession_number = $plant->accession_number;
            $plant->accession_number = substr($accession_number, 0, strlen($accession_number) - 1);
            $plant->accession_number .= "%";
        } else if($firstLetter == true) {
            $plant->accession_number .= "A";
            $statement = $database->prepare('UPDATE plants SET `accession_number` = ? WHERE id = ?');
            $statement->execute(array($plant->accession_number, $id));
            return Plants::getByID($id);
        }

        $statement = $database->prepare("SELECT * FROM `plants` WHERE `accession_number` LIKE ?");
        $statement->execute(array($plant->accession_number));
        $plants = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plants[] = new Plants($row);
        }

        //Increments letter by one for each occurrence of the letter
        foreach ($plants as $temp){
            $accession_number = $temp->accession_number;
            $endIndex = strlen($accession_number) - 1;
            if(ctype_alpha($accession_number[$endIndex])){
                $asciiCode++;
            }
        }

        $plant->accession_number = str_replace("%", "", $plant->accession_number);
        $newAccessionNumber = $plant->accession_number . chr($asciiCode);

        $statement = $database->prepare('UPDATE plants SET `accession_number` = ? WHERE id = ?');
        $statement->execute(array($newAccessionNumber, $plant->id));
        return Plants::getByID($plant->id);
    }
    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
