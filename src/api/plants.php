<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
use orchid_site\src\Model\Plants;

require_once '../utilities/response.php';

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    /*
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
    $app->get('', function ($request, $response, $args) use ($app) {
      $plants = Plants::getAll();
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    /*
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
      $plants = Plants::getPaginatedPlants($args['alpha'], $args['index']);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    /*
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
      $plant = Plants::getById($args['id']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /*
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
    $app->get('/accession/{accession_number}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getByAccessionNumber($args['accession_number']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /*
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

    /*
     * @SWG\DELETE(
     *     path="/plants/{id}",
     *     summary="delete plants by Id",
     *     description="delete plants by Id",
     *     tags={"Plants"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="The Plant's id",
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
      $plant = Plants::delete($args['id']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /*
     * @SWG\Put(
     *     path="/plants",
     *     summary="Edit plant",
     *     description="Edit the plant given a plant object",
     *     tags={"Plants"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="args",
     *         description="The Plant's ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="args",
     *         description="The Plant's name",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="accession_number",
     *         in="args",
     *         description="The Plant's accession_number",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="authority",
     *         in="args",
     *         description="The Plant's authority",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="distribution",
     *         in="args",
     *         description="The Plant's distribution",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="habitat",
     *         in="args",
     *         description="The Plant's habitat",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="scientific_name",
     *         in="args",
     *         description="The Plant's scientific name",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="culture",
     *         in="args",
     *         description="The Plant's culture",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="donation_comment",
     *         in="args",
     *         description="The Plant's donation comment",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="date_received",
     *         in="args",
     *         description="The Plant's date received",
     *         required=false,
     *         type="date",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="received_from",
     *         in="args",
     *         description="The Plant's received from",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="description",
     *         in="args",
     *         description="The Plant's description",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="args",
     *         description="The username the plant was entered by",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="inactive_comment",
     *         in="args",
     *         description="The Plant's inactive comment",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="inactive_date",
     *         in="args",
     *         description="The Plant's inactive date",
     *         required=false,
     *         type="date",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="size",
     *         in="args",
     *         description="The Plant's size",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="value",
     *         in="args",
     *         description="The Plant's value",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="parent_one",
     *         in="args",
     *         description="The Plant's parent one",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="parent_two",
     *         in="args",
     *         description="The Plant's parent two",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="grex_status",
     *         in="args",
     *         description="The Plant's grex status",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="hybrid_status",
     *         in="args",
     *         description="The Plant's hybrid status",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="hybrid_comment",
     *         in="args",
     *         description="The Plant's hybrid comment",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="origin_comment",
     *         in="args",
     *         description="The Plant's origin comment",
     *         required=false,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="location_id",
     *         in="args",
     *         description="The Plant's location id",
     *         required=false,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="special_collections_id",
     *         in="args",
     *         description="The Plant's special collections id",
     *         required=false,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="dead",
     *         in="args",
     *         description="The Plant's dead",
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
    $app->put('', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::update($body);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
