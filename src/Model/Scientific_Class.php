<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class ScientificClass implements \JsonSerializable
{
    public $id;
    public $classification_id;
    public $name;

    public function __construct($data)
    {
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->classification_id = intval($data['classification_id']);
            $this->name = $data['name'];
        }
    }

    function jsonSerialize()
    {
        return [
            'id'                 => $this->id,
            'classification_id'  => $this->classification_id,
            'name'               => $this->name
        ];
    }

    static function getAll()
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM scientific_class");
        $statement->execute();
        if ($statement->rowCount() <= 0){
            return null;
        }

        $scientificClasses = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $scientificClasses[] = new Classification($row);
        }
        return $scientificClasses;
    }

    static function getByID($scientificClass){
        global $database;
        $statement = $database->prepare("SELECT * FROM scientific_class WHERE scientific_class = $scientificClass");
        $statement->execute(array($scientificClass));
        $scientificClasses = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $scientificClasses[] = new Bloom($row);
        }

        return $scientificClasses;
    }

    static function createScientificClass($body){
        global $database;
        $statement = $database->prepare("INSERT INTO scientific_class (classification_id, name) VALUES (?,?)");
        $statement->execute(array($body['classification_id'], $body['name']));
        $id= $database->lastInsertId();
        $statement->closeCursor();
        return $id;
    }

    static function editScientificClass($body, $id){
        global $database;
        $statement = $database->prepare("UPDATE scientific_class SET classification_id = ?, name = ? WHERE id = ?");
        $statement->execute(array($id, $body['classification_id'], $body['name'], $id));
        $statement->closeCursor();
        return self::getById($id);
    }
}
?>
