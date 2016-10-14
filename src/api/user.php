<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/users', function () use ($app) {

    /**
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
    $app->post('/login', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $session = Session::create_session($body);
      $output = new Response($session);
      $response->getBody()->write(json_encode($output));
    });

    /**
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
    $app->post('/logout', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $session = Session::deleteSession($body);
      $output = new Response($session);
      $response->getBody()->write(json_encode($output));
    });

    /**
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
    $app->post('', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $user = User::createUser($body);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    });

    /**
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
    $app->put('/update_user_password/{id}', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $user = User::createUser($body);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    });

    /**
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
    });

    /**
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


  });
});
