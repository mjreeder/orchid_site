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
 *      "score"
 *   }
 *  )
 */
class Health implements \JsonSerializable
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
    public $tmestamp;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $score;

    public $comment;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->score = $data['score'];
            $this->comment = $data['comment'];
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'plant_id' => $this->plant_id,
            'timestamp' => $this->timestamp,
            'score' => $this->score,
            'comment' => $this->comment,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM health');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return false;
        }

        $health = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $health[] = new self($row);
        }

        return $health;
    }

    public static function getByID($id){
        global $database;
        $statement = $database->prepare("SELECT * FROM health WHERE id = ?");
        $statement->execute(array($id));
        if ($statement->rowCount()<= 0){
            return false;
        }

        $health = $statement->fetch(PDO::FETCH_ASSOC);
        return $health;
    }

    public static function getByPlantID($plant_id, $page)
    {
        global $database;
        $offset = intval(($page - 1) * 5);
        $statement = $database->prepare("SELECT * FROM health WHERE plant_id = ? ORDER BY TIMESTAMP DESC LIMIT 5 OFFSET " . $offset);
        $statement->execute(array($plant_id));
        $health = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $health[] = new Health($row);
        }

        return $health;
    }

    public static function getSinglePlantByID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM health WHERE plant_id = ? ORDER BY id ASC LIMIT 1");
        $statement->execute(array($plant_id));
        $health = null;

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $health = new Health($row);
        }

        return $health;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createHealth($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO health (plant_id, score, timestamp, comment) VALUES (?,?,?,?)');
        $statement->execute(array($body['plant_id'], $body['score'], $body['timestamp'], $body['comment']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updateID = Health::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updateHealth($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE health SET timestamp = ?, plant_id = ?, score = ?, comment = ? WHERE id = ?');
        $statement->execute(array($body['timestamp'], $body['plant_id'], $body['score'], $body['comment'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
