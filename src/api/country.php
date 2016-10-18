<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Country;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/country', function() use ($app){

       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/country",
        *     summary="Get All of the countries in the database",
        *     description="All of the countries that have been stored in the database",
        *     tags={"Country"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           country="Albania",
        *
        *     ),
        * )
        */
       $app->get('', function($request, $response, $args) use ($app){
           $countries = Country::getAll();
           $output = new Response($countries);
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
