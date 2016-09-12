<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Split;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/split', function() use ($app){
        /* ========================================================== *
         * GET
         * ========================================================== */

        //GET ALL SPLITS
        $app->get('', function($request, $response, $args) use ($app){
            $split = Split::getAll();
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        //GET ALL SPLITS PER PLANT_ID
        $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $split = Split::getByPlantID($args['plant_id']);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */

        $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

            $split = Split::createSplit($body);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
         * ========================================================== */

        $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

            $split = Split::updateSplit($body);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});