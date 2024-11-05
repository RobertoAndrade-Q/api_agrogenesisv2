<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    private TaskRepository $repository;

    public function __construct($connection)
    {
        $this->repository = new TaskRepository($connection);
    }

    public function getAllTasks(): array
    {
        return $this->repository->getAll();
    }

    public function getTaskById(int $id): array
    {
        // TODO: Añadir validaciones de ID que recibe
        return $this->repository->findById($id);
    }
}
