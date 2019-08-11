<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Carpeta_del_mes extends Controller
{

    public function pagoCompras($fecha){
        $sql = "SELECT * FROM pago_compras WHERE fecha = ?";

        $pagoCompras = DB::select($sql, array($fecha));
        return $pagoCompras;
    }

    public function detallePagoCompras($id){
        $sql = "SELECT compras.Num_nota as notaCompras, compras.Factura as facturaCompras, compras.Cantidad as cantidadCompras, proveedores.Nombre as nombreProveedores 
            FROM compras 
            INNER join compras_has_pago_compra on compras_has_pago_compra.Compras_id = compras.id
            INNER join proveedores on compras.Proveedores_idProveedor = proveedores.id 
            WHERE compras_has_pago_compra.Pago_compra_idPago_compra = ?";

        $detallePagoCompras = DB::select($sql, array($id));
        return $detallePagoCompras;
    }

    public function pagoCotizaciones($fecha){
        $sql = "select 'ingreso' as tipo, pago_cotizaciones.id, pago_cotizaciones.Fecha, cantidad, Tipo_pago, Num_pago, comentario, descripcion, nombre, apellidos 
            from pago_cotizaciones 
            INNER JOIN cotizaciones on pago_cotizaciones.Cotizaciones_id = cotizaciones.id 
            INNER JOIN clientes on cotizaciones.Clientes_idCliente = clientes.id
            WHERE Fecha = ? ";

        $pagoCotizaciones = DB::select($sql, array($fecha));
        return $pagoCotizaciones;
    }

    public function pagoGasolina($fecha){
        $sql = "SELECT * from pago_gasolinas where fecha = ?";

        $pagoGasolina = DB::select($sql, array($fecha));
        return $pagoGasolina;
    }

    public function detallePagoGasolinas($id){
        $sql = "SELECT gasolinas.Ticket, carros.Marca, carros.Modelo 
                FROM gasolinas
                INNER JOIN gasolina_has_pago_gasolina on gasolina_has_pago_gasolina.Gasolina_id = gasolinas.id
                INNER JOIN carros on carros.id = gasolinas.Carros_idCarro
                WHERE gasolina_has_pago_gasolina.Pago_gasolina_idPago_gasolina = ?";
        $detallePagoGasolinas = DB::select($sql, array($id));
        return $detallePagoGasolinas;
    }

    public function facturasSobrantes($fecha){
        $sql = "SELECT 'egreso' as tipo, Concepto, Folio_factura, Folio_movimiento, Fecha_pago, Tipo_pago, Documento, Total FROM `facturas_sobrantes` WHERE fecha_pago = ?";

        $facturasSobrantes = DB::select($sql, array($fecha));
        return $facturasSobrantes;
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
