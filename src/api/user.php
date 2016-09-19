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



  });
});
