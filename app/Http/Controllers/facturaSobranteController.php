<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\facturas_sobrantes as Facturas;
use App\pago_factura_sobrante as Pago;
use App\relacion_factura_pago as Relacion;

use Image;

class facturaSobranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acceso = (new loginController)->check_session('Facturas sobrantes');

        if($acceso == 'permitir') {
            $modulo = 'Facturas sobrantes';
            return view('facturas_sobrantes.facturas_sobrantes_show', compact('modulo'));
        } else if($acceso == 'denegar') {
            return redirect('/');
        } else {
            return redirect('/login/');
        }
    }

    /**
     * Display all the resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datos() {
        return Facturas::all();
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_facturas_pagos() 
    {
        $registros = DB::table('pago_facturas_sobrantes')
            ->join('facturas_sobrantes_has_pago_facturas_sobrantes', 
                   'facturas_sobrantes_has_pago_facturas_sobrantes.pago_facturas_sobrantes_id', '=', 'pago_facturas_sobrantes.id')
            ->join('facturas_sobrantes', 'facturas_sobrantes.id', '=', 'facturas_sobrantes_has_pago_facturas_sobrantes.factura_sobrante_id')
            ->select('pago_facturas_sobrantes.id', 'pago_facturas_sobrantes.Fecha', 'pago_facturas_sobrantes.Folio_pago', 
                     'facturas_sobrantes.Folio_factura', 'pago_facturas_sobrantes.Cantidad', 'pago_facturas_sobrantes.Metodo_pago')
            ->get();
        return $registros;
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
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->mdate )            ||
            empty( $request->factura_folio )    ||
            empty( $request->factura_concepto ) ||
            empty( $request->factura_total ) 
        ) {
            return 'empty';
        }
        // if($request->hasFile('gasolina_archivo')) {
        //     return 'Tiene archivo';
        // } else {
        //     return 'No tiene';
        // } 

        $file = $request->file('factura_archivo');
        $nombre = time().$file->getClientOriginalName();
        $location = public_path('images/modulos/facturas_sobrantes/'.$nombre);
        Image::make($file)->save($location);

        $factura = new Facturas();

        $factura->Fecha         = $request->mdate;
        $factura->Concepto      = $request->factura_concepto;
        $factura->Folio_factura = $request->factura_folio;
        $factura->Documento     = $nombre;
        $factura->Total  = $request->factura_total;
        $factura->Estado = 1;
        $factura->idUsuario = session('idUsuario');

        if(!$factura->save()) {
            return 'error';
        }
        return 'true';
    }

    public function guardar_pago(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->factura_pago_folio )    ||
            empty( $request->factura_pago_metodo )   ||
            empty( $request->factura_pago_facturas ) ||
            empty( $request->fecha )
        ) {
            return 'empty';
        }

        /** Registrar el pago en la tabla */
        $pago = new Pago();

        $pago->Fecha        = $request->fecha;
        $pago->Metodo_pago  = $request->factura_pago_metodo;
        $pago->Folio_pago   = $request->factura_pago_folio;
        $pago->idUsuario    = session('idUsuario');

        if(!$pago->save()) {
            return 'error-pago';
        }

        /** Guardar la relación entre los facturas y pagos */
        $errores = 0;
        $facturas = json_decode($request->factura_pago_facturas);
        foreach ($facturas as $factura) {
            $relacion = new Relacion();
    
            $relacion->factura_sobrante_id = $factura;
            $relacion->pago_facturas_sobrantes_id = $pago->id;
            

            if(!$relacion->save()) {
                $errores++;
            }
        }

        if($errores > 0) {
            /** Ocurre error, borrar pago, retornar error de relación */
            $this->destroy($pago->id);
            return 'error-relacion';
        }

        $total = 0;
        /** Cambiar de estado a cero a los facturas */
        foreach ($facturas as $factura) {
            $factura_update = Facturas::find($factura);
            $factura_update->Estado = 0;
            $total += $factura_update->Total;
            $factura_update->update();
        }

        $pago->Cantidad = $total;

        if(!$pago->update()) {
            $this->destroy($pago->id);
            $this->destroy_multiple($pago->id);
            return 'error-pago';
        }
        return 'true';
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
        $pago = Pago::find($id);
        if(!$pago->delete()) {
            return 'false';
        }
        return 'true';
    }

    /**
     * Remove multiples resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_multiple($id)
    {
        //
        $relacion = DB::table('facturas_sobrantes_has_pago_facturas_sobrantes')
                    ->where('pago_facturas_sobrantes_id', '=', $id);
        if(!$relacion->delete()) {
            return 'false';
        }
        return 'true';
    }
}
