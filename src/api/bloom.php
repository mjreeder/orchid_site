<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Bloom;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/bloom', function() use ($app) {

       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/bloom",
        *     summary="Get all the blooms for every plant",
        *     description="Simple Get All method",
        *     tags={"Bloom"},
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
           $bloom = Bloom::getAll();
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       });

       /**
        * @SWG\Get(
        *     path="/bloom/plant_id/{plant_id}",
        *     summary="Get all the blooms for a specfic plant_id ",
        *     description="Need the plant_id to get everything",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *       plant_id="2"
        *     ),

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
           $bloom = Bloom::getByPlantID($args["plant_id"]);
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */


       /**
        * @SWG\POST(
        *     path="/blooms/create",
        *     summary="create new bloom",
        *     description="create new bloom",
        *     tags={"Bloom"},
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

           $bloom = Bloom::createBloom($body);
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/blooms/update",
        *     summary="update new bloom",
        *     description="need the id to update the informaiton",
        *     tags={"Bloom"},
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
           $updateBloom = Bloom::updateBloom($body);
           $output = new Response($updateBloom);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * DELETE
        * ========================================================== */
   });
});

?>