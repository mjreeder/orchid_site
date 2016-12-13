<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Special_Collection;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/special_collection', function () use ($app){
     global $validate_admin;

       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/special_collection",
        *     summary="Get all the special collections",
        *     description="Simple Get All method",
        *     tags={"Special Collections"},
        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         name="Speical #1",
        *
        *      ),
        * )
        */
       $app->get('', function($request, $response, $args) use ($app){
           $special_collection = Special_Collection::getAll();
           $output = new Response($special_collection);
           $response->getBody()->write(json_encode($output));
       });

       /**
        * @SWG\Get(
        *     path="/special_collection/id/{id}",
        *     summary="Get all the blooms for a specfic id ",
        *     description="Need the id to get the name",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *       id="2"
        *     ),

        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         name="Speical Collection #3",
        *      ),
        * )
        */
       $app->get('/id/{id}', function($request, $response, $args) use ($app){
           $special_collection = Special_Collection::getByID($args['id']);
           $output = new Response($special_collection);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/name/{name}', function($request, $response, $args) use ($app){
           $special_collection = Special_Collection::getIDFromName($args['name']);
           $output = new Response($special_collection);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/getSpecificCollectionID/{id}', function($request, $response, $args) use ($app){
           $plant = Special_Collection::getSpecificCollectionID($args['id']);
           $output = new Response($plant);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plants/{id}', function($request, $response, $args) use ($app){
           $special_collection = Special_Collection::getPlantsWithSpeicalCollections($args['id']);
           $output = new Response($special_collection);
           $response->getBody()->write(json_encode($output));
       });

       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/special_collection/create",
        *     summary="create new speical collection",
        *     description="create new speical collection",
        *     tags={"Speical Collection"},
        *     @SWG\Parameter(
        *         name="special_collection_345"
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
        *         id="345",
        *         name="special_collection_345"
        *     ),
        * )
        */
       $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $bloom = Special_Collection::createSpecialCollection($body);
           $output = new Response($bloom);
           $response->getBody()->write(json_encode($output));
       })->add($validate_admin);

       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/special_collection/update",
        *     summary="update special collection",
        *     description="need the id and name to update the informaiton",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *           id="3",
        *         name="speical_collection_333"
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
        *         name="name"
        *     ),
        * )
        */
       $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateBloom = Special_Collection::updateSpecialCollection($body);
           $output = new Response($updateBloom);
           $response->getBody()->write(json_encode($output));
       })->add($validate_admin);

       /* ========================================================== *
        * DELETE
        * ========================================================== */

   });
});
