<?php

namespace App\Services;

use App\Repositories\LoteFloracionRepository;

class LoteFloracionService
{
    private LoteFloracionRepository $repository;

    public function __construct($connection)
    {
        $this->repository = new LoteFloracionRepository($connection);
    }

    private function codificar(array $data): array
    {
        return array_map(fn($value) => utf8_encode($value), $data);
    }
}
