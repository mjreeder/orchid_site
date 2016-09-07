<?php

require("vendor/autoload.php");
$swagger = \Swagger\scan(['./src','./public']);
header('Content-Type: application/json');
echo $swagger;
