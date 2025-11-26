<?php

namespace Router;

use Response;

class Router
{
    private array $routes = [];

    public function loadRoutes(string $folder): void
    {
        foreach (glob($folder . "/*.php") as $routeFile) {
            require $routeFile;
        }
    }

    public function register(string $method, string $path, callable $callback)
    {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path"   => $path,
            "action" => $callback
        ];
    }

    public function handle()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER["REQUEST_URI"], '?');

        foreach ($this->routes as $route) {
            if ($method === $route["method"] && $uri === "/api" . $route["path"]) {
                return call_user_func($route["action"]);
            }
        }

        Response::json(["error" => "Route not found"], 404);
    }
}
