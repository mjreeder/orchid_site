<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class PestControl implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $timestamp;
    public $comment;

    public function __construct($data)
    {
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->timestamp = $data['timestamp'];
            $this->comment = $data['comment'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id' =>$this->id,
            'plant_id' =>$this->plant_id,
            'timestamp' =>$this->timestamp,
            'comment' =>$this->comment
        ];
    }

    static function getAll()
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM pest_control");
        $statement->execute();
        $pestControl = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $pestControl[] = new PestControl($row);
        }
        return $pestControl;
    }

    static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM pest_control WHERE plant_id = $plant_id");
        $statement->execute();
        $pestControl = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $pestControl[] = new PestControl($row);
        }
        return $pestControl;
    }
}

?>