<?php
$app->group('/api', function () use ($app) {
  $app->group('/plants', function () use ($app) {
    $resource = '/plants';

    // GET ALL PLANTS
    $app->get('', function() use ($app) {
      var_dump("derp");
    });

    // GET PLANT BY ID
    $app->get($resource . "/:id", function ($id) use ($app) {

    });



  });

});
