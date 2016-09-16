<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Tag;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/tag', function () use ($app){
       /* ========================================================== *
        * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/tag",
        *     summary="Get all tag information for all the plants",
        *     description="All the tags information for all the plants",
        *     tags={"Country"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This plants needs help",
        *           active="1",
        *
        *     ),
        * )
        */
       $app->get('', function($request, $response, $args) use ($app){
          $tag = Tag::getAll();
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));
       });

       /**
        * @SWG\Get(
        *     path="/tag",
        *     summary="Get all tag information for all the active tags",
        *     description="All the tags information for all the plants that are active",
        *     tags={"Country"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This plant still needs help",
        *           active="1",
        *
        *     ),
        * )
        */
       $app->get('/active', function($request, $response, $args) use ($app){
           $tag = Tag::getAllActive();
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));
       });

       /**
        * @SWG\Get(
        *     path="/tag/plant_id/{plant_id}",
        *     summary="Get all tag information for one specific plant_id",
        *     description="All the tags information for one plant_id",
        *     tags={"Country"},
        *     @SWG\Response(
        *         response=200,
        *           id="2",
        *           plant_id="3",
        *           note="This plant still needs help",
        *           active="1",
        *
        *     ),
        * )
        */
       $app->get('/plant_id/{plant_id}', function($request, $response, $args){
           $tag = Tag::getByPlantId($args['plant_id']);
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));
       });
       /* ========================================================== *
        * POST
        * ========================================================== */

       /**
        * @SWG\POST(
        *     path="/tag/create",
        *     summary="create new tag for a specific plant_id",
        *     description="no plant_id can be created again",
        *     tags={"Tag"},
        *     @SWG\Parameter(
        *         plant_id="5",
        *         note="this is the note for the specific plant_id"
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="4",
        *         plant_id="5",
        *         note="this is the note for the specific plant_id,
        *           active="1"
        *     ),
        * )
        */
       $app->post('/create',function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $tag = Tag::createTag($body);
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));

       });


       /* ========================================================== *
        * PUT
        * ========================================================== */

       /**
        * @SWG\PUT(
        *     path="/tag/update",
        *     summary="update the tag info for a plant_id",
        *     description="needs a plant_id and note",
        *     tags={"Tag"},
        *     @SWG\Parameter(
        *         plant_id="4",
        *         note="Hello. This is the new note",
        *
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         plant_id="4",
        *         note="This is the new note",
        *           active="1"
        *     ),
        * )
        */
       $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateTag = Tag::updateTag($body);
           $output = new Response($updateTag);
           $response->getBody()->write(json_encode($output));

       });

       /**
        * @SWG\PUT(
        *     path="/tag/active",
        *     summary="update the and turn it on",
        *     description="turn on the active tag",
        *     tags={"Tag"},
        *     @SWG\Parameter(
        *         plant_id="4",
        *
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         plant_id="4",
        *         note="This is the new note",
        *         active="1"
        *     ),
        * )
        */
       $app->put('/active', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateTag = Tag::activeTag($body);
           $output = new Response($updateTag);
           $response->getBody()->write(json_encode($output));

       });

       /**
        * @SWG\PUT(
        *     path="/tag/deactive",
        *     summary="update the and turn it off",
        *     description="turn off the active tag for that plant_id",
        *     tags={"Tag"},
        *     @SWG\Parameter(
        *         plant_id="4",
        *
        *     ),
        *     @SWG\Response(
        *         response=200,
        *         id="3",
        *         plant_id="4",
        *         note="This is the new note",
        *         active="0"
        *     ),
        * )
        */
       $app->put('/deactive', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateTag = Tag::deactiveTag($body);
           $output = new Response($updateTag);
           $response->getBody()->write(json_encode($output));

       });





       /* ========================================================== *
        * DELETE
        * ========================================================== */


   });
});