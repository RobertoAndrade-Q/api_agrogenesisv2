<?php

namespace App\Repositories;

class TaskRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // Crea una propiedad de tasks para que sea utilizada por todos los métodos de la clase
    private $tasks = [
        ['id' => 1, 'description' => 'Buy milk', 'completed' => false],
        ['id' => 2, 'description' => 'Clean house', 'completed' => true],
        ['id' => 3, 'description' => 'Learn PHP', 'completed' => false]
    ];

    public function getAll(): array
    {
        return $this->tasks;
    }

    public function findById(int $id): array
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

        return $task;
    }
}
