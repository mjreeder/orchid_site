<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Potting;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/potting', function () use ($app){
     global $validate_admin;

       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/potting",
        *     summary="Get all the potting dates for all plants",
        *     description="All the potting information for all the plants",
        *     tags={"Potting"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           timestamp="2016-09-06",
        *
        *     ),
        * )
        */
       $app->get('', function($request, $response, $args) use ($app){
          $potting = Potting::getAll();
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       /**
        * @SWG\Get(
        *     path="/potting/plant_id/{plant_id}",
        *     summary="Get all the potting dates for one plant by plant_id",
        *     description="All the potting information by a plant_id",
        *     tags={"Potting"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           timestamp="2016-09-06",
        *     ),
        * )
        */
       $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
           $page = 1;
           $body = $request->getParsedBody();
           if(isset($body['page'])){
               $page = $body['page'];
           }
          $potting = Potting::getByPlantID($args['plant_id'], $page);
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/potting/create",
        *     summary="create new potting date for a specific plant_id",
        *     description="need a plant_id & timestamp",
        *     tags={"Potting"},
        *     @SWG\Parameter(
        *         plant_id="5",
        *         timestamp="2016-09-02"
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
        *         id="4",
        *         plant_id="5",
        *         timestamp="2016-09-02"
        *     ),
        * )
        */
       $app->post('/create', function($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $potting = Potting::createPotting($body);
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       })->add($validate_admin);


       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/potting/update",
        *     summary="update the potting info of a plant_id",
        *     description="needs a plant_id and new timestamp",
        *     tags={"Potting"},
        *     @SWG\Parameter(
        *           id="3",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *
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
        *         id="3",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *         note="Update comment to the pest"
        *     ),
        * )
        */
       $app->put('/update', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $potting = Potting::updatePotting($body);
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       })->add($validate_admin);


       /* ========================================================== *
        * DELETE
        * ========================================================== */
   });
});
