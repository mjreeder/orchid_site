<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Photos implements \JsonSerializable
{
    public $plant_id;
    public $url;
    public $type;

    public function __construct($data)
    {
        if (is_array($data)){
            $this->plant_id = intval($data['plant_id']);
            $this->url = $data['url'];
            $this->type = intval($data['type']);
        }
    }

    function jsonSerialize()
    {
        return [
            'plant_id'=>$this->plant_id,
            'url' =>$this->url,
            'type'  =>$this->type
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll(){
        global $database;
        $statement = $database->prepare("SELECT * FROM photos");
        $statement->execute();
        $photos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $photos[] = new Photos($row);
        }

        return $photos;
    }

    static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM photos WHERE plant_id = $plant_id");
        $statement->execute();
        $photos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $photos[] = new Photos($row);
        }

        return $photos;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    /* ========================================================== *
     * PUT
     * ========================================================== */

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
?>