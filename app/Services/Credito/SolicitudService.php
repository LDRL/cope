<?php
namespace App\Services\Credito;

use App\Models\Persona;
use App\Models\ServicioFinanciero;
use App\Models\PersonaServicio;
use App\Models\Emprendimiento;
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
            $persona = Persona::create($data);
        }

        return $persona;
    }

    public function vincularPersonaServicio($personaId, $servicioId, $personaServicioId = null)
    {
        return PersonaServicio::updateOrCreate(
            ['id' => $personaServicioId],
            [
                'id_persona' => $personaId,
                'id_servicio_financiero' => $servicioId,
                'id_tipo_persona' => 1
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
                        : $request->plataformas,
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

}