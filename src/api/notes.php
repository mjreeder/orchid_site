<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Notes;

$app->group('/api', function () use ($app){
   $app->group('/notes', function() use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */
       /**
        * @SWG\Get(
        *     path="/notes",
        *     summary="Get all the notes for all the plants",
        *     description="All the general note information for all the plants",
        *     tags={"Notes"},
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
        *     path="/notes/plant_id/{plant_id}",
        *     summary="Get all the notes for a specific plant_id",
        *     description="All the general note information for that specific plant_id",
        *     tags={"Notes"},
        *     @SWG\Parameter(ref="#/parameters/plant_id"),
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This is the first note for 3rd plant_id.",
        *           timestamp="2016-09-08",
        *     ),
        * )
        */
       $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
          $notes = Notes::getByPlantID($args['plant_id']);
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/notes/create",
        *     summary="create new general note for a specific plant_id",
        *     description="need a plant_id, messsage, timestamp",
        *     tags={"Notes"},
        *     @SWG\Parameter(ref="#/parameters/plant_id"),
        *     @SWG\Parameter(
        *         name="note",
        *         in="args",
        *         description="note text",
        *         required=true,
        *         type="string",
        *         format=""
        *     ),
        *     @SWG\Parameter(
        *         name="timestamp",
        *         in="args",
        *         description="Timestamp for note",
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
       $app->post('/create', function($request, $response, $args) use ($app){
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
        *     path="/notes/update",
        *     summary="update the general note for  plant_id",
        *     description="needs a plant_id, score, and timestamp to update",
        *     tags={"Notes"},
        *     @SWG\Parameter(
        *           id="3",
        *         plant_id="4",
        *         timestamp="2016-09-03",
        *          note="This is the new updated comment for the 4th plant_id",
        *
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
