<?php

use App\Controllers\EmpresaController;
use App\Controllers\GrupoLoteFloracionController;
use App\Controllers\TaskController;
use App\Controllers\ClientesController;

return [
    'GET' => [
        /* -------------------------------- EMPRESAS -------------------------------- */
        'empresas' => [EmpresaController::class, 'getAllEmpresas'],
        'empresas/(:num)' => [EmpresaController::class, 'getEmpresa'],
        /* -------------------------- GRUPO LOTE FLORACION -------------------------- */
        'grupolotefloracion' => [GrupoLoteFloracionController::class, 'getAllGrupos'],
        'grupolotefloracion/(:num)' => [GrupoLoteFloracionController::class, 'getGrupo'],
        /* ---------------------------------- TASKS --------------------------------- */
        'tasks' => [TaskController::class, 'getAllTasks'],
        'tasks/(:num)' => [TaskController::class, 'getTask'],
        /* --------------------------------- CLIENTES --------------------------------- */
        'clientes' => [ClientesController::class, 'buscar'],
    ],
    'POST' => [
        'grupolotefloracion' => [GrupoLoteFloracionController::class, 'createGrupo']
    ]
];
