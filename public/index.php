<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$host = strtolower($_SERVER['HTTP_HOST'] ?? 'unknown');

$envMap = [
    'development.gouden-draak.test' => '.env.development',
    'testing.gouden-draak.test' => '.env.testing',
    'acceptance.gouden-draak.test' => '.env.acceptance',
    'production.gouden-draak.test' => '.env.production',
];

$envFile = $envMap[$host] ?? '.env';

$app->useEnvironmentPath(__DIR__ . '/../');
$app->loadEnvironmentFrom($envFile);

$app->handleRequest(Request::capture());
