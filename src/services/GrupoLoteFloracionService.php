<?php

namespace App\Services;

use App\Repositories\GrupoLoteFloracionRepository;

class GrupoLoteFloracionService
{
    private GrupoLoteFloracionRepository $repository;

    public function __construct(GrupoLoteFloracionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllGrupos(): array
    {
        return $this->repository->getAll();
    }

    public function getGrupo(int $id): array
    {
        return $this->repository->findById($id);
    }

    public function createGrupo(array $data): bool
    {
        // Validación y lógica de negocio aquí
        return $this->repository->create($data);
    }
}
