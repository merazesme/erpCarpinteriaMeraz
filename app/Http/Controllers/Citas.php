<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Cita;

class Citas extends Controller
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
    public function listarCitas($week)
    {
        $sql = "SELECT citas.id, Comentario, Fecha, citas.Estado, clientes.Nombre, clientes.Apellidos FROM `citas` 
                INNER JOIN clientes ON citas.Clientes_id = clientes.id 
                WHERE WEEK(Fecha) = ?";

        $citas = DB::select($sql, array($week));
        return $citas;
    }

    public function buscarCitaPorFecha($date)
    {
        $sql = "SELECT * FROM citas
                WHERE Fecha = ?";

        $cita = DB::select($sql, array($date));
        return $cita;
    }

    public function store(Request $request)
    {
        //preparar datos
        if(!session('Usuario')) {
            return 'session';
        }
        $data=new Cita();
        $data->Comentario=$request->input('comentario');
        $data->Fecha=$request->input('fecha');
        $data->Estado=$request->input('estatus');
        $data->idUsuario=$request->input('idUsuario');
        $data->Clientes_id=$request->session('idUsuario');
        $data->save();
        return $data;
    }

    public function buscarCita($id)
    {
        $datosCita = Cita::find($id);
        $cita = array($datosCita, $datosCita->Cliente);
        // var_dump($citaModificar);
        return $cita[0];
    }

    public function editarCita(Request $request, $id)
    {
        //preparar datos
        $data = Cita::find($id);
        $data->Comentario=$request->input('comentario');
        $data->Fecha=$request->input('fecha');
        $data->Estado=$request->input('estatus');
        $data->idUsuario=$request->input('idUsuario');
        $data->Clientes_id=$request->input('cliente');
        // return $request->all();
        $data->save();
        return $data;
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
        //preparar datos
        $data = Cita::find($id);
        $data->Comentario=$request->input('comentario');
        $data->Fecha=$request->input('fecha');
        $data->Estado=$request->input('estatus');
        $data->idUsuario=$request->input('idUsuario');
        $data->Clientes_id=$request->input('cliente');
        // return $request->all();
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
        $id = $_POST['id'];
        $data = Cita::find($id);
        $data->delete();
    }
}
