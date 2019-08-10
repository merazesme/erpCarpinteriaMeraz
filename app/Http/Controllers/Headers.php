<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Header;

class Headers extends Controller
{
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
    public function consultarUltimaSemana()
    {
        $sql = "SELECT * from caja_chicas where week(Fecha) = (SELECT week(fecha) FROM caja_chicas WHERE id = (SELECT MAX(id) from caja_chicas))";

        $ultimasemana = DB::select($sql);
        return $ultimasemana;
    }
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
        //
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
