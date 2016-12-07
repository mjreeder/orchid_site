<?php

error_reporting(E_ALL);
ini_set("display_errors", true);
require_once "../utilities/Tamarin/Tamarin.php";
require_once "../utilities/response.php";

$app->group('/api', function () use ($app){
    $app->group('/email', function() use ($app) {


        $app->post('/create', function ($request, $response, $args) use ($app){
            $body = $request->getParsedBody();
            $tamarin = new \Tamarin("qt3k_nciae4dtfgvykoq");

            $message = [
                'html' => $body['comment'],
                'subject' => $body['subject'],
                'from_email' => $body['from_email'],
                'from_name' => $body['from_name'],
                'to' => $body['to']
            ];
//            $tamarin->messages->send($message);

        });

        /* ========================================================== *
         * PUT
         * ========================================================== */


    });
});

?>
