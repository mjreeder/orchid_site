<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orhcid_site\src\Model\Country;
require_once "../utilities\response.php";

$app->group('/api', function () use ($app){
   $app->group('/bloom', function() use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */

       $app->get('', function($request, $response, $args) use ($app){
          $countries = Country::getAll();
           $output = new Response($countries);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
       * POST
       * ========================================================== */

       $app->post('/new', function ($request, $response, $args) use ($app){
          $body = $request->getParsedBody();

           $newCountry = Country::createCountry($body);
           $output = new Response($newCountry);
           $response->getBody()->write(json_encode($output));

       });

       /* ========================================================== *
       * PUT
       * ========================================================== */

       $app->put('', function ($request, $response, $args) use ($app){
          $body = $request->getParsedBody();
           $updateCountry = Country::updateCountry($body);
           $output = new Response($updateCountry);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
       * DELETE
       * ========================================================== */

   });
});