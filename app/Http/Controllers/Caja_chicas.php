<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Caja_chica;

class Caja_chicas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function consultar($fechaInicial, $fechaFinal)
    {
        $sql = "SELECT * FROM `caja_chicas` WHERE fecha BETWEEN ? AND ?";

        $cajachica = DB::select($sql, array($fechaInicial, $fechaFinal));
        return $cajachica;
    }

    public function consultarConfiguracion()
    {
        $sql = "SELECT Minimo_caja_chica as monto FROM configuracions";

        $monto = DB::select($sql);
        return $monto;
    }

    public function montarDatos($id)
    {
        $datosRegistro = Caja_chica::find($id);
        return $datosRegistro;
    }

    public function consultarUltimaSemana()
    {
        $sql = "SELECT * from caja_chicas where week(Fecha) = (SELECT week(fecha) FROM caja_chicas WHERE id = (SELECT MAX(id) from caja_chicas))";

        $ultimasemana = DB::select($sql);
        return $ultimasemana;
    }
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
    public function nuevaHoja()
    {
        $concepto = $_POST['Concepto'];
        $tipo = $_POST['Tipo'];
        $fecha = $_POST['Fecha'];
        $idUsuario = $_POST['idUsuario'];

        $data=new Caja_chica();
        $data->Concepto=$concepto;
        $data->Tipo=$tipo;
        $data->Estado=0;
        $data->Fecha=$fecha;
        $data->idUsuario=$idUsuario;
        $data->save();
        return $data;
    }
    public function store(Request $request)
    {
        //preparar datos
        $data=new Caja_chica();
        $data->Fecha=$request->input('fecha');
        $data->Concepto=$request->input('concepto');
        $data->Total=$request->input('cantidad');
        $data->Tipo=$request->input('tipo');
        $data->Estado=1;
        $data->idUsuario=$request->input('idUsuario');
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
        $data = Caja_chica::find($id);
        $data->Fecha=$request->input('fecha');
        $data->Concepto=$request->input('concepto');
        $data->Total=$request->input('cantidad');
        $data->Tipo=$request->input('tipo');
        $data->idUsuario=$request->input('idUsuario');
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
        $data = Caja_chica::find($id);
        $data->delete();
    }
}
