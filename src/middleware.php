<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

class Validator
{
    public static function validate_admin_session($request, $response)
    {
        global $database;
        global $current_admin_session;
        $body = $request->getParsedBody();
        $session_key = $body['session_key'];
        $session_id = $body['session_id'];
        if ($session_key == null || $session_key == '') {
            throw new Exception('Session key required', 400);
        }
        if (!$session_id) {
            throw new Exception('Session id required', 400);
        }
        $statement = $database->prepare('SELECT auth_level FROM users LEFT JOIN session ON session.user_id=users.id WHERE session_key = ?');
        $statement->execute(array($session_key));
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $authLevel = $row['auth_level'];
        $statement->closeCursor();
        if ($authLevel == 1 || $authLevel == 2) {
            $statement = $database->prepare('SELECT * FROM session WHERE session_key=? AND session_id=?');
            $statement->execute(array($session_key, $session_id));
            $session = $statement->fetch(PDO::FETCH_ASSOC);
            Session::check_timestamp($session['user_id']);
            //re-fetch the session to make sure timestamp wasn't too old
            $statement = $database->prepare('SELECT * FROM session WHERE session_id=?');
            $statement->execute(array($session['session_id']));
            $session = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$session) {
                throw new Exception('Invalid session', 401);
            }

            return true;
        } else {
            throw new Exception('current user not authorized', 403);
        }

        //
        // return true;
    }
}

$validate_admin = function ($request, $response, $next) {
    //if Validated, creates a global AdminSession object called currentAdminSession
    $results = Validator::validate_admin_session($request, $response);
    if (gettype($results) == 'array') {
        return $response->withJSON($results);
    } else {
        $response = $next($request, $response);
    }

    return $response;
};

$app->add(function ($request, $response, $next) {
    $response = $response->withHeader('Content-Type', 'application/json');
    return $next($request, $response);
});
