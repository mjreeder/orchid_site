<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 10/1/16
 * Time: 8:37 PM
 */

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Health_Comment;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/health_comment', function() use ($app) {

        /* ========================================================== *
         * GET
         * ========================================================== */

        /**
         * @SWG\Get(
         *     path="/health_comment",
         *     summary="Get all health comments for every plant",
         *     description="Simple Get All method",
         *     tags={"Health"},
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="2",
         *         note="This is the first note for the 2nd plant_id",
         *         timestamp="2016-09-14",
         *      ),
         * )
         */
        $app->get('', function($request, $response, $args) use ($app){
            $bloom = Health_Comment::getAll();
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /**
         * @SWG\Get(
         *     path="/health_comment/plant_id/{plant_id}",
         *     summary="Get all the health comments for a specfic plant_id ",
         *     description="Need the plant_id to get everything",
         *     tags={"Health"},
         *     @SWG\Parameter(
         *       plant_id="2"
         *     ),
         *
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="2",
         *         note="This is the first note for the 2nd plant_id",
         *         timestamp="2016-09-14",
         *      ),
         * )
         */
        $app->get('/plant_id/{plant_id}', function($request, $response, $args) use ($app){
            $bloom = Health_Comment::getByPlantID($args["plant_id"]);
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */


        /**
         * @SWG\POST(
         *     path="/health_comment/create",
         *     summary="create health comment",
         *     description="create health comment",
         *     tags={"Health"},
         *     @SWG\Parameter(
         *         plant_id="2",
         *         note="This is the new comment",
         *          timestamp="1999-09-10"
         *
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="2",
         *         note="This is the new comment",
         *         timestamp="1999-09-10"
         *     ),
         * )
         */
        $app->post('/create', function ($request, $response, $args) use ($app){
            $body = $request->getParsedBody();

            $bloom = Health_Comment::createHealth($body);
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
         * ========================================================== */

        /**
         * @SWG\PUT(
         *     path="/health_comment/update",
         *     summary="update health comment",
         *     description="need the id to update the informaiton",
         *     tags={"Health"},
         *     @SWG\Parameter(
         *           id="3",
         *         plant_id="4",
         *         note="This is the updated comment for the 2nd plant_id",
         *          timestamp="2016-09-16"
         *
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         id="3",
         *         plant_id="4",
         *         note="This is the updated comment for the 2nd plant_id",
         *         timestamp="2016-09-16"
         *     ),
         * )
         */
        $app->put('/update', function ($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $updateBloom = Health_Comment::updateHealth($body);
            $output = new Response($updateBloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});

?>
