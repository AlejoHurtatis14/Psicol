<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorereporteRequest;
use App\Http\Requests\UpdatereporteRequest;
use App\Models\asignaturas_estudiante;
use App\Models\estudiantes;
use View;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parametros['viewload'] = 'admin/reporte';

        $parametros['jsbase'] = 'admin/reporte.js';

        $estudiantes = estudiantes::select('id', 'nombre', 'documento')->get();

        View::share('estudiantes', $estudiantes);

        return view('viewinit', $parametros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorereporteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorereporteRequest $request)
    {
        //
        $asignaturas = asignaturas_estudiante::select(
            'asignaturas.nombre'
            , 'asignaturas.areaconocimiento'
            , 'asignaturas.creditos'
            , "asignaturas.tipo"
            , 'estudiantes.semestre'
            , 'profesores.documento AS docProfesor'
            , 'profesores.nombre AS nomProfesor'
        )->join('asignaturas', 'asignaturas_estudiantes.fk_asignatura', '=', 'asignaturas.id')
        ->join('profesores', 'asignaturas_estudiantes.fk_profesor', '=', 'profesores.id')
        ->join('estudiantes', 'asignaturas_estudiantes.fk_estudiante', '=', 'estudiantes.id')
        ->where('asignaturas_estudiantes.fk_estudiante', $request->estudiante)
        ->get();

        return response()->json([
            'valid' => 1,
            'asignaturas' => $asignaturas,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function show(reporte $reporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit(reporte $reporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatereporteRequest  $request
     * @param  \App\Models\reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatereporteRequest $request, reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(reporte $reporte)
    {
        //
    }
}
