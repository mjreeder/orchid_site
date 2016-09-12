<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\User;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/users', function () use ($app) {


    $app->post('/login', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $session = Session::create_session($body);
      $output = new Response($session);
      $response->getBody()->write(json_encode($output));
    });

    $app->post('', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $user = User::createUser($body);
      $output = new Response($user);
      $response->getBody()->write(json_encode($output));
    });


  });
});
