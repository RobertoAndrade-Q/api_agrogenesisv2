<?php

namespace App\Routes;

class Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function direct(string $method, string $uri, $connection)
    {
        $methodRoutes = $this->routes[$method] ?? [];

        foreach ($methodRoutes as $route => $handler) {
            $pattern = $this->createPattern($route);

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Elimina el primer elemento, que es el URI completo
                return $this->callHandler($handler, $matches, $connection);
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Ruta no encontrada']);
        exit;
    }

    private function createPattern(string $route): string
    {
        // Reemplaza (:num) con una expresión regular para números
        $pattern = preg_replace('/\(:num\)/', '(\d+)', $route);
        // Añade delimitadores de inicio y fin
        return '#^' . $pattern . '$#';
    }

    private function callHandler(array $handler, array $params, $connection)
    {
        [$controllerClass, $method] = $handler;
        $controller = new $controllerClass($connection);

        return call_user_func_array([$controller, $method], $params);
    }
}
