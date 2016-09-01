<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Bloom;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/bloom', function() use ($app) {

       $app->get('', function($request, $response, $args) use ($app){
           $bloom = Bloom::getAll();
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
           $bloom = Bloom::getByPlantID($args["plant_id"]);
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       });
   });
});

?>