<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Pendiente;

class Pendientes extends Controller
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
        //preparar datos
        $data=new Pendiente();
        $data->Descripcion=$request->input('descripcionPendiente');
        $data->Estado=$request->input('estatusPendiente');
        $data->idUsuario=$request->input('idUsuario');
        $data->save();
        return $data;
    }
    public function buscarPendiente($id)
    {
        $datosPendiente = Pendiente::find($id);
        return $datosPendiente;
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
    public function listarPendientes()
    {
        $pendientes = Pendiente::all();
        return $pendientes;
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
        //preparar datos
        $data = Pendiente::find($id);

        $data->Descripcion=$request->input('descripcionPendiente');
        $data->Estado=$request->input('estatusPendiente');
        $data->idUsuario=$request->input('idUsuario');

        $data->save();
        return $data;
    }

    public function actualizarEstatusPendiente()
    {
        $id = $_POST['id'];
        $data = Pendiente::find($id);
        if($data->Estado==0)
            $data->Estado=1;
        else if($data->Estado==1)
            $data->Estado=0;

        $data->save();
        return $data;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $bandera = 0;
        $sql1 = "select * from pendientes where Estado = 0";
        $buscar = DB::select($sql1);

        if (sizeof($buscar)>0) {
            $sql = "DELETE from pendientes where Estado = 0";
            $eliminado = DB::select($sql);
            $bandera=1;
        }
        return $bandera;
    }
}
