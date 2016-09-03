<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Health implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $tmestamp;
    public $score;

    public function __construct($data)
    {
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->score = intval($data['score']);
        }
    }

    function jsonSerialize()
    {
        return [
          'id'         =>$this->id,
            'plant_id' =>$this->plant_id,
            'timestamp' => $this->timestamp,
            'score'     => $this->score
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll()
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM health");
        $statement->execute();
        if ($statement->rowCount() <= 0){
            return null;
        }

        $health = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $health[] = new Health($row);
        }
        return $health;
    }

    static function getByPlantID($plant_id){
        global $database;
        $statement = $database->prepare("SELECT * FROM health WHERE plant_id = $plant_id");
        $statement->execute(array($plant_id));
        $health = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $health[] = new Bloom($row);
        }

        return $health;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    static function createHealth($body){
        global $database;
        $statement = $database->prepare("INSERT INTO health (plant_id, score) VALUES (?,?)");
        $statement->execute(array($body['plant_id'], $body['score']));
        $id= $database->lastInsertId();
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
?>