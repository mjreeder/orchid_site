<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
use orchid_site\src\Model\Classification;

require_once '../utilities/response.php';

$app->group('/api', function () use ($app) {
  $app->group('/classification', function () use ($app) {
    /*
     * @SWG\Get(
     *     path="/classification",
     *     summary="Get All",
     *     description="get all plant classifications",
     *     tags={"classification"},
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
      $classifications = Classification::getAll();
      $output = new Response($classifications);
      $response->getBody()->write(json_encode($output));
    });

    /*
     * @SWG\Get(
     *     path="/classification/{id}",
     *     summary="Get by id",
     *     description="get a classification by id",
     *     tags={"classification"},
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
    $app->get('/{id}', function ($request, $response, $args) use ($app) {
      $classification = Classification::getByID($args['id']);
      $output = new Response($classification);
      $response->getBody()->write(json_encode($output));
    });

    /**
     * @SWG\Post(
     *     path="/classification",
     *     summary="create new classification",
     *     description="create a new plant classification",
     *     tags={"classification"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="The classification name",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="rank",
     *         in="body",
     *         description="The classification rank in the hierarchy",
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
      $classification = Classification::createClassification($body);
      $output = new Response($classification);
      $response->getBody()->write(json_encode($output));
    });

    /**
     * @SWG\Put(
     *     path="/classification/update/id",
     *     summary="edit a classification",
     *     description="edit a classification by a given classification id",
     *     tags={"classification"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="The classification name",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="rank",
     *         in="body",
     *         description="The classification rank in the hierarchy",
     *         required=true,
     *         type="string",
     *         format=""
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="args",
     *         description="The classification id",
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
    $app->put('/update/{id}', function ($request, $response, $args) use ($app) {
      $body = $request->getParsedBody();
      $plant = Classification::editClassification($body, $args["id"]);
      $output = new Response($plant);
      $response->getBody()->write(json_encode($output));
    });

  });
});
