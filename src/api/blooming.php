<?php


error_reporting(E_ALL);
ini-set("displays_errors", true);
use orchid_site\src\Model\Blooming;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
   $app->group('/blooming', function () use ($app){

       /* ========================================================== *
         * GET
        * ========================================================== */

       $app->get('', function ($requst, $response, $args) use ($app){

       });

       /* ========================================================== *
         * POST
        * ========================================================== */

       $app->post('', function ($requst, $response, $args) use ($app){

       });

       /* ========================================================== *
         * PUT
        * ========================================================== */

       $app->put('', function ($requst, $response, $args) use ($app){

       });

       /* ========================================================== *
         * DELETE
        * ========================================================== */
   });
});
