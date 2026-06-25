<?php
require __DIR__ . '/vendor/autoload.php';

$openapi = \OpenApi\scan(__DIR__ . '/app/Http/Controllers/Api');
echo $openapi->toJson();
