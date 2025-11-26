<?php

use Router\Router;

global $router;

$router->register("GET", "/users", [UsersController::class, "index"]);
$router->register("GET", "/users/show", [UsersController::class, "show"]);
$router->register("POST", "/users", [UsersController::class, "store"]);
$router->register("PUT", "/users", [UsersController::class, "update"]);
$router->register("DELETE", "/users", [UsersController::class, "delete"]);
