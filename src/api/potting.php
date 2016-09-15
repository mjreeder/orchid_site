<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Potting;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/potting', function () use ($app){

       /* ========================================================== *
        * GET
        * ========================================================== */

       $app->get('', function($request, $response, $args) use ($app){
          $potting = Potting::getAll();
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
          $potting = Potting::getByPlantID($args['plant_id']);
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       $app->post('/create', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $potting = Potting::createPotting($body);
           $output = new Response($potting);
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
       $app->post('/update', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $potting = Potting::
       });


       /* ========================================================== *
        * DELETE
        * ========================================================== */
   });
});