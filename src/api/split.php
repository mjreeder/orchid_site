<?php
error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Split;
use orchid_site\src\Model\Plants;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/split', function() use ($app){
      global $validate_admin;
        /* ========================================================== *
         * GET
         * ========================================================== */

        /**
         * @SWG\Get(
         *     path="/split",
         *     summary="Get all the splits for all plants",
         *     description="All the splits information for all the plants",
         *     tags={"Splitting"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *           recipient="Sam Smith",
         *           note="This is the note for the recipient"
         *
         *     ),
         * )
         */
        $app->get('', function($request, $response, $args) use ($app){
            $split = Split::getAll();
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        /**
         * @SWG\Get(
         *     path="/split/plant_id/{plant_id}",
         *     summary="Get all the splits for one specific plant_id",
         *     description="All the splits information with one plant_id",
         *     tags={"Splitting"},
         *     @SWG\Response(
         *         response=200,
         *           id="2",
         *           plant_id="3",
         *           timestamp="2016-09-06",
         *           recipient="Sam Smith",
         *           note="This is the note for the recipient"
         *
         *     ),
         * )
         */
        $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $split = Split::getByPlantID($args['plant_id']);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */

        /**
         * @SWG\POST(
         *     path="/split/create",
         *     summary="create new split for a specific plant_id",
         *     description="need a plant_id & timestamp & recipient & note",
         *     tags={"Splitting"},
         *     @SWG\Parameter(
         *         plant_id="5",
         *         timestamp="2016-09-02",
         *          recipient="Sam Jones",
         *          note="hello",
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
         *         timestamp="2016-09-02",
         *          recipient="Sam Jones",
         *          note="hello"
         *     ),
         * )
         */
        $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

            $split = Split::createSplit($body);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);

        /* ========================================================== *
         * PUT
         * ========================================================== */

        /**
         * @SWG\PUT(
         *     path="/split/update",
         *     summary="update the split info of a plant_id",
         *     description="needs a id; could update plant_id, timestamp, note, ",
         *     tags={"Splitting"},
         *     @SWG\Parameter(
         *           id="3",
         *         plant_id="4",
         *         timestamp="2016-09-03",
         *          note="ads",
         *          recipient="Same Jones"
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
         *         timestamp="2016-09-03",
         *         note="Update comment to the pest",
         *          recipient="Sam Jones"
         *     ),
         * )
         */
        $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();

            $split = Split::updateSplit($body);
            $output = new Response($split);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);

        $app->put('/add_letter/{plant_id}', function ($request, $response, $args) use ($app){
            $id = $args['plant_id'];
            $oldPlant = Split::addLetter($id, true);
            $newPlant = Plants::copy($id);
            $newPlant = Split::addLetter($newPlant->id);
            $output = new Response($newPlant);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);

        $app->put('/donation/{plant_id}', function($request, $response, $args) use ($app){
            $id = $args['plant_id'];
            $oldPlant = Split::addLetter($id, true);
            $output = new Response($oldPlant);
            $response->getBody()->write(json_encode($output));
        })->add($validate_admin);

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});
