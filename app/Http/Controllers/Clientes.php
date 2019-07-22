<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Cliente;
class Clientes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $data = Cliente::all();
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
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
        //
        //modelo
        try{
            $data=new Cliente();
            $data->Nombre=$request->input('txtNombre');
            $data->Apellidos=$request->input('txtApellidos');
            $data->Email=$request->input('txtEmail');
            $data->Telefono=$request->input('txtTelefono');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }

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
        try{
            $data = Cliente::find($id);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

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
        try{
            $data = Cliente::find($id);
            $data->Nombre=$request->input('txtNombre');
            $data->Apellidos=$request->input('txtApellidos');
            $data->Email=$request->input('txtEmail');
            $data->Telefono=$request->input('txtTelefono');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
            return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
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
