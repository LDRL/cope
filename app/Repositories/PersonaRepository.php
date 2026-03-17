<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;

class PersonaRepository implements PersonaRepositoryInterface
{

     /**
     * Obtener personas paginadas con filtros dinámicos
     *
     * @param int $perPage
     * @param string|null $estado  'completado' o cualquier otro valor para no completado
     * @param int|null $tipoPersona
     * @param string|null $fechaInicio
     * @param string|null $fechaFin
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPersonasPaginated(
        int $perPage = 10,
        ?string $estado = null,
        ?int $tipoPersona = 1,
        ?string $fechaInicio = null,
        ?string $fechaFin = null
    ) {
        $query = Persona::with('personaServicio.servicioFinanciero')
            ->where(function($q) use ($estado, $tipoPersona) {
                if ($estado === 'completado') {
                    // Solo los que tienen servicioFinanciero completado
                    $q->whereHas('personaServicio.servicioFinanciero', function($q2) use ($tipoPersona) {
                        $q2->where('estado', 'completado');
                        if ($tipoPersona) {
                            $q2->where('id_tipo_persona', $tipoPersona);
                        }
                    });
                } else {
                    // Pendientes: o no tienen servicioFinanciero o su estado no es completado
                    $q->whereHas('personaServicio.servicioFinanciero', function($q2) use ($tipoPersona) {
                        $q2->where('estado', '<>', 'completado');
                        if ($tipoPersona) {
                            $q2->where('id_tipo_persona', $tipoPersona);
                        }
                    })
                    ->orWhereDoesntHave('personaServicio'); // incluye los que no tienen personaServicio aún
                }

            })
            ->orderBy('id', 'desc');

            // Filtrar por rango de fechas en la tabla personas
            if ($fechaInicio) {
                $query->whereDate('created_at', '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate('created_at', '<=', $fechaFin);
            }

        return $query->paginate($perPage);
    }

}