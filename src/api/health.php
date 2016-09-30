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
         *     summary="Get All health information for all the plants",
         *     description="All the health information for all the plants",
         *     tags={"Country"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *           score="poor",
         *
         *     ),
         * )
         */
        $app->get('', function ($request, $response, $args) use ($app){
           $health = Health::getAll();
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /**
         * @SWG\Get(
         *     path="/health/{id}",
         *     summary="Get the single health information for one instance by id",
         *     description="NO PLANT ID; just a single health record by id",
         *     tags={"Country"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *           score="poor",
         *
         *     ),
         * )
         */
        $app->get('/{id}', function($request, $response, $args) use ($app){
           $health = Health::getById($args['id']);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /**
         * @SWG\Get(
         *     path="/health/plant_id/{plant_id}",
         *     summary="Get the single health information for every plant_id",
         *     description="All the health scores for the plant_id",
         *     tags={"Country"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *           score="poor",
         *
         *     ),
         * )
         */
        $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $health = Health::getByPlantID($args['plant_id']);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /* ========================================================== *
         * POST
         * ========================================================== */

        /**
         * @SWG\POST(
         *     path="/health/create",
         *     summary="create new health score for a specific plant_id",
         *     description="need a plant_id and a start_date; no end date",
         *     tags={"Bloom"},
         *     @SWG\Parameter(
         *         plant_id="5",
         *         timestamp="2016-09-02",
         *         score="Fair, Good, Poor"
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="4",
         *         plant_id="5",
         *         timestamp="2016-09-04",
         *         score="Fair, Good, Poor"
         *     ),
         * )
         */
        $app->post('/create', function ($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $health = Health::createHealth($body);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /* ========================================================== *
         * PUT
        * ========================================================== */

        /**
         * @SWG\PUT(
         *     path="/health/update",
         *     summary="update the health score of a plant_id",
         *     description="needs a plant_id, score, timestamp, id to update",
         *     tags={"Bloom"},
         *     @SWG\Parameter(
         *           id="3",
         *         plant_id="4",
         *         timestamp="2016-09-03",
         *          score="Fair, Good, Poor",
         *
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="4",
         *         timestamp="2016-09-03",
         *         score="Fair, Good, Poor"
         *     ),
         * )
         */
        $app->put('/update', function ($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $health  = Health::updateHealth($body);
            $output = new Response($health);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /* ========================================================== *
        * DELETE
         * ========================================================== */
    });
});