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

       $app->get('', function($request, $response, $args) use ($app){
          $tag = Tag::getAll();
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));
       });

       $app->get('/plant_id/{plant_id}', function($request, $response, $args){
           $tag = Tag::getByPlantId($args['plant_id']);
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));
       });
       /* ========================================================== *
        * POST
        * ========================================================== */
       $app->post('/create',function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $tag = Tag::createTag($body);
           $output = new Response($tag);
           $response->getBody()->write(json_encode($output));

       });


       /* ========================================================== *
        * PUT
        * ========================================================== */

       $app->put('/update', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateTag = Tag::updateTag($body);
           $output = new Response($updateTag);
           $response->getBody()->write(json_encode($output));

       });

       $app->put('/active', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $updateTag = Tag::activeTag($body);
           $output = new Response($updateTag);
           $response->getBody()->write(json_encode($output));

       });

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