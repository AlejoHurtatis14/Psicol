<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeasignaturas_estudianteRequest;
use App\Http\Requests\Updateasignaturas_estudianteRequest;
use App\Models\asignaturas_estudiante;
use App\Models\asignaturas;
use Illuminate\Support\Facades\DB;

class AsignaturasEstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Storeasignaturas_estudianteRequest $request)
    {
        //
        $asignaturas = json_decode($request->asignaturas);

        DB::beginTransaction();

        $deleted = asignaturas_estudiante::where('fk_estudiante', $request->idEstudiante)->delete();

        foreach ($asignaturas as $value) {
            # code...
            $asignatura_estudiante = new asignaturas_estudiante;

            $asignatura_estudiante->fk_estudiante = $request->idEstudiante;
            $asignatura_estudiante->fk_profesor = $value->fk_profesor;
            $asignatura_estudiante->fk_asignatura = $value->fk_asignatura;
    
            if ($asignatura_estudiante->save() != 1) {
                DB::rollBack();
                return response()->json([
                    'valid' => 0,
                    'message' => 'No fue posible guardar las asignaturas',
                ]);
            }
        }

        DB::commit();
        return response()->json([
            'valid' => 1,
            'message' => 'Asignaturas guardadas correctamente',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storeasignaturas_estudianteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeasignaturas_estudianteRequest $request)
    {
        //
        $asignaturasEstudiante = asignaturas_estudiante::select(
            'asignaturas_estudiantes.id', 'asignaturas.nombre', 'asignaturas_estudiantes.fk_asignatura', 'profesores.nombre AS nombreProf', 'asignaturas_estudiantes.fk_profesor', 'asignaturas.creditos'
        )
        ->join('asignaturas', 'asignaturas_estudiantes.fk_asignatura', '=', 'asignaturas.id')
        ->join('profesores', 'asignaturas_estudiantes.fk_profesor', '=', 'profesores.id')
        ->where("fk_estudiante", $request->idEstudiante)
        ->get();

        $asignaturas = asignaturas::select('id', 'nombre', 'creditos')
        ->where("estado", 1)
        ->get();

        return response()->json([
            'valid' => 1,
            'asignaturas' => $asignaturas,
            'asignaturasEstudiante' => $asignaturasEstudiante
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\asignaturas_estudiante  $asignaturas_estudiante
     * @return \Illuminate\Http\Response
     */
    public function show(asignaturas_estudiante $asignaturas_estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\asignaturas_estudiante  $asignaturas_estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(asignaturas_estudiante $asignaturas_estudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateasignaturas_estudianteRequest  $request
     * @param  \App\Models\asignaturas_estudiante  $asignaturas_estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Updateasignaturas_estudianteRequest $request, asignaturas_estudiante $asignaturas_estudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\asignaturas_estudiante  $asignaturas_estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(asignaturas_estudiante $asignaturas_estudiante)
    {
        //
    }
}
