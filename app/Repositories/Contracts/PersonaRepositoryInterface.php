<?php

namespace App\Repositories\Contracts;

interface PersonaRepositoryInterface
{
    /**
     * Obtener personas paginadas con filtros dinámicos
     *
     * @param int $perPage
     * @param string|null $estado         'completado' o cualquier otro valor para no completado
     * @param int|null $tipoPersona       Filtrar por tipo de persona
     * @param string|null $fechaInicio    Filtrar por fecha de creación inicio (YYYY-MM-DD)
     * @param string|null $fechaFin       Filtrar por fecha de creación fin (YYYY-MM-DD)
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPersonasPaginated(
        int $perPage = 10,
        ?string $estado = null,
        ?int $tipoPersona = null,
        ?string $fechaInicio = null,
        ?string $fechaFin = null
    );
}