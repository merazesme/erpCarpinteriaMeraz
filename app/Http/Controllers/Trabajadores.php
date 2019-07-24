<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Importar Modelo
use App\Trabajador;

class Trabajadores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajadores = Trabajador::all();
        return response()->json(json_encode($trabajadores));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trabajador = new Trabajador();
        $trabajador->Nombre=$request->input('nombre');
        // $trabajador->Apellidos=$request->input('apellidos');
        $trabajador->Celular=$request->input('celular');
        $trabajador->Num_alternativo=$request->input('numero_alternativo');
        $trabajador->Domicilio=$request->input('domicilio');
        $trabajador->Estado_civil=$request->input('estado_civil');
        $trabajador->Fecha_nacimiento=$request->input('fecha_nacimiento');
        $trabajador->Lugar_nacimiento='Mazatlán';
        $trabajador->Estado='Sinaloa';
        $trabajador->Escolaridad=$request->input('escolaridad');
        $trabajador->Apodo=$request->input('apodo');
        $trabajador->NSS=$request->input('NSS');
        $trabajador->Infonavit=$request->input('infonavit');
        $trabajador->Num_credencial=$request->input('numero_credencial');
        $trabajador->Asistencia_total='0';
        $trabajador->Contraseña='hola';
        $trabajador->Tipo='temporal';
        $trabajador->Nacionalidad='Mexicano';
        $trabajador->idUsuario='0';

        $trabajador->save();
        return response()->json(['success'=>'Se agrego exitosamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
