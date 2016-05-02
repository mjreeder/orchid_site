<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/api/plants/plants.php';

//Register mcrypt_module_close

//Register Models
require __DIR__ . '/../src/Model/Plants.php';
require __DIR__ . '/../src/Model/PlantClass.php';
require __DIR__ . '/../src/Model/Genus.php';
require __DIR__ . '/../src/Model/PestControl.php';
require __DIR__ . '/../src/Model/PlantStatus.php';
require __DIR__ . '/../src/Model/Potting.php';
require __DIR__ . '/../src/Model/species.php';
require __DIR__ . '/../src/Model/Subtribe.php';
require __DIR__ . '/../src/Model/Tribe.php';
require __DIR__ . '/../src/Model/Variety.php';


// Run app
$app->run();
