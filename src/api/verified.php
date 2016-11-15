<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
use orchid_site\src\Model\Verified;
require_once "../utilities/response.php";

$app->group('/api', function () use ($app) {
    $app->group('/verified', function () use ($app) {
        global $validate_admin;
        /* ========================================================== *
         * GET
         * ========================================================== */

        $app->get('/plant_id/{plant_id}', function ($request, $response, $args) use ($app) {
            $verified = Verified::getByPlantID($args['plant_id']);
            $output = new Response($verified);
            $response->getBody()->write(json_encode($output));
        });

        $app->get('/last/plant_id/{plant_id}', function ($request, $response, $args) use ($app) {
            $verified = Verified::getLastestVerifiedForPlantID($args['plant_id']);
            $output = new Response($verified);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * POST
         * ========================================================== */

        $app->post('/create', function ($request, $response, $args) use ($app) {
            $body = $request->getParsedBody();
            $createVerified = Verified::createVerification($body);
            $output = new Response($createVerified);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * PUT
         * ========================================================== */

        $app->put('/update', function ($request, $response, $args) use ($app) {
            $body = $request->getParsedBody();
            $updateVerification = Verified::updateVerification($body);
            $output = new Response($updateVerification);
            $response->getBody()->write(json_encode($output));
        });

        /* ========================================================== *
         * DELETE
         * ========================================================== */
    });
});
