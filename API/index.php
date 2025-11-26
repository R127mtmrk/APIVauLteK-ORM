<?php
require __DIR__ . '/bootstrap.php';

use Router\Router;

$router = new Router();
$router->loadRoutes(__DIR__ . '/routes');
$router->handle();
