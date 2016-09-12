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

       $app->post('', function($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $potting = Potting::createPotting($body);
           $output = new Response($potting);
           $response->getBody()->write(json_encode($output));
       });


       /* ========================================================== *
        * PUT
        * ========================================================== */



       /* ========================================================== *
        * DELETE
        * ========================================================== */
   });
});