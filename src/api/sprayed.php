<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Sprayed;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/sprayed', function() use ($app){
      global $validate_admin;
        /* ========================================================== *
         * GET
         * ========================================================== */

        /**
         * @SWG\Get(
         *     path="/sprayed",
         *     summary="Get All spray information for all the plants",
         *     description="All the spray information for all the plants",
         *     tags={"Sprayed"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *     ),
         * )
         */
        $app->get('', function($request, $response, $args) use ($app){
            $sprayed = Sprayed::getAll();
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        /**
         * @SWG\Get(
         *     path="/sprayed/plant_id/{plant_id}",
         *     summary="Get All spray information for one specific plant_id",
         *     description="All the spray information for the one speicific plant_id",
         *     tags={"Sprayed"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *     ),
         * )
         */
        $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
            $page = 1;
           $sprayed = Sprayed::getByPlantID($args['plant_id'], $page);
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        });

        $app->get('/plant_id/{plant_id}/page/{page}', function($request, $response, $args) use ($app){
            $sprayed = Sprayed::getByPlantID($args['plant_id'], $args['page']);
            $output = new Response($sprayed);
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
         *     path="/sprayed/create",
         *     summary="create new sprayed for a specific plant_id",
         *     description="need a plant_id and a timestamp",
         *     tags={"Sprayed"},
         *     @SWG\Parameter(
         *         plant_id="5",
         *         timestamp="2016-09-02"
         *     ),
         *     @SWG\Parameter(
         *         name="session_id",
         *         in="args",
         *         description="admin session id",
         *         required=false,
         *         type="string",
         *         format=""
         *     ),
         *     @SWG\Parameter(
         *         name="session_key",
         *         in="args",
         *         description="admin session key",
         *         required=false,
         *         type="string",
         *         format=""
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="4",
         *         plant_id="5",
         *         timestamp="2016-09-02"
         *     ),
         * )
         */
        $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
            $sprayed = Sprayed::createSpray($body);
            $output = new Response($sprayed);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        })->add($validate_admin);

        /* ========================================================== *
         * PUT
         * ========================================================== */

        /**
         * @SWG\PUT(
         *     path="/sprayed/update",
         *     summary="update the spray of a plant_id",
         *     description="needs a plant_id, time, and id to update",
         *     tags={"Bloom"},
         *     @SWG\Parameter(
         *           id="3",
         *         plant_id="4",
         *         timestamp="2016-09-03",
         *
         *     ),
         *     @SWG\Parameter(
         *         name="session_id",
         *         in="args",
         *         description="admin session id",
         *         required=false,
         *         type="string",
         *         format=""
         *     ),
         *     @SWG\Parameter(
         *         name="session_key",
         *         in="args",
         *         description="admin session key",
         *         required=false,
         *         type="string",
         *         format=""
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="4",
         *         timestamp="2016-09-03"
         *     ),
         * )
         */
        $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
            $updateSpray = Sprayed::updateSpray($body);
            $output = new Response($updateSpray);
            $response->getBody()->write(json_encode($output));
            $formattedResponse = $response->withHeader(
                'Content-type',
                'application/json; charset=utf-8'
            );
            return $formattedResponse;
        })->add($validate_admin);

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});
?>
