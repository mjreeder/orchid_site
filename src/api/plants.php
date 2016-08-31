<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Plants;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    $resource = '/plants';

    $app->get('', function($request, $response, $args) use ($app) {
      $plants = Plants::getAll();
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    //Get page of plants alphbetically
    $app->get('/alpha/{alpha}/{index}', function ($request, $response, $args) use ($app) {
      $plants = Plants::getPaginatedPlants($args["alpha"], $args["index"]);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    // GET PLANT BY ID
    $app->get('/{id}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getById($args["id"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    // CREATE PLANT
    $app->post('', function ($request, $response, $args) use ($app) {
      $plant = Plants::createPlant($args);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
