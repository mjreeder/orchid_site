<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Plant_Country_Link;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/plant_country_link', function() use ($app){
      global $validate_admin;

        /* ========================================================== *
         * GET
         * ========================================================== */

        $app->get('', function($request, $response, $args) use ($app){
            $countries = Plant_Country_Link::getAll();
            $output = new Response($countries);
            $response->getBody()->write(json_encode($output));
        });

        $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
            $countries = Plant_Country_Link::getByPlantID($args['plant_id']);
            $output = new Response($countries);
            $response->getBody()->write(json_encode($output));
        });


        /* ========================================================== *
        * POST
        * ========================================================== */

        $app->post('/create', function($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $potting = Plant_Country_Link::createLink($body);
            $output = new Response($potting);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);


        /* ========================================================== *
        * PUT
        * ========================================================== */

        $app->put('/update', function($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $potting = Plant_Country_Link::updatePlantCountryLink($body);
            $output = new Response($potting);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);

        /* ========================================================== *
        * DELETE
        * ========================================================== */

        $app->put('/delete', function($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $potting = Plant_Country_Link::deletePlantCountryRelationship($body);
            $output = new Response($potting);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);


    });
});
