<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Plants;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
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

    /**
     * @SWG\Get(
     *     path="/plants/{alpha}/{index}",
     *     summary="Get plant by first letter and by index",
     *     description="This is a descirption",
     *     tags={"Plants"},
     *     @SWG\Parameter(
     *         name="alpha",
     *         in="path",
     *         description="The Plant's first letter",
     *         required=true,
     *         type="char",
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

    /**
     * @SWG\Get(
     *     path="/plants/{accession_number}",
     *     summary="Get by accession number",
     *     description="Get plant by its accession number",
     *     tags={"Plants"},
     *     @SWG\Parameter(
     *         name="accession number",
     *         in="path",
     *         description="The Plant's accession number",
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
    $app->get('/accession/{accession_number}' , function($request, $response, $args) use($app){
      $plant = Plants::getByAccessionNumber($args["accession_number"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /**
     * @SWG\POST(
     *     path="/plants",
     *     summary="create new plant",
     *     description="create new plant",
     *     tags={"Plants"},
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
      $plant = Plants::createPlant($body);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
