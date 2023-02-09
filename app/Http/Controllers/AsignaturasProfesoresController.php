<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storeasignaturas_profesoresRequest;
use App\Http\Requests\Updateasignaturas_profesoresRequest;
use App\Models\asignaturas_profesores;
use App\Models\asignaturas;
use Illuminate\Support\Facades\DB;

class AsignaturasProfesoresController extends Controller
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
    public function create(Storeasignaturas_profesoresRequest $request)
    {
        //
        $asignaturas = json_decode($request->asignaturas);

        DB::beginTransaction();

        $deleted = asignaturas_profesores::where('fk_profesor', $request->idProfesor)->delete();

        foreach ($asignaturas as $value) {
            # code...
            $asignatura_profesor = new asignaturas_profesores;

            $asignatura_profesor->fk_profesor = $request->idProfesor;
            $asignatura_profesor->fk_asignatura = $value->fk_asignatura;
    
            if ($asignatura_profesor->save() != 1) {
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
     * @param  \App\Http\Requests\Storeasignaturas_profesoresRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeasignaturas_profesoresRequest $request)
    {
        //
        $asignaturasProfesor = asignaturas_profesores::select(
            'asignaturas_profesores.id', 'asignaturas.nombre', 'asignaturas_profesores.fk_asignatura'
        )
        ->join('asignaturas', 'asignaturas_profesores.fk_asignatura', '=', 'asignaturas.id')
        ->where("fk_profesor", $request->idProfesor)
        ->get();

        $asignaturas = asignaturas::select('id', 'nombre')
        ->where("estado", 1)
        ->get();

        return response()->json([
            'valid' => 1,
            'asignaturas' => $asignaturas,
            'asignaturasProfesor' => $asignaturasProfesor
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\asignaturas_profesores  $asignaturas_profesores
     * @return \Illuminate\Http\Response
     */
    public function show(asignaturas_profesores $asignaturas_profesores, Storeasignaturas_profesoresRequest $request)
    {
        //
        $profesorAsignatura = asignaturas_profesores::select(
            'profesores.id', 'profesores.nombre'
        )
        ->join('profesores', 'asignaturas_profesores.fk_profesor', '=', 'profesores.id')
        ->where("fk_asignatura", $request->idAsignatura)
        ->get();

        return response()->json([
            'valid' => 1,
            'profesores' => $profesorAsignatura,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\asignaturas_profesores  $asignaturas_profesores
     * @return \Illuminate\Http\Response
     */
    public function edit(asignaturas_profesores $asignaturas_profesores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateasignaturas_profesoresRequest  $request
     * @param  \App\Models\asignaturas_profesores  $asignaturas_profesores
     * @return \Illuminate\Http\Response
     */
    public function update(Updateasignaturas_profesoresRequest $request, asignaturas_profesores $asignaturas_profesores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\asignaturas_profesores  $asignaturas_profesores
     * @return \Illuminate\Http\Response
     */
    public function destroy(asignaturas_profesores $asignaturas_profesores)
    {
        //
    }
}
