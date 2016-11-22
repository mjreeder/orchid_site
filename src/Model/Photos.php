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
 *      "url",
 *      "type",
 *      "active"
 *   }
 *  )
 */
class Photos implements \JsonSerializable
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
    public $url;
    /**
     * @SWG\Property()
     *
     * @var [*]
     */
    public $kind;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $active;

    public $fileName;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->url = $data['url'];
            $this->type = $data['type'];
            $this->active = intval($data['active']);
            $this->fileName = $data['fileName'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'url' => $this->url,
            'type' => $this->type,
            'active' => $this->active,
            'fileName' => $this->fileName,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM photos WHERE active = 1');
        $statement->execute();
        $photos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $photos[] = new self($row);
        }

        return $photos;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM photos WHERE plant_id = $plant_id AND active = 1");
        $statement->execute();
        $photos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $photos[] = new self($row);
        }

        return $photos;
    }

    public static function getByID($id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM photos WHERE id = $id");
        $statement->execute();
        $photos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $photos[] = new self($row);
        }

        return $photos;
    }

    public static function getSimilarPhotos($species_name)
    {
        if($species_name == ""){
            return false;
        }

        global $database;
        $statement = $database->prepare("SELECT * FROM photos Pl WHERE pl.plant_id IN (SELECT id FROM plants Pt WHERE Pt.species_name = ?)");
        $statement->execute(array($species_name));
        $similarPhotos = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $similarPhotos[] = new self($row);
        }

        return $similarPhotos;
    }



    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createPhoto($body){
        global $database;
        $statement = $database->prepare("INSERT INTO photos (plant_id, url, type, active, fileName) VALUES (?,?,?,1, ?)");
        $statement->execute(array($body['plant_id'], $body['url'], $body['type'], $body['fileName']));
        $id = $database->lastInsertId();
        $updateID = Photos::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updatePhoto($body){
        global $database;

        $statement = $database->prepare("UPDATE photos SET url = ?, type = ?, plant_id = ?, fileName = ?, active = 1 WHERE id = ?");
        $statement->execute(array($body['url'], $body['type'], $body['plant_id'], $body['fileName'] ,$body['id']));
        $updateID = Photos::getByID($body['id']);

        return $updateID;
    }

    public static function deactive($body){
        global $database;
        $statement = $database->prepare("UPDATE photos SET active = 0 WHERE id = ?");
        $statement->execute(array($body['id']));
        $updateID = Photos::getByID($body['id']);

        return $updateID;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
