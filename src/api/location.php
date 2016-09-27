<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Location;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
   $app->group('/location', function () use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/location",
        *     summary="Get all the locations ",
        *     description="all the different rooms and names in the green house (Display, Cold, Warm)",
        *     tags={"Bloom"},
        *     @SWG\Response(
        *         response=200,
        *         id="1",
        *         room="WWS3",
        *         name="Warm (Warm, Cold, Display)",
        *      ),
        * )
        */
       $app->get('', function ($request, $response, $args) use ($app){
           $locations = Location::getAll();
           $output = new Response($locations);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/{table_id}', function($request, $response, $args) use ($app){
          $location = Location::getTableNameFromID($args['table_id']);
           $output = new Response($location);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/check/{table_name}', function($request, $response, $args) use ($app){
           $location = Location::checkTable($args['table_name']);
           $output = new Response($location);
           $response->getBody()->write(json_encode($output));
       });



       /* ========================================================== *
        * POST
        * ========================================================== */

       /* ========================================================== *
        * PUT
        * ========================================================== */

       /* ========================================================== *
        * DELETE
        * ========================================================== */

   });
});
