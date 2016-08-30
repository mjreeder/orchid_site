<?php
namespace orchid_site\src\Model;
error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";

class Area implements \JsonSerializable
{
    public $id;
    public $plant_id;
    public $continent;
    public $area;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->continent = $data['continent'];
            $this->area = $data['area'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'continent' => $this->continent,
            'area' => $this->area
        ];
    }

    static function getAll()
    {

        global $database;
        $statement = $database->prepare("SELECT * FROM area");
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return null;
        };

        $areas = $statement->fetchAll();

        $areaArray = array();
        for ($i = 0; $i < sizeof($areas); $i++) {
            $singleArea = $areas[$i];
            var_dump($singleArea);
            array_push($areaArray, $singleArea);
        }
        return $areaArray;
        //var_dump($areaArray);
    }

    static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM area WHERE id = $id");
        $statement->execute(array($id));
        if ($statement->rowCount() <= 0) {
            return null;
        }
        return new Area($statement->fetch());
    }
    
}
?>