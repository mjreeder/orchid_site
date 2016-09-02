<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Photos;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/photos', function () use ($app) {

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
   });
});