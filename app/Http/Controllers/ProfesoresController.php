<?php

namespace App\Http\Controllers;

use App\Models\profesores;
use App\Http\Requests\StoreprofesoresRequest;
use App\Http\Requests\UpdateprofesoresRequest;
use Illuminate\Support\Facades\DB;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parametros['viewload'] = 'admin/profesores';

        $parametros['jsbase'] = 'admin/profesores.js';

        return view('viewinit', $parametros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreprofesoresRequest $request)
    {
        //
        $profesor = new profesores;

        $profesor->documento = $request->documento;
        $profesor->nombre = $request->nombre;
        $profesor->telefono = $request->telefono;
        $profesor->correo = $request->correo;
        $profesor->direccion = $request->direccion;
        $profesor->ciudad = $request->ciudad;
        $profesor->estado = $request->estado;

        if ($profesor->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Profesor creado correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible registrar el profesor',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreprofesoresRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreprofesoresRequest $request)
    {
        //
        $profesores = profesores::select(
            'id', 'documento', 'nombre', 'telefono', 'correo', 'direccion', 'ciudad', 'estado'
        )->get();

        return response()->json([
            'valid' => 1,
            'profesores' => $profesores,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function show(profesores $profesores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function edit(profesores $profesores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateprofesoresRequest  $request
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateprofesoresRequest $request, profesores $profesores)
    {
        //
        $profesor = profesores::find($request->idEditar);

        $profesor->documento = $request->documento;
        $profesor->nombre = $request->nombre;
        $profesor->telefono = $request->telefono;
        $profesor->correo = $request->correo;
        $profesor->direccion = $request->direccion;
        $profesor->ciudad = $request->ciudad;
        $profesor->estado = $request->estado;

        if ($profesor->save() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Profesor modificado correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible modificar el profesor',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\profesores  $profesores
     * @return \Illuminate\Http\Response
     */
    public function destroy(profesores $profesores, StoreprofesoresRequest $request)
    {
        //
        $profesor = profesores::find($request->idProfesor);

        if ($profesor->delete() == 1) {
            return response()->json([
                'valid' => 1,
                'message' => 'Profesor eliminado correctamente',
            ]);
        }
        return response()->json([
            'valid' => 0,
            'message' => 'No fue posible eliminar el profesor',
        ]);
    }
}
