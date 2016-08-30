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
require __DIR__ . '/../src/api/area.php';
require __DIR__ . '/../src/api/bloom.php';
require __DIR__ . '/../src/api/family.php';
require __DIR__ . '/../src/api/genus.php';
require __DIR__ . '/../src/api/health.php';
require __DIR__ . '/../src/api/pest_control.php';
require __DIR__ . '/../src/api/photos.php';
require __DIR__ . '/../src/api/phylum.php';
require __DIR__ . '/../src/api/plant_status.php';
require __DIR__ . '/../src/api/plants.php';
require __DIR__ . '/../src/api/potting.php';
require __DIR__ . '/../src/api/species.php';
require __DIR__ . '/../src/api/subtribe.php';
require __DIR__ . '/../src/api/users.php';
require __DIR__ . '/../src/api/variety.php';

//Register Models
require __DIR__ . '/../src/Model/Area.php';
require __DIR__ . '/../src/Model/Bloom.php';
require __DIR__ . '/../src/Model/Family.php';
require __DIR__ . '/../src/Model/Health.php';
require __DIR__ . '/../src/Model/PestControl.php';
require __DIR__ . '/../src/Model/Photos.php';
require __DIR__ . '/../src/Model/Phylum.php';
require __DIR__ . '/../src/Model/Plants.php';
require __DIR__ . '/../src/Model/PlantClass.php';
require __DIR__ . '/../src/Model/Genus.php';
require __DIR__ . '/../src/Model/PestControl.php';
require __DIR__ . '/../src/Model/PlantStatus.php';
require __DIR__ . '/../src/Model/Potting.php';
require __DIR__ . '/../src/Model/Species.php';
require __DIR__ . '/../src/Model/Subtribe.php';
require __DIR__ . '/../src/Model/Tribe.php';
require __DIR__ . '/../src/Model/Variety.php';


// Run app
$app->run();
