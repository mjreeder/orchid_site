<?php
error_reporting( E_ALL);
ini_set("display_errors", true);
require_once "../utilities/response.php";
use orchid_site\src\Model\Classification_link;

$app->group('/api', function () use ($app) {
  $app->group('/classification_link', function () use ($app) {
    global $validate_admin;
    /**
     * @SWG\Post(
     *     path="/classification_link",
     *     summary="create",
     *     description="create a classification link between a plant and a class",
     *     tags={"classification_link"},
     *     @SWG\Parameter(
     *         name="plant_id",
     *         in="body",
     *         description="The plant id",
     *         required=true,
     *         type="int",
     *         format="int64"
     *     ),
     *     @SWG\Parameter(
     *         name="class_id",
     *         in="body",
     *         description="The scientific class name of the plant",
     *         required=true,
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
    $app->post('', function($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $classificationLink = Classification_link::createClassificationLink($body);
      $output = new Response($classificationLink);
      $response->getBody()->write(json_encode($output));
    })->add($validate_admin);

    /**
     * @SWG\Get(
     *     path="/classification_link/plant/{id}",
     *     summary="get plant by classification id",
     *     description="get plant by classification id",
     *     tags={"classification_link"},
     *     @SWG\Parameter(
     *         name="class_id",
     *         in="body",
     *         description="The scientific class id",
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
    $app->get('/plant/{id}', function($request, $response, $args) use ($app) {
      $plant = Classification_link::getPlantsByScientificClassId($args['id']);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

    /**
     * @SWG\Get(
     *     path="/plant_hierarchy/{id}",
     *     summary="get plant hierarchy",
     *     description="get plant by classification id",
     *     tags={"classification_link"},
     *     @SWG\Parameter(ref="#/parameters/plant_id"),
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
    $app->get('/plant_hierarchy/{id}', function($request, $response, $args) use ($app) {
      $plantHierarchy = Classification_link::getPlantHierarchy($args['id']);
      $output = new Response($plantHierarchy);
      $response->getBody()->write(json_encode($output));
    });







  });
});
