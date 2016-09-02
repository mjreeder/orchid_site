<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\PestControl;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
   $app->group('/pest_control', function () use ($app) {

        $app->get('', function ($request, $response, $args) use ($app){
           $pest_control = PestControl::getAll();
            $output = new Response($pest_control);
            $response->getBody()->write(json_encode($output));
        });

       $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
          $pest_control = PestControl::getByPlantID($args['plant_id']);
           $output = new Response($pest_control);
           $response->getBody()->write(json_encode($output));
       });
    });
});