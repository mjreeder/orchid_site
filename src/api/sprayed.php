<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Sprayed;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/sprayed', function() use ($app){
        /* ========================================================== *
         * GET
         * ========================================================== */

        //GET ALL
        $app->get('', function($request, $response, $args) use ($app){
            $sprayed = Sprayed::getAll();
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
        });

        //GET SINGLE RELATIONSHIP WITH A PLANT
        $app->get('/plant_id/{plant_id}', function($resquest, $response, $args) use ($app){
           $sprayed = Sprayed::getByPlantID($args['plant_id']);
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
        });





        /* ========================================================== *
         * POST
         * ========================================================== */

        $app->post('', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
            $sprayed = Sprayed::createSpray($body);
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
         * ========================================================== */

        $app->put('', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
            $updateSpray = Sprayed::updateSpray($body);
            $output = new Response($updateSpray);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});
?>
