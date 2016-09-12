<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Country;

$app->group('/api', function () use ($app){
   $app->group('/notes', function() use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */
       $app->get('', function($request, $response, $args) use ($app){
          $notes = Notes::getAll();
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plant_id/{id}', function($request, $response, $args) use ($app){
          $notes = Notes::getByPlantID($args['id']);
           $output = new Response($notes);
           $response->getBody->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       $app->post('/create', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $notes = Notes::createNote($body);
           $output = new Response($notes);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * PUT
        * ========================================================== */

       $app->put('/fix', function ($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $output = Notes::updateNotes($body);
           $response->getBody->write(json_encode($output));
       });

       /* ========================================================== *
        * DELETE
        * ========================================================== */

   });
});