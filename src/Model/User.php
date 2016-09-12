<?php

class User implements \JsonSerializable{
  public $id;
  public $firstName;
  public $lastName;
  public $email;
  public $passwordHash;

  public function __construct($user)
  {
    $this->id = $user['id'];
    $this->firstName = $user['firstName'];
    $this->lastName = $user['lastName'];
    $this->email = $user['email'];
    $this->passwordHash = $user['passwordHash'];
  }

  static function createUser($body){
    global $database;
    if(!$body['firstName'] || $body['lastName'] || $body['email'] ||
    $body['password']){
        throw new Exception('Missing required user information', 400);
    }
    $hashedPassword = password_hash($body['password'], PASSWORD_BCRYPT);
    $statement = $database->prepare("INSERT INTO users (first_name, last_name, email, password_hash, auth_level) VALUES (?,?,?,?,?)");
    $statement->execute(array($body['firstName'], $body['lastName'], $body['email'], $hashedPassword, $body['auth_level']));
    $id = $database->lastInsertId();
    $statement->closeCursor();

    return $id;
  }

  static function getById($id){
    global $database;
    $statement = $database->prepare("SELECT * FROM users WHERE id = ?");
    $statement->execute(array($id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if ($row) {
      $user = new User($row);
      return $user;
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
