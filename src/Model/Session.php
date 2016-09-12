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

  private static function generate_key(){
        return bin2hex(openssl_random_pseudo_bytes(64));
    }

    public static function create_session($user){
        global $database;
        //clears timestamps older than 3 days
        Session::check_timestamp($user->id);

        $id = $user->id;
        $key = Session::generate_key();
        try {
            $statement = $database->prepare("INSERT INTO session (user_id, session_key) VALUES (?, ?)");
            $statement->execute(array($id, $key));
            $statement->closeCursor();
            $statement = $database->prepare("SELECT * FROM session WHERE user_id = ? AND session_key = ?");
            $statement->execute(array($id, $key));
            $session = $statement->fetch(PDO::FETCH_ASSOC);
            $statement->closeCursor();

            $current_session = new Session($session);
            return array(
                'session_key'=>$current_session->session_key,
                'session_id'=>$current_session->session_id);
        } catch(Exception $e){
            throw new Exception($e->getMessage(), 500);
        }
    }

    public static function check_timestamp($user_id){
        global $database;
        //259200 SECOND == 3 days
        $statement = $database->prepare("DELETE FROM session WHERE user_id = ? AND now() > (start_time + INTERVAL 259200 SECOND)");
        $statement->execute(array($user_id));
        $statement->closeCursor();
    }

    private static function delete_session_by_id($session_id){
        global $database;
        $statement = $database->prepare("DELETE FROM session WHERE id = ?");
        $statement->execute(array($session_id));
        $statement->closeCursor();
    }

}


?>
