<?php

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;
use \DateTime;
/**
 * @SWG\Definition(
 *  required={
 *      "plant_id",
 *      "start_date",
 *      "end_date"
 *   }
 *  )
 */
class Blooming implements \JsonSerializable
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
    public $start_date;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $end_date;

    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $note;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->start_date = $data['start_date'];
            $this->end_date = $data['end_date'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'note' => $this->note,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }


    public static function getByPlantID($plant_id, $page)
    {
        global $database;
        $start = intval(($page - 1) * 5);
        $end = intval($page * 5);
        $statement = $database->prepare('SELECT blooming.*, bloom_comment.note, bloom_comment.timestamp as note_time FROM blooming LEFT JOIN bloom_comment ON blooming.plant_id = bloom_comment.plant_id WHERE blooming.plant_id = ? ORDER BY `blooming`.`id` DESC');
        $statement->execute(array($plant_id));

        $blooming_entries = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if(!self::dateRangeCheck($row['start_date'], $row['end_date'], $row['note_time'])){
                continue;
            }
            $item = new self($row);
            $item->note = $row['note'];
            $blooming_entries[] = $item;
        }
        $statement->closeCursor();

        $statement = $database->prepare('SELECT * FROM blooming WHERE plant_id = ?');
        $statement->execute(array($plant_id));
        if ($statement->rowCount() <= 0) {
            return;
        }

//        var_dump($blooming_entries);
//        die();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $matchingIdFound = false;
            for($i = 0; $i < count($blooming_entries); $i++){
//                die(json_encode($blooming_entries));
                $bloom_entry = $blooming_entries[$i];
//                die(json_encode($bloom_entry));
                if($bloom_entry->id == $row['id']){
                    $matchingIdFound = true;
                    continue;
                }
            }
            if(!$matchingIdFound){
                $item = new self($row);
                $blooming_entries[] = $item;
            }
        }
        $statement->closeCursor();

        usort($blooming_entries, array("self", "orderByComparison"));

        $blooming_entries = array_slice($blooming_entries, $start, $end);

        return $blooming_entries;
    }

    public static function orderByComparison($a, $b){
        if($a->start_date == $b->start_date){
            return 0;
        }
        return ($a->start_date > $b->start_date) ? -1 : 1;
    }

    private static function dateRangeCheck($begin, $end, $middle){
        $empty_date = new DateTime("0000-00-00");
        $begin = new DateTime($begin);
        $middle = new DateTime($middle);
        $end = new DateTime($end);
        if(($begin <= $middle) && ($middle <= $end)){
            return true;
        } else if(($begin <= $middle) && ($end == $empty_date)){
            return true;
        } else {
            return false;
        }
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming WHERE id = ?');
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            var_dump("derp");
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }

    public static function getAllByPlantID($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM blooming WHERE plant_id = ?');
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return;
        }

        $blooming = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $blooming[] = new self($row);
        }

        return $blooming;
    }

    public static function getLastestBloom($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM blooming WHERE plant_id = ? AND end_date = 000-00-00");
        $statement->execute(array($plant_id));
        if ($statement->rowCount() <= 0){
            $statement = $database->prepare("SELECT * FROM blooming WHERE plant_id = ? ORDER BY end_date DESC");
            $statement->execute(array($plant_id));
            if ($statement->rowCount() <= 0){
                return false;
            }

            $blooming = [];
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $blooming[] = new Blooming($row);
            }

            return $blooming;
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

    public static function createBlooming($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO blooming (plant_id, start_date) VALUES (?,?) ');
        $statement->execute(array($body['plant_id'], $body['start_date']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updatID = self::getByID($id);

        return $updatID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateBlooming($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE blooming SET start_date = ?, end_date = ? WHERE id = ?');
        $statement->execute(array($body['start_date'], $body['end_date'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
