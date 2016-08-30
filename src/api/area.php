<?php

error_reporting( E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Area;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
    $app->group('/area', function () use ($app) {


        // GET ALL
        $app->get('', function($request, $response, $args) use ($app) {
            $area = Area::getAll();
            $output = new Response($area);
            $response->getBody()->write(json_encode($output));
        });

        $app->get('/{id}', function($request, $response, $args) use ($app) {
            $area = Area::getByID($args["id"]);
            $output = new Response($area);
            $response->getBody()->write(json_encode($output));
        });


    });


});


?>