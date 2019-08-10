<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Cotizaciones_dashborad extends Controller
{

    public function consultarCotizaciones($mes)
    {
        $sql = "SELECT Descripcion, Prioridad, Costo, fecha_inicio, fecha_fin, clientes.Nombre, clientes.Apellidos FROM `cotizaciones`
            INNER JOIN clientes on clientes.id = cotizaciones.Clientes_idCliente
            WHERE cotizaciones.estado != 0 and MONTH(fecha_inicio) = ? or cotizaciones.estado != 0 and MONTH(fecha_fin) = ?";

        $Cotizaciones_dashborad = DB::select($sql, array($mes, $mes));
        return $Cotizaciones_dashborad;
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
