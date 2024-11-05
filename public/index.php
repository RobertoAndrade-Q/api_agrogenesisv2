<?php

declare(strict_types=1);

// ini_set('display_errors', "On");

// Incluir el autoload de Composer
require __DIR__ . '/../vendor/autoload.php';

// Usar el namespace completo para instanciar el controlador
use App\Controllers\TaskController;
use App\Database\Database;
use App\Controllers\EmpresaController;
use App\Routes\Router;

set_exception_handler([App\ErrorHandler::class, 'handleException']);

// Configuración y creación de la base de datos
$database = new Database("vueltalarga_genesis", "dba", "proyecto2014");
// Obtener la conexión 
$connection = $database->getConnection();
/* 
// Obtener el recurso y el id de la URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $path);

return var_dump($parts);

$resource = $parts[3];
$id = $parts[4] ?? null;

header('Content-Type: application/json');


switch ($resource) {
    case 'tasks':
        // Crear instancia de TaskController y pasar la conexión de la base de datos
        $controller = new TaskController();
        $controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
        break;

    case 'empresas':
        // Crear instancia de EmpresaController y pasar la conexión de la base de datos
        $controller = new EmpresaController($connection);
        $controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
        break;

    default:
        http_response_code(404);
        echo json_encode([
            "msg" => "Route not Found"
        ]);
        exit;
        break;
}

// Cerrar la conexión después de procesar la solicitud
$database->closeConnection();
 */

header('Content-Type: application/json');

// Cargar las rutas
$routes = require __DIR__ . '/../src/routes/routes.php';
$router = new Router($routes);



// Define el prefijo del proyecto
$baseUri = '/GenesisMovilAgricola_v2/api/';
// Remueve el prefijo del proyecto de la URI
$uri = trim(str_replace($baseUri, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];


// Redirigir la solicitud usando el enrutador
$router->direct($method, $uri, $connection);
