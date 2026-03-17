<?php
namespace App\Services\Credito;

use App\Models\Persona;
use App\Models\ServicioFinanciero;
use App\Models\PersonaServicio;
use App\Models\Emprendimiento;
use App\Models\PersonaDireccion;
use App\Models\PersonaTelefono;
use Illuminate\Support\Facades\DB;

class SolicitudService
{
    public function guardarServicio($data, $id = null)
    {
        if($id){
            $servicio = ServicioFinanciero::findOrFail($id);
            $servicio->update($data);
        }else{
            $servicio = ServicioFinanciero::create($data);
        }

        return $servicio;
    }

    public function guardarPersona($data, $id = null)
    {
        if($id){
            $persona = Persona::findOrFail($id);
            $persona->update($data);
        }else{
            //dd($data);
            $persona = Persona::create($data);
        }

        return $persona;
    }

    public function vincularPersonaServicio($personaId, $servicioId, $tipoPersonaId, $personaServicioId = null)
    {
        return PersonaServicio::updateOrCreate(
            ['id' => $personaServicioId],
            [
                'id_persona' => $personaId,
                'id_servicio_financiero' => $servicioId,
                'id_tipo_persona' => $tipoPersonaId
            ]
        );
    }

    public function guardarEmprendimiento($request)
    {
        return DB::transaction(function () use ($request) {

            $emprendimiento = Emprendimiento::updateOrCreate(
                ['id' => $request->id],
                [
                    'nombre' => $request->nombre,
                    'giro_negocio' => $request->giro_negocio,
                    'id_actividad_economica' => $request->id_actividad_economica,
                    'fecha' => $request->fecha,
                    'constituida_legalmente' => $request->constituida_legalmente,
                    'empleado_masculino' => $request->empleado_masculino ?? 0,
                    'empleado_femenino' => $request->empleado_femenino ?? 0,
                    'establecida_casa' => $request->establecida_casa,
                    'tiene_sucursales' => $request->tiene_sucursales,
                    'plataformas' => is_array($request->plataformas)
                        ? implode(', ', $request->plataformas)
                        : ($request->plataformas ?: ''),
                    'negocio_por_internet' => $request->negocio_por_internet,
                    'programa_rngg' => $request->programa_rngg,
                    'id_persona' => $request->id_persona,
                    'id_servicio_financiero' => $request->id_servicio
                ]
            );

            $emprendimiento->aspectosFormalizacion()->sync($request->aspectos ?? []);
            $emprendimiento->redesSociales()->sync($request->redes ?? []);

            $servicio = ServicioFinanciero::findOrFail($request->id_servicio);
            $servicio->estado = "datos_conyuge";
            $servicio->save();

            return $emprendimiento;
        });
    }

    public function guardarDireccionPersona($persona, $request)
    {
        /*$persona->direcciones()->updateOrCreate(
            ['id_persona' => $persona->id],
            [
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'id_tipo_direccion' => $request->tipo_direccion
            ]
        );*/
        if (!$request->has('direcciones') || !is_array($request->direcciones)) {
            return;
        }

        foreach ($request->direcciones as $tipo => $data) {

            if (empty($data['direccion'])) {
                continue;
            }

            $persona->direcciones()->updateOrCreate(
                [
                    'id_persona' => $persona->id,
                    'id_tipo_direccion' => $tipo
                ],
                [
                    'direccion' => $data['direccion'],
                    'referencia' => $data['referencia'] ?? null
                ]
            );
        }

    }

    public function guardarTelefonosPersona($persona, $request)
    {
        $persona->telefonos()->delete();

        $telefonos = [];

        foreach ($request->telefonos_tipo as $i => $tipo) {
            $telefonos[] = [
                'id_tipo_telefono' => $tipo,
                'numero' => $request->telefonos_numero[$i]
            ];
        }

        $persona->telefonos()->createMany($telefonos);
    }

}