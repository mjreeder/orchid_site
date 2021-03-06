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
 *      "id",
 *      "name",
 *      "rank"
 *   }
 *  )
 */
class Classification implements \JsonSerializable
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
     * @var int
     */
    public $rank;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->id = intval($data['id']);
            $this->name = $data['name'];
            $this->rank = $data['rank'];
        }
    }

    public function jsonSerialize()
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'rank' => $this->rank,
        ];
    }

    public static function getAll()
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM classification');
        $statement->execute();
        if ($statement->rowCount() <= 0) {
            return;
        }

        $classifications = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $classifications[] = new self($row);
        }

        return $classifications;
    }

    public static function getByID($classification_id)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM classification WHERE id = $classification_id");
        $statement->execute(array($classification_id));
        $classifications = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $classifications[] = new self($row);
        }

        return $classifications;
    }

    public static function createClassification($body)
    {
        global $database;
        $statement = $database->prepare('INSERT INTO classification (name, rank) VALUES (?,?)');
        $statement->execute(array($body['name'], $body['rank']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        return $id;
    }

    public static function editClassification($body, $id)
    {
        global $database;
        $statement = $database->prepare('UPDATE classification SET name = ?, rank = ? WHERE id = ?');
        $statement->execute(array($id, $body['name'], $body['rank'], $id));
        $statement->closeCursor();

        return self::getById($id);
    }
}
