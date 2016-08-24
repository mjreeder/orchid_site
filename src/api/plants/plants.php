<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Plants;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    $resource = '/plants';

    // GET ALL PLANTS
    $app->get('', function() use ($app) {
      var_dump("derp");
    });

    // GET PLANT BY ID
    $app->get('/{id}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getById($args["id"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });
  });
});
