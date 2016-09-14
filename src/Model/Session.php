<?php
/**
 *
 */
class Session
{
    public $session_id;
    public $session_dev;

    public function __construct($session)
    {
        $this->session_id = $session['session_id'];
        $this->session_key = $session['session_key'];
    }

    private static function generate_key()
    {
        return bin2hex(openssl_random_pseudo_bytes(64));
    }

    public static function create_session($body)
    {
        global $database;
        if (!$body['email']) {
            throw new Exception('Missing required user information', 400);
        }

        $user = User::getByEmail($body['email']);
    //clears timestamps older than 3 days
    self::check_timestamp($user->id);
        $id = $user->id;
        $key = self::generate_key();

        try {
            $statement = $database->prepare('INSERT INTO session (user_id, session_key) VALUES (?, ?)');
            $statement->execute(array($id, $key));
            $statement->closeCursor();
            $statement = $database->prepare('SELECT * FROM session WHERE user_id = ? AND session_key = ?');
            $statement->execute(array($id, $key));
            $session = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();

            $current_session = new self($session);

            return array(
        'session_key' => $current_session->session_key,
        'session_id' => $current_session->session_id, );
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public static function check_timestamp($user_id)
    {
        global $database;
      //259200 SECOND == 3 days
      $statement = $database->prepare('DELETE FROM session WHERE user_id = ? AND now() > (timestamp + INTERVAL 259200 SECOND)');
        $statement->execute(array($user_id));
        $statement->closeCursor();
    }

    private static function deleteSessionById($session_id)
    {
        global $database;
        $statement = $database->prepare('DELETE FROM session WHERE session_id = ?');
        $statement->execute(array($session_id));
        $statement->closeCursor();
    }

    public static function deleteSession($data)
    {
        global $database;
        if (isset($data['session_id'])) {
            self::deleteSessionById($data['session_id']);

            return array(
        'success' => true,
        );
        }
      //if data only contains session_key and teacher_id

      $statement = $database->prepare('SELECT id FROM session WHERE session_key = ? AND user_id = ?');
        $statement->execute(array($data['session_key'], $data['user_id']));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new Exception('Session already removed.', 500);
        }
        $statement->closeCursor();
        self::delete_session_by_id($row['id']);

        return array(
        'success' => true,
      );
    }
}
