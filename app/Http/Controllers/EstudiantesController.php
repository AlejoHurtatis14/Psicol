<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreestudiantesRequest;
use App\Http\Requests\UpdateestudiantesRequest;
use App\Models\estudiantes;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parametros['viewload'] = 'admin/estudiantes';

        $parametros['jsbase'] = 'admin/estudiantes.js';

        return view('viewinit', $parametros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreestudiantesRequest $request)
    {
        //
        $estudiante = new estudiantes;

        $estudiante->documento = $request->documento;
        $estudiante->nombre = $request->nombre;
        $estudiante->telefono = $request->telefono;
        $estudiante->correo = $request->correo;
        $estudiante->direccion = $request->direccion;
        $estudiante->ciudad = $request->ciudad;
        $estudiante->semestre = $request->semestre;
        $estudiante->estado = $request->estado;

        if ($estudiante->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Estudiante creado correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible registrar el estudiante',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreestudiantesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreestudiantesRequest $request)
    {
        //
        $estudiantes = estudiantes::select(
            'id', 'documento', 'nombre', 'telefono', 'correo', 'direccion', 'ciudad', 'semestre', 'estado'
        )->get();

        return response()->json([
            'valid' => 1,
            'estudiantes' => $estudiantes,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function show(estudiantes $estudiantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function edit(estudiantes $estudiantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateestudiantesRequest  $request
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateestudiantesRequest $request, estudiantes $estudiantes)
    {
        //
        $estudiante = estudiantes::find($request->idEditar);

        $estudiante->documento = $request->documento;
        $estudiante->nombre = $request->nombre;
        $estudiante->telefono = $request->telefono;
        $estudiante->correo = $request->correo;
        $estudiante->direccion = $request->direccion;
        $estudiante->ciudad = $request->ciudad;
        $estudiante->semestre = $request->semestre;
        $estudiante->estado = $request->estado;

        if ($estudiante->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Estudiante modificado correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible modificar el estudiante',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function destroy(estudiantes $estudiantes, StoreestudiantesRequest $request)
    {
        //
        $estudiante = estudiantes::find($request->idEstudiante);

        $estudiante->estado = $request->estado;

        if ($estudiante->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Estudiante ' . ($request->estado == 1 ? 'activado' : 'inactivado') . ' correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible ' . ($request->estado == 1 ? 'activar' : 'inactivar') . ' el estudiante',
        ]);
    }
}
