<?php

namespace App\Repositories;

class GrupoLoteFloracionRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM grupo_lote_floracion ORDER BY id DESC";
        $result = odbc_exec($this->connection, $query);

        $grupos = [];
        while ($row = odbc_fetch_array($result)) {
            $grupos[] = $row;
        }
        return $grupos;
    }

    public function findById(int $id): array
    {
        $query = "SELECT * FROM grupo_lote_floracion WHERE id = $id";
        $result = odbc_exec($this->connection, $query);
        return odbc_fetch_array($result);
    }

    public function create(array $data): bool
    {
        // Lógica de inserción en la base de datos aquí
        return true;
    }
}
