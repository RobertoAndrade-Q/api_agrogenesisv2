<?php

namespace App\Repositories;

class LoteFloracionRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
}
