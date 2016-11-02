<?php

/**
 * @SWG\Definition(
 *  required={
 *      "firstName",
 *      "lastN",
 *      "email",
 *      "authLevel"
 *   }
 *  )
 */
class User implements \JsonSerializable
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
    public $firstName;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $lastName;
    /**
     * @SWG\Property()
     *
     * @var string
     */
    public $email;
    /**
     * @SWG\Property()
     *
     * @var int
     */
    public $authLevel;

    public function __construct($user)
    {
        $this->id = $user['id'];
        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->email = $user['email'];
        $this->authLevel = $user['auth_level'];
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
          'firstName' => $this->firstName,
          'lastName' => $this->lastName,
          'email' => $this->email,
          'authLevel' => $this->authLevel,
      ];
    }

    public static function createUser($body)
    {
        global $database;

        if (!$body['firstName'] || !$body['lastName'] || !$body['email'] ||
    !$body['password'] || !$body['authLevel']) {
            throw new Exception('Missing required user information', 400);
        }
        $checkExistingUserStatement = $database->prepare('SELECT * FROM users WHERE email = ?');

        $checkExistingUserStatement->execute(array($body['email']));
        $row = $checkExistingUserStatement->fetch(PDO::FETCH_ASSOC);
        $checkExistingUserStatement->closeCursor();
        if ($row) {
            throw new Exception('User with given email already exists', 409);
        }
        $checkExistingUserStatement->closeCursor();

        $hashedPassword = password_hash($body['password'], PASSWORD_BCRYPT);
        $statement = $database->prepare('INSERT INTO users (first_name, last_name, email, password_hash, auth_level) VALUES (?,?,?,?,?)');
        $statement->execute(array($body['firstName'], $body['lastName'], $body['email'], $hashedPassword, $body['authLevel']));
        $id = $database->lastInsertId();
        $statement->closeCursor();

        return self::getById($id);
    }

    public static function getById($id)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM users WHERE id = ?');
        $statement->execute(array($id));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        if ($row) {
            return new self($row);
        } else {
            return;
        }
    }

    public static function getByEmail($email)
    {
        global $database;
        $statement = $database->prepare('SELECT * FROM users WHERE email = ?');
        $statement->execute(array($email));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        if ($row) {
            return new self($row);
        } else {
            return;
        }
    }

    public static function getAllUsers(){
        global $database;
        $statement = $database->prepare('SELECT * FROM users');
        $statement->execute();
        $users = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new self($row);
        }

        return $users;
    }

    public static function getUserHashedPassword($id){
      global $database;
      $statement = $database->prepare('SELECT password_hash FROM users WHERE id= ?');
      $statement->execute(array($id));
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      $statement->closeCursor();
      if ($row) {
          return $row["password_hash"];
      } else {
          throw new Exception('User does not exits', 404);
      }
    }

    public static function changeUserPassword($body)
    {
        global $database;
        if (!$body['id'] || $body['passwordHash'] || $body['newPassword']) {
            throw new Exception('Missing required information', 400);
        }
        $hashed_password = password_hash($body['newPassword'], PASSWORD_BCRYPT);
        $statement = $database->prepare('UPDATE users SET password = ? WHERE id = ?');
        $statement->execute(array($hashed_password, $user->id));
        $affected_rows = $statement->rowCount();
        $statement->closeCursor();
        if ($affected_rows < 1) {
            return false;
        }

        return true;
    }

    public static function delete($id)
    {
        global $database;
        $statement = $database->prepare("DELETE FROM users WHERE id = $id");
        $statement->execute();
        $statement->closeCursor();
        if ($statement->rowCount() > 0) {
            return array('success' => true);
        } else {
            return array('success' => false);
        }
    }

    public static function isUserAuthorized($session_key){
      global $database;
      $statement = $database->prepare('SELECT auth_level FROM users LEFT JOIN session ON session.user_id=users.id WHERE session_key = ?');
      $statement->execute(array($session_key));
      $row = $statement->fetch(PDO::FETCH_ASSOC);
      $authLevel = $row['auth_level'];
      $statement->closeCursor();
      if($authLevel == 1){
        return true;
      }
      else{
        return false;
      }
    }
}
