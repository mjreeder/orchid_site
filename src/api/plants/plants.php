<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use \Model\Plants;

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    $resource = '/plants';

    // GET ALL PLANTS
    $app->get('', function() use ($app) {
      var_dump("derp");
    });

    // GET PLANT BY ID
    $app->get('/{id}', function ($request, $response, $args) use ($app) {
      var_dump('derpy derp');
      $plant = Plants::getById($args['id']);
      var_dump($plant);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
      var_dump($response);
    });
  });
});
