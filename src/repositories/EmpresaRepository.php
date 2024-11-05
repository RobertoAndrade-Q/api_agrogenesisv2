<?php

namespace App\Repositories;

class EmpresaRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $query = "SELECT * from ge_empresa ORDER BY CAST(codigo AS DECIMAL) DESC";

        try {
            $result = odbc_exec($this->connection, $query);
            if (!$result) {
                throw new \Exception("Database query failed");
            }

            $empresas = [];
            while ($row = odbc_fetch_array($result)) {
                $empresas[] = $row;
            }
            return $empresas;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching companies: " . $e->getMessage());
        }
    }
}
