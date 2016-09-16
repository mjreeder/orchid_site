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
 *      "name",
 *      "room"
 *   }
 *  )
 */
class Location implements \JsonSerializable
{
    /**
     * @SWG\Property(type="integer", format="int64")
     */
    public $id;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $name;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $room;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->room = $data['room'];
        }
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
            'room' => $this->room,
            'name' => $this->name,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM location');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $locations = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $locations[] = new self($row);
        }

        return $locations;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    //SINCE THE ROOMS ARE ALL SET THERE IS NO NEED TO CREATE A NEW LOCATION

    /* ========================================================== *
     * PUT
     * ========================================================== */

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
