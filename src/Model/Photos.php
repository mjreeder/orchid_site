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

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->url = $data['url'];
            $this->kind = intval($data['kind']);
            $this->active = intval($data['active']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'url' => $this->url,
            'kind' => $this->kind,
            'active' => $this->active,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM photos');
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
        $statement = $database->prepare("SELECT * FROM photos WHERE plant_id = $plant_id");
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



    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createPhoto($body){
        global $database;
        $statement = $database->prepare("INSERT INTO photos (plant_id, url, kind, active) VALUES (?,?,?,1)");
        $statement->execute(array($body['plant_id'], $body['url'], $body['kind']));
        $id = $database->lastInsertId();
        $updateID = Photos::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updatePhoto($id){
        global $database;
        $statement = $database->prepare("UPDATE photos SET active = 0 WHERE id = ?");
        $statement->execute(array($id));
        $updateID = Photos::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
