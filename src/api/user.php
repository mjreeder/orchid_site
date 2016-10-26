<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
require_once '../utilities/response.php';


$app->group('/api', function () use ($app) {
  $app->group('/users', function () use ($app) {

    global $validate_admin;
    /*
     * @SWG\Post(
     *     path="/users/login",
     *     summary="login for a user",
     *     description="login for a user and create a session",
     *     tags={"Users"},
     *     @SWG\Parameter(
     *         name="email",
     *         in="args",
     *         description="The users email",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="args",
     *         description="The users password",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="plant response",
     *         @SWG\Schema(
     *              ref="#/definitions/User"
     *          )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(
     *             ref="#/definitions/Error"
     *         )
     *     )
     * )
     */
    $app->post('/login', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $session = Session::create_session($body);
      $output = new Response($session);
      $response->getBody()->write(json_encode($output));
    });

    /*
     * @SWG\Post(
     *     path="/users/logout",
     *     summary="logout function for a user",
     *     description="log user out and delete session",
     *     tags={"Users"},
     *     @SWG\Parameter(
     *         name="session_id",
     *         in="args",
     *         description="The users current session id",
     *         required=true,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="user_id",
     *         in="args",
     *         description="The users id",
     *         required=true,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="session_id",
     *         in="args",
     *         description="admin session id",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="session_key",
     *         in="args",
     *         description="admin session key",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="plant response",
     *         @SWG\Schema(
     *              ref="#/definitions/Plants"
     *          )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(
     *             ref="#/definitions/Error"
     *         )
     *     )
     * )
     */
    $app->post('/logout', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $session = Session::deleteSession($body);
      $output = new Response($session);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    /*
     * @SWG\Post(
     *     path="/users",
     *     summary="create a user",
     *     description="function to create a user",
     *     tags={"Users"},
     *     @SWG\Parameter(
     *         name="email",
     *         in="args",
     *         description="The users email",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="session_id",
     *         in="args",
     *         description="admin session id",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="session_key",
     *         in="args",
     *         description="admin session key",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="args",
     *         description="The users password",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="firstName",
     *         in="args",
     *         description="The users first name",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="lastName",
     *         in="args",
     *         description="The users lastName",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="authLevel",
     *         in="args",
     *         description="The users authorization level",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="plant response",
     *         @SWG\Schema(
     *              ref="#/definitions/Plants"
     *          )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(
     *             ref="#/definitions/Error"
     *         )
     *     )
     * )
     */
    $app->post('', function ($request, $response, $args) use ($app) {
        $body = $request->getParsedBody();
        $user = User::createUser($body);
        $output = new Response($user);
        $response->getBody()->write(json_encode($output));
    });

    /*
     * @SWG\Put(
     *     path="/users",
     *     summary="change user password",
     *     description="function to change a user password",
     *     tags={"Users"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="args",
     *         description="The users id",
     *         required=true,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="args",
     *         description="The users password",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="session_id",
     *         in="args",
     *         description="admin session id",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="session_key",
     *         in="args",
     *         description="admin session key",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="newPassword",
     *         in="args",
     *         description="The users new password",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="plant response",
     *         @SWG\Schema(
     *              ref="#/definitions/Plants"
     *          )
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(
     *             ref="#/definitions/Error"
     *         )
     *     )
     * )
     */
    $app->put('/update_user_password/{id}', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $user = User::createUser($body);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    /*
    * @SWG\Delete(
    *     path="/users/{id}",
    *     summary="delete user by Id",
    *     description="delete user by Id",
    *     tags={"Plants"},
    *     @SWG\Parameter(
    *         name="id",
    *         in="path",
    *         description="The user's id",
    *         required=false,
    *         type="int",
    *         format="int64"
    *     ),
    *     @SWG\Parameter(
    *         name="session_id",
    *         in="args",
    *         description="admin session id",
    *         required=false,
    *         type="string",
    *         format=""
    *     ),
    *     @SWG\Parameter(
    *         name="session_key",
    *         in="args",
    *         description="admin session key",
    *         required=false,
    *         type="string",
    *         format=""
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="plant response",
    *         @SWG\Schema(
    *              ref="#/definitions/Plants"
    *          )
    *     ),
    *     @SWG\Response(
    *         response="default",
    *         description="unexpected error",
    *         @SWG\Schema(
    *             ref="#/definitions/Error"
    *         )
    *     )
    * )
    */
    $app->delete('/{id}', function ($request, $response, $args) use ($app) {
      $user = Users::delete($args['id']);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    /*
    * @SWG\Get(
    *     path="/users/session_key/{session_key}",
    *     summary="Get by session key",
    *     description="get user by session key",
    *     tags={"Session"},
    *     @SWG\Parameter(
    *         name="session_key",
    *         in="path",
    *         description="The session key",
    *         required=false,
    *         type="int",
    *         format="int64"
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="Success",
    *         @SWG\Schema(
    *             ref="#/definitions/SinglePlantSuccess"
    *         )
    *     ),
    *     @SWG\Response(
    *         response="default",
    *         description="unexpected error",
    *         @SWG\Schema(
    *             ref="#/definitions/Error"
    *         )
    *     )
    * )
    */
    $app->get('/session_key/{session_key}', function ($request, $response, $args) use ($app) {
      $user = Session::getUserFromSessionKey($args['session_key']);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    });

    $app->get('/auth', function ($request, $response, $args) use ($app) {
      $code = $request->getQueryParam('code');

      $error = $request->getQueryParam('error');

      $errorDescription = $request->getQueryParam('error_description');

      //return $response->getBody()->write(json_encode("HELLLO"));
      if(isset($error)){
        throw new Exception($errorDescription, 400);
      }
      if(!isset($code)){
        throw new Exception("No code given", 400);
      }

      $url = 'https://api.box.com/oauth2/token';
      $fields = array(
          'grant_type' => urlencode("authorization_code"),
          'code' => urlencode($code),
          'client_id' => urlencode("xvgdpsrq8aof6f2eijnuclflm93alu8l"),
          'client_secret' => urlencode("u0KIbCknZ01K1Sm4N3sxXfLD1ncQmpr2")
      );



      //url-ify the data for the POST
      $fields_string = "";
      foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
      rtrim($fields_string, '&');


      //open connection
      $ch = curl_init();

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

      //execute post
      $result = curl_exec($ch);

      //close connection
      curl_close($ch);

      $fields = json_decode($result);
//      return $response->getBody()->write($fields);
      $fields_string = "";
      foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
      rtrim($fields_string, '&');

//      return $response->getBody()->write($fields_string);
      $redirect = "http://localhost:8888/orchid_frontend/admin/#/auth?" . $fields_string;
//      echo($redirect);
      return $response->withStatus(302)->withHeader("Location", $redirect);

    });

  });
});
