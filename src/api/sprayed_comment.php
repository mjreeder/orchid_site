<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 10/1/16
 * Time: 8:35 PM
 */

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Sprayed_Comment;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/sprayed_comment', function() use ($app) {

        /* ========================================================== *
         * GET
         * ========================================================== */

        /**
         * @SWG\Get(
         *     path="/sprayed_comment",
         *     summary="Get all sprayed comments for every plant",
         *     description="Simple Get All method",
         *     tags={"Sprayed"},
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
            $bloom = Sprayed_Comment::getAll();
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /**
         * @SWG\Get(
         *     path="/sprayed_comment/plant_id/{plant_id}",
         *     summary="Get all the sprayed comments for a specfic plant_id ",
         *     description="Need the plant_id to get everything",
         *     tags={"Sprayed"},
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
            $bloom = Sprayed_Comment::getByPlantID($args["plant_id"]);
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */


        /**
         * @SWG\POST(
         *     path="/sprayed_comment/create",
         *     summary="create sprayed comment",
         *     description="create sprayed comment",
         *     tags={"Sprayed"},
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

            $bloom = Sprayed_Comment::createSprayed($body);
            $output = new Response($bloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
         * ========================================================== */

        /**
         * @SWG\PUT(
         *     path="/sprayed_comment/update",
         *     summary="update sprayed comment",
         *     description="need the id to update the informaiton",
         *     tags={"Sprayed"},
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
            $updateBloom = Sprayed_Comment::updateSprayed($body);
            $output = new Response($updateBloom);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});

?>
