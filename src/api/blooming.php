<?php


error_reporting(E_ALL);
ini_set("displays_errors", true);
use orchid_site\src\Model\Blooming;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/blooming', function () use ($app){
      global $validate_admin;
       /* ========================================================== *
         * GET
        * ========================================================== */

       /**
        * @SWG\Get(
        *     path="/blooming",
        *     summary="Get all the blooming information for all the plants",
        *     description="all the informaiton for all the plants",
        *     tags={"Bloom"},
        *     @SWG\Response(
        *         response=200,
        *         id="1",
        *         plant_id="4",
        *         start_date="2016-09-01",
        *         end_date="2016-09-14",
        *      ),
        * )
        */
       $app->get('', function ($request, $response, $args) use ($app){
           $blooming = Blooming::getAll();
            $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       /**
        * @SWG\Get(
        *     path="/blooming/plant_id/{id}",
        *     summary="Get all the blooming information for one specific plant by plant-id",
        *     description="One specifi plant_id",
        *     tags={"Bloom"},
        *     @SWG\Response(
        *         response=200,
        *         id="2",
        *         plant_id="4",
        *         start_date="2016-09-01",
        *         end_date="2016-09-14",
        *      ),
        * )
        */
       $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $page = 1;
           $blooming = Blooming::getByPlantID($args['plant_id'], $page);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       $app->get('/get_all/blooms/plant_id/{plant_id}', function ($request, $response, $args) use ($app){
           $blooming = Blooming::getAllByPlantID($args['plant_id']);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       $app->get('/plant_id/{plant_id}/page/{page}', function ($request, $response, $args) use ($app){
           $blooming = Blooming::getByPlantID($args['plant_id'], $args['page']);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       $app->get('/status/{plant_id}', function ($request, $response, $args) use ($app){
           $blooming = Blooming::getLastestBloom($args['plant_id']);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       });

       $app->get('/graphData/{plant_id}', function ($request, $response, $args) use ($app){
           $blooming = Blooming::calculateData($args['plant_id']);
           $output = new Response($blooming);
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
        *     path="/blooming/create",
        *     summary="create new blooming with a start date ",
        *     description="need a plant_id and a start_date; no end date",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *         plant_id="5",
        *         start_date="2016-09-02"
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
        *         id="100",
        *         plant_id="5",
        *         start_date="2016-09-03",
        *         end_date="0000-00-00"
        *     ),
        * )
        */
       $app->post('/create', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $blooming = Blooming::createBlooming($body);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       })->add($validate_admin);

       $app->post('/createGenericBloom', function ($request, $response, $args) use ($app){
           $body = $request->getParsedBody();
           $blooming = Blooming::createGenericBloom($body);
           $output = new Response($blooming);
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
        *     path="/blooming/update",
        *     summary="update a bloom",
        *     description="need the id to update the informaiton",
        *     tags={"Bloom"},
        *     @SWG\Parameter(
        *           id="3",
        *         plant_id="4",
        *         start_date="2016-09-03",
        *          end_date="2016-09-16"
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
        *         start_date="2016-09-03",
        *         end_date="2016-09-16"
        *     ),
        * )
        */
       $app->put('/update', function ($requst, $response, $args) use ($app){
           $body = $requst->getParsedBody();
           $blooming = Blooming::updateBlooming($body);
           $output = new Response($blooming);
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

       $app->put('/delete', function ($requst, $response, $args) use ($app){
           $body = $requst->getParsedBody();
           $blooming = Blooming::deleteBloom($body);
           $output = new Response($blooming);
           $response->getBody()->write(json_encode($output));
           $formattedResponse = $response->withHeader(
               'Content-type',
               'application/json; charset=utf-8'
           );
           return $formattedResponse;
       })->add($validate_admin);


   });
});
