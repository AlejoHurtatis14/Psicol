<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreasignaturasRequest;
use App\Http\Requests\UpdateasignaturasRequest;
use App\Models\asignaturas;

class AsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parametros['viewload'] = 'admin/asignaturas';

        $parametros['jsbase'] = 'admin/asignaturas.js';

        return view('viewinit', $parametros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreasignaturasRequest $request)
    {
        //
        $asignatura = new asignaturas;

        $asignatura->nombre = $request->nombre;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->creditos = $request->creditos;
        $asignatura->areaconocimiento = $request->areaconocimiento;
        $asignatura->tipo = $request->tipo;
        $asignatura->estado = $request->estado;

        if ($asignatura->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Asignatura creada correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible registrar la asignatura',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreasignaturasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreasignaturasRequest $request)
    {
        //
        $asignaturas = asignaturas::select(
            'id', 'nombre', 'descripcion', 'creditos', 'areaconocimiento', 'tipo', 'estado'
        )->get();

        return response()->json([
            'valid' => 1,
            'asignaturas' => $asignaturas,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\asignaturas  $asignaturas
     * @return \Illuminate\Http\Response
     */
    public function show(asignaturas $asignaturas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\asignaturas  $asignaturas
     * @return \Illuminate\Http\Response
     */
    public function edit(asignaturas $asignaturas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateasignaturasRequest  $request
     * @param  \App\Models\asignaturas  $asignaturas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateasignaturasRequest $request, asignaturas $asignaturas)
    {
        //
        $asignatura = asignaturas::find($request->idEditar);

        $asignatura->nombre = $request->nombre;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->creditos = $request->creditos;
        $asignatura->areaconocimiento = $request->areaconocimiento;
        $asignatura->tipo = $request->tipo;
        $asignatura->estado = $request->estado;

        if ($asignatura->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Asignatura modificada correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible modificar la asignatura',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\asignaturas  $asignaturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(asignaturas $asignaturas, StoreasignaturasRequest $request)
    {
        //
        $asignatura = asignaturas::find($request->idAsignatura);

        $asignatura->estado = $request->estado;

        if ($asignatura->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Asignatura ' . ($request->estado == 1 ? 'activada' : 'inactivada') . ' correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible ' . ($request->estado == 1 ? 'activar' : 'inactivar') . ' la asignatura',
        ]);
    }
}
