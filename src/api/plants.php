<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Plants;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    $resource = '/plants';
    /**
     * @SWG\Get(
     *     path="/plants",
     *     summary="Get All",
     *     description="This is a descirption",
     *     tags={"Plants"},
     *     @SWG\Response(
     *         response=200,
     *         description="plant response",
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
    $app->get('', function($request, $response, $args) use ($app) {
      $plants = Plants::getAll();
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });


    $app->get('/alpha/{alpha}/{index}', function ($request, $response, $args) use ($app) {
      $plants = Plants::getPaginatedPlants($args["alpha"], $args["index"]);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    /**
     * @SWG\Get(
     *     path="/plants/{id}",
     *     summary="Get by Id",
     *     description="This is a descirption",
     *     tags={"Plants"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="The Plant's ID",
     *         required=true,
     *         type="integer",
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
    $app->get('/{id}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getById($args["id"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    $app->get('/accession/{accession_number}' , function($request, $response, $args) use($app){
      $plant = Plants::getByAccessionNumber($args["accession_number"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    $app->get('/variety/{variety_id}' , function($request, $response, $args) use($app){
      $plant = Plants::getByVarietyId($args["variety_id"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    // CREATE PLANT
    $app->post('', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::createPlant($body);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
