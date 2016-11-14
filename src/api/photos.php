<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Photos;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/photos', function () use ($app) {
     global $validate_admin;

       /* ========================================================== *
        * GET
        * ========================================================== */

       $app->get('',function ($request, $response, $args) use ($app){
         $photos = Photos::getAll();
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
          $photos = Photos::getByPlantID($args['plant_id']);
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/getSimilarPlants/{species_name}', function ($request, $response, $args) use ($app){
           $photos = Photos::getSimilarPhotos($args['species_name']);
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       $app->post('/create', function($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $createPhoto = Photos::createPhoto($body);
           $output = new Response($createPhoto);
           $response->getBody()->write(json_encode($output));
       })->add($validate_admin);

       /* ========================================================== *
        * PUT
        * ========================================================== */

       $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

           $updatePhoto = Photos::updatePhoto($body);
           $output = new Response($updatePhoto);
           $response->getBody()->write(json_encode($output));
       })->add($validate_admin);

       $app->put('/deactive', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

           $updatePhoto = Photos::deactive($body);
           $output = new Response($updatePhoto);
           $response->getBody()->write(json_encode($output));
       })->add($validate_admin);


       /* ========================================================== *
        * DELETE
        * ========================================================== */

   });
});
