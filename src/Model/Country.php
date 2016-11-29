<?php
/**
 * Created by PhpStorm.
 * User: sethwinslow
 * Date: 9/9/16
 * Time: 2:02 PM.
 */

namespace orchid_site\src\Model;

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';
require_once '../utilities/database.php';
use PDO;
/**
 * @SWG\Definition(
 *  required={
 *      "name"
 *   }
 *  )
 */
class Country implements \JsonSerializable
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

    /* ========================================================== *
     * CONSTRUCTORS
     * ========================================================== */

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
        }
    }

    public function jsonSerialize()
    {
        return[
          'id' => $this->id,
          'name' => $this->name,
        ];
    }

    /* ========================================================== *
     * GET
     * ========================================================== */

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM country');
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            return;
        }

        $country = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $country[] = new self($row);
        }

        return $country;
    }


    public static function getCurrentCountires(){
        global $database;
        $statement = $database->prepare("SELECT * FROM country WHERE id IN (SELECT country_id FROM plant_country_link)");
        $statement->execute();

        $countriesList = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $countriesList[] = new self($row);
        }

        return $countriesList;

    }

    public static function getByCountryID($id){
      global $database;
      $statement = $database->prepare("SELECT * FROM country WHERE id = ?");
      $statement->execute(array($id));

      $countriesList = [];

      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $countriesList[] = new self($row);
      }

      return $countriesList;

    }

    /* ========================================================== *
     * POST
     * ========================================================== */

    //WE ARE NOT ADDING ANY NEW COUNTRY

    /* ========================================================== *
     * PUT
     * ========================================================== */

    //WE ARE NOT CHANGING THE COUNTRIES NAME

    /* ========================================================== *
     * DELETE
     * ========================================================== */
}
