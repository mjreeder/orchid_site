<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Health;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
    $app->group('/health', function () use ($app) {

        /* ========================================================== *
         * GET
        * ========================================================== */

        /**
         * @SWG\Get(
         *     path="/health",
         *     summary="Get all the health information for the plants",
         *     description="Brings back all the health information",
         *     tags={"Health"},
         *     @SWG\Response(
         *         response=200,
         *         id="2",
         *          "plant_id"="2",
         *          "note
         *     ),
         *     @SWG\Response(
         *         response="default",
         *         description="unexpected error",
         *         @SWG\Schema(
         *             ref="#/definitions/Error"
         *         )
         *     )
         * )
         */
        $app->get('', function ($requst, $response, $args) use ($app){
           $health = Health::getAll();
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
        });

        //GET SINGLE ID
        $app->get('/{id}', function($request, $response, $args) use ($app){
           $health = Health::getById($args['id']);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
        });

        //GET BY PLANT ID
        $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $health = Health::getByPlantID($args['plant_id']);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */

        $app->post('', function ($request, $response, $args) use ($app){
           $body = [
             'plant_id' => 3,
               'score' => 3

           ];

            $health = Health::createHealth($body);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
        * ========================================================== */

        $app->put('/{id}', function ($request, $response, $args) use ($app){
            $body = [
              'plant_id' => 4,
                'score' => 3
            ];

            $health  = Health::fixHealth($body, $args['id']);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
        * DELETE
         * ========================================================== */
    });
});