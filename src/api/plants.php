<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
use orchid_site\src\Model\Plants;

require_once '../utilities/response.php';

$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {

    global $validate_admin;
    /**
    * @SWG\Get(
    *     path="/plants",
    *     summary="Get All",
    *     description="Get all Books",
    *     tags={"Plants"},
    *     @SWG\Response(
    *         response=200,
    *         description="Success",
    *         @SWG\Schema(
    *             ref="#/definitions/ArrayPlantsSuccess"
    *         )
    *     ),
    *     @SWG\Response(
    *         response="default",
    *         description="Error",
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

    $app->get('/table/{id}', function ($request, $response, $args) use ($app){
      $plants = Plants::getPlantsByTable($args['id']);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    $app->get('/aaa/{id}', function ($request, $response, $args) use ($app){
      $plants = Plants::getById2($args['id']);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    /**
    * @SWG\Get(
    *     path="/plants/alpha/{alpha}/{index}",
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
    *     @SWG\Parameter(
    *         name="index",
    *         in="path",
    *         description="The page of plants desired",
    *         required=true,
    *         type="int",
    *         format="int64"
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="Success",
    *         @SWG\Schema(
    *             ref="#/definitions/ArrayPlantsSuccess"
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
    $app->get('/alpha/{alpha}/{index}', function ($request, $response, $args) use ($app) {
      $plants = Plants::getPaginatedPlants($args['alpha'], $args['index']);
      $output = new Response($plants);
      $response->getBody()->write(json_encode($output));
    });

    /**
    * @SWG\Get(
    *     path="/plants/{plant_id}",
    *     summary="Get by id",
    *     description="get plant by id",
    *     tags={"Plants"},
    *     @SWG\Parameter(ref="#/parameters/plant_id"),
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
    $app->get('/{plant_id}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getById($args['id']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /**
    * @SWG\Get(
    *     path="/plants/accession/{accession_number}",
    *     summary="Get by accession number",
    *     description="Get plant by its accession number",
    *     tags={"Plants"},
    *     @SWG\Parameter(ref="#/parameters/accession_number"),
    *     @SWG\Response(
    *         response=200,
    *         description="Success",
    *         @SWG\Schema(
    *              ref="#/definitions/SinglePlantSuccess"
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
    $app->get('/accession/{accession_number}', function ($request, $response, $args) use ($app) {
      $plant = Plants::getByAccessionNumber($args['accession_number']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /**
    * @SWG\Get(
    *     path="/plants/search_all/{searchItem}",
    *     summary="wildcard plant search",
    *     description="Get plant by its accession number",
    *     tags={"Plants"},
    *     @SWG\Parameter(
    *         name="searchItem",
    *         in="args",
    *         description="the attribute to be searched",
    *         required=true,
    *         type="string",
    *         format=""
    *     ),
    *     @SWG\Parameter(
    *         name="index",
    *         in="args",
    *         description="the page index",
    *         required=true,
    *         type="int",
    *         format="int64"
    *     ),
    *     @SWG\Response(
    *         response=200,
    *         description="Success",
    *         @SWG\Schema(
    *             ref="#/definitions/ArrayPlantsSuccess"
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
    $app->get('/search_all/{searchItem}/{index}', function ($request, $response, $args) use ($app) {
      $plant = Plants::wildcardSearch($args['searchItem'], $args['index']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

     /**
     * @SWG\Put(
     *     path="/plants",
     *     summary="Edit plant",
     *     description="Edit the plant given a plant object",
     *     tags={"Plants"},
     *     @SWG\Parameter(ref="#/parameters/plant_id"),
     *     @SWG\Parameter(ref="#parameters/plant_name"),
     *     @SWG\Parameter(ref="#/parameters/accession_number"),
     *     @SWG\Parameter(
     *         name="authority",
     *         in="args",
     *         description="The Plant's authority",
     *         required=false,
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
     *         type="string",
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
     *         type="string",
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

    $app->put('/', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
        $plant = Plants::update($body);
        $output = new Response($plant);
        $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateCritical', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateCritical($body["plant"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateCriticalTable', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateCriticalTable($body['table']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateVarifiedDate', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateVarifiedDate($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);


    $app->put('/updateCulture', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateCulture($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateAccession', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateAccession($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateDescription', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateDescription($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateTaxonmic', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateTaxonmic($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateInactive', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateInactive($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateSinglePhoto', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateSinglePhotos($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/upateHyrbird', function ($request, $response, $formData) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::updateHybrid($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->put('/updateLocation', function($request, $response, $formData) use ($app){
      $body = $request->getParsedBody();
      $plant = Plants::updateLocation($body['plant']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });





     /**
     * @SWG\Delete(
     *     path="/plants/{id}",
     *     summary="delete plant by Id",
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
      $plant = Plants::delete($args['id']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

     /**
     * @SWG\Post(
     *     path="/plants",
     *     summary="create new plant",
     *     description="create new plant",
     *     tags={"Plants"},
     *     @SWG\Parameter(ref="#parameters/plant_name"),
     *     @SWG\Parameter(ref="#/parameters/accession_number"),
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
     *         type="string",
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
     *         type="string",
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
    $app->post('', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::createPlant($body);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    $app->post('/createPlant', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $plant = Plants::createCritical($body);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
