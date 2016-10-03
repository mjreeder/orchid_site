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
class Plant_Country_Link implements \JsonSerializable
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
    public $country_id;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->plant_id = intval($data['plant_id']);
            $this->country_id = intval($data['country_id']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'country_id' => $this->country_id,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM plant_country_link');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return false;
        }

        $p_c_link = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $p_c_link[] = new Plant_Country_Link($row);
        }

        return $p_c_link;
    }

    public static function getByID($id){
        global $database;
        $statement = $database->prepare("SELECT * FROM plant_country_link WHERE id = ?");
        $statement->execute(array($id));
        if ($statement->rowCount()<= 0){
            return false;
        }

        $p_c_link = $statement->fetch(PDO::FETCH_ASSOC);
        return $p_c_link;
    }

    public static function getByPlantID($plant_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM plant_country_link WHERE plant_id = ?");
        $statement->execute(array($plant_id));
        $plant_country_link = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $plant_country_link[] = new Plant_Country_Link($row);
        }

//        $aaa = $plant_ccountry_link.count();

//        $country = array();

        $countryNames =  array();

        for ($i = 0; $i < count($plant_country_link); $i++){
            $country = $plant_country_link[$i];

            $id = $country->country_id;
            $country = Country::getByCountryID($id);

            array_push($countryNames, $country);
        }

        if (count($countryNames) <= 0){
            header('Content-Type: application/javascript');
            http_response_code(400);

            $response = array(
                "status" => "fail",
                "message" => "There is countries for this plant_id"
            );
            die(json_encode( (object) $response ));

        }


        return $countryNames;
    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    public static function createLink($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO plant_country_link (plant_id, country_id) VALUES (?, ?)');
        $statement->execute(array($body['plant_id'], $body['country_id']));
        $id = $database->lastInsertId();
        $statement->closeCursor();
        $updateID = Plant_Country_Link::getByID($id);

        return $updateID;
    }

    /* ========================================================== *
     * PUT
     * ========================================================== */

    public static function updatePlantCountryLink($body)
    {
        global $database;
        $statement = $database->prepare('UPDATE plant_country_link SET plant_id = ?, country_id = ? WHERE id = ?');
        $statement->execute(array($body['plant_id'], $body['country_id'], $body['id']));
        $id = self::getByID($body['id']);

        return $id;
    }

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
