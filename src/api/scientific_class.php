<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Notes;

$app->group('/api', function () use ($app){
   $app->group('/scientific_class', function() use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */
       /**
        * @SWG\Get(
        *     path="/scientific_class",
        *     summary="Get all",
        *     description="Get all scientific classes",
        *     tags={"scientificClass"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This is the first note for 3rd plant_id.",
        *           timestamp="2016-09-08",
        *     ),
        * )
        */
       $app->get('', function($request, $response, $args) use ($app){
          $notes = Notes::getAll();
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       /**
        * @SWG\Get(
        *     path="/scientific_class/{id}",
        *     summary="Get all the notes for a specific plant_id",
        *     description="All the general note information for that specific plant_id",
        *     tags={"scientificClass"},
        *     @SWG\Parameter(
        *         name="id",
        *         in="path",
        *         description="The class id",
        *         required=true,
        *         type="int",
        *         format="int64"
        *     ),
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This is the first note for 3rd plant_id.",
        *           timestamp="2016-09-08",
        *     ),
        * )
        */
       $app->get('/{id}', function($request, $response, $args) use ($app){
          $notes = Notes::getByPlantID($args['plant_id']);
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/scientific_class",
        *     summary="create new",
        *     description="create new scientific class",
        *     tags={"scientificClass"},
        *     @SWG\Parameter(ref="#/parameters/plant_id"),
        *     @SWG\Parameter(
        *         name="classification_id",
        *         in="args",
        *         description="classification id",
        *         required=true,
        *         type="int",
        *         format="int64"
        *     ),
        *     @SWG\Parameter(
        *         name="name",
        *         in="args",
        *         description="scientific class name",
        *         required=true,
        *         type="string",
        *         format=""
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="4",
        *         plant_id="5",
        *         timestamp="2016-09-02",
        *         note="I love this plants. Plants are AWESOME!!!!"
        *     ),
        * )
        */
       $app->post('/', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $notes = Notes::createNote($body);
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/scientific_class",
        *     summary="update",
        *     description="update scientific class",
        *     tags={"scientific_class"},
        *     @SWG\Parameter(
        *         name="classification_id",
        *         in="args",
        *         description="classification id",
        *         required=true,
        *         type="int",
        *         format="int64"
        *     ),
        *     @SWG\Parameter(
        *         name="name",
        *         in="args",
        *         description="scientific class name",
        *         required=true,
        *         type="string",
        *         format=""
        *     ),
        *     @SWG\Parameter(
        *         name="id",
        *         in="args",
        *         description="scientific class id",
        *         required=true,
        *         type="int",
        *         format="int64"
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="5",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *         score="This is the new updated comment for the 4th plant_id"
        *     ),
        * )
        */
       $app->put('/update', function ($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $output = Notes::updateNotes($body);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * DELETE
        * ========================================================== */

   });
});
