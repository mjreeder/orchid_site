<?php

class User implements \JsonSerializable{
  public $id;
  public $firstName;
  public $lastName;
  public $email;
  public $authLevel;


  public function __construct($user)
  {
    $this->id = $user['id'];
    $this->firstName = $user['first_name'];
    $this->lastName = $user['last_name'];
    $this->email = $user['email'];
    $this->authLevel = $user['auth_level'];
  }

  function jsonSerialize()
  {
      return [
          'id'            => $this->id,
          'firstName'     => $this->firstName,
          'lastName'      => $this->lastName,
          'email'         => $this->email,
          'authLevel'     => $this->authLevel
      ];
  }

  static function createUser($body){

    global $database;

    if(!$body['firstName'] || !$body['lastName'] || !$body['email'] ||
    !$body['password'] || !$body['authLevel']){
        throw new Exception('Missing required user information', 400);
    }
    $checkExistingUserStatement = $database->prepare("SELECT * FROM users WHERE email = ?");

    $checkExistingUserStatement->execute(array($body['email']));
    $row = $checkExistingUserStatement->fetch(PDO::FETCH_ASSOC);
    $checkExistingUserStatement->closeCursor();
    if ($row){
      throw new Exception('User with given email already exists', 409);
    }
    $checkExistingUserStatement->closeCursor();

    $hashedPassword = password_hash($body['password'], PASSWORD_BCRYPT);
    $statement = $database->prepare("INSERT INTO users (first_name, last_name, email, password_hash, auth_level) VALUES (?,?,?,?,?)");
    $statement->execute(array($body['firstName'], $body['lastName'], $body['email'], $hashedPassword, $body['authLevel']));
    $id = $database->lastInsertId();
    $statement->closeCursor();

    return self::getById($id);
  }

  static function getById($id){
    global $database;
    $statement = $database->prepare("SELECT * FROM users WHERE id = ?");
    $statement->execute(array($id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if ($row) {
      return new User($row);
      } else {
        return null;
      }
  }

  public static function getByEmail($email)
    {
        global $database;
        $statement = $database->prepare("SELECT * FROM users WHERE email = ?");
        $statement->execute(array($email));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        if ($row){
            return new User($row);
        } else {
            return null;
        }
    }

  public static function changeUserPassword($user, $newUserPassword){
    global $database;
    if(!$body['id'] || !$body['firstName'] || $body['lastName'] || $body['email'] ||
    $body['passwordHash']){
        throw new Exception('Missing required user information', 400);
    }
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $statement = $database->prepare("UPDATE users SET password = ? WHERE id = ?");
    $statement->execute(array($hashed_password, $user->id));
    $affected_rows = $statement->rowCount();
    $statement->closeCursor();
    if ($affected_rows < 1) {
      return false;
    }
    return true;
  }
}



?>
