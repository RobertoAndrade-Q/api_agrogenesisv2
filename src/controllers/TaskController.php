<?php

namespace App\Controllers;

use App\Services\TaskService;

class TaskController
{
    private TaskService $service;

    public function __construct($connection)
    {
        $this->service = new TaskService($connection);
    }

    public function getAllTasks()
    {
        $tasks = $this->service->getAllTasks();
        echo json_encode($tasks);
    }

    public function getTask(int $id)
    {
        $task = $this->service->getTaskById($id);
        echo json_encode($task);
    }

    /* 
    public function processRequest(string $method, ?string $id): void
    {

        if ($id === null) {
            switch ($method) {

                case 'GET':
                    $this->getAllTasks();
                    break;

                case 'POST':
                    $this->createTask();
                    break;

                default:
                    $this->respondMethodNotAllowed('GET, POST');
                    break;
            }
        } else {
            switch ($method) {
                case 'GET':
                    $this->getTask((int) $id);
                    break;

                default:
                    $this->respondMethodNotAllowed('GET');
                    break;
            }
        }
    }

    function getTask($id)
    {
        $task = null;

        foreach ($this->tasks as $t) {
            if ($t['id'] == $id) {
                $task = $t;
                break;
            } else {
                $task = null;
            }
        }

        if ($task === null) {
            // Devuelve un json que diga que no se encontró la tarea y un código de respuesta 404
            http_response_code(404);
            echo json_encode(['message' => 'Task with ' . $id . ' not found']);

            exit;
        }


        echo json_encode($task);
    }
 

    function createTask()
    {
         // Leer el cuerpo de la petición
        $body = file_get_contents('php://input');
        // Decodificar el JSON
        $data = json_decode($body, true);
        // Crear un ID
        $id = count($this->tasks) + 1;
        // Crear la tarea
        $task = [
            'id' => $id,
            'description' => $data['description'],
            'completed' => false
        ];
        // Agregar la tarea al arreglo
        $this->tasks[] = $task;
        // Devolver la tarea creada
        echo json_encode($task); 
        echo "createTask";
    }
 */

    // Función Generales
    function respondMethodNotAllowed(string $allowedMethods)
    {
        http_response_code(405);
        header("Allow: $allowedMethods");
        echo json_encode(['message' => 'Method not allowed']);
    }
}
