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

       $app->post('/getSimilarPlants', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $photos = Photos::getSimilarPhotos($body);
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       $app->post('/onePhotoCountry/{country}', function ($request, $response, $args) use ($app){
           $photos = Photos::onePhotoCountry($args['country']);
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/onePhotoCollections/{sp}', function ($request, $response, $args) use ($app){
           $photos = Photos::onePhotoCollections($args['sp']);
           $output = new Response($photos);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/onePhotoTribe/{tribe}', function ($request, $response, $args) use ($app){
           $photos = Photos::onePhotoTribe($args['tribe']);
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
