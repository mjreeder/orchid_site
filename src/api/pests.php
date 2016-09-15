<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Pests;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
   $app->group('/pest', function () use ($app) {

       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/pest",
        *     summary="Get All pest information for all the plants",
        *     description="All the pest information for all the plants",
        *     tags={"Pests"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           timestamp="2016-09-06",
        *           note="The pests are everywhere",
        *
        *     ),
        * )
        */
       $app->get('', function ($request, $response, $args) use ($app){
           $pest_control = Pests::getAll();
            $output = new Response($pest_control);
            $response->getBody()->write(json_encode($output));
        });

       /**
        * @SWG\Get(
        *     path="/pest/plant_id/{plant_id}",
        *     summary="Get All pest information a specific plant_id",
        *     description="All the pest information for 1 plant_id",
        *     tags={"Pests"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           timestamp="2016-09-06",
        *           note="The pests are everywhere",
        *
        *     ),
        * )
        */
       $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
          $pest_control = Pests::getByPlantID($args['plant_id']);
           $output = new Response($pest_control);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/pest/create",
        *     summary="create new pest information for a specific plant_id",
        *     description="need a plant_id; the note is not needed but optional",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *         plant_id="5",
        *         timestamp="2016-09-02",
        *         note="Help... There are pests everywhere"
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="4",
        *         plant_id="5",
        *         timestamp="2016-09-02",
        *         score="Help.. There are pests everywhere"
        *     ),
        * )
        */
       $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $pest_control = Pests::createPestControl($body);
           $output = new Response($pest_control);
           $response->getBody()->write(json_encode($output));
       });


       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/pest/update",
        *     summary="update the pest info of a plant_id",
        *     description="needs a plant_id, note, timestamp, id to update",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *           id="3",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *          note="Update comment to the pest",
        *
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *         note="Update comment to the pest"
        *     ),
        * )
        */
       $app->put('/update', function ($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $pest = Pests::updatePest($body);
           $output = new Response($pest);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * DELETE
        * ========================================================== */
    });
});