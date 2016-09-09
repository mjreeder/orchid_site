<?php
namespace orchid_site\src\Model;
error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
require_once "../utilities/database.php";
use PDO;

class Location implements \JsonSerializable
{
    public $id;
    public $name;
    public $room;

    public function __construct($data){
        if (is_array($data)){
            $this->id = intval($data['id']);
            $this->name = intval($data['name']);
            $this->room = intval($data['room']);
        }
    }

    function jsonSerialize(){
        return [
          'id' => $this->id,
            'room' => $this->room,
            'name' => $this->name
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    static function getAll()
    {

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
