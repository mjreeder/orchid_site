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

       //GET ALL THE LOCATIONS
       $app->get('', function ($request, $response, $args) use ($app){
           $locations = Location::getAll();
           $output = new Response($locations);
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
