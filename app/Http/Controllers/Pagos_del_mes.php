<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Pagos_del_me;
use Image;

class Pagos_del_mes extends Controller
{

    public function listarPagos()
    {
        $pagos = Pagos_del_me::all();
        return $pagos;
    }

    public function renovarPagos(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        //preparar datos
        $Concepto = $_POST['Concepto'];
        $Fecha = $_POST['Fecha'];
        $Cantidad = $_POST['Cantidad'];
        $Estado = 1;

        $data=new Pagos_del_me();
        $data->Concepto=$Concepto;
        $data->Fecha=$Fecha;
        $data->Cantidad=$Cantidad;
        $data->Estado=$Estado;
        $data->idUsuario=session('idUsuario');
        $data->save();
        return $data;
    }
    public function consultarUltimoMes()
    {
        $sql = "SELECT * from pagos_del_mes where month(Fecha) = (SELECT month(fecha) FROM pagos_del_mes WHERE id = (SELECT MAX(id) from pagos_del_mes)) and year(Fecha) = (SELECT year(fecha) FROM pagos_del_mes WHERE id = (SELECT MAX(id) from pagos_del_mes))";

        $ultimomes = DB::select($sql);
        return $ultimomes;
    }

    public function pagoConcepto(Request $request, $id)
    {
        $file = $request->file('pagoconcepto_archivo');
        $nombre = time().$file->getClientOriginalName();
        $location = public_path('images/modulos/pagosdelmes/'.$nombre);
        Image::make($file)->resize(250, 380)->save($location);

        $archivo = Pagos_del_me::find($id);
        $archivo->Documento = $nombre;
        $archivo->Estado = 2;

        $archivo->save();
        return $archivo;
    }

    public function estadoVencido(Request $request, $id)
    {

        $data = Pagos_del_me::find($id);
        $data->Estado = 3;

        $data->save();
        return $data;
    }

    public function montarDatos($id)
    {
        $datosConcepto = Pagos_del_me::find($id);
        return $datosConcepto;
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
        if(!session('Usuario')) {
            return 'session';
        }
        //preparar datos
        $data=new Pagos_del_me();
        $data->Fecha=$request->input('fechaVencimiento');
        $data->Concepto=$request->input('nombreConcepto');
        $data->Cantidad=$request->input('cantidadPago');
        $data->Observacion=$request->input('observacionPago');
        $data->Estado=1;
        $data->idUsuario=session('idUsuario');
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
        if(!session('Usuario')) {
            return 'session';
        }
        $data = Pagos_del_me::find($id);
        $data->Fecha=$request->input('fechaVencimiento');
        $data->Concepto=$request->input('nombreConcepto');
        $data->Cantidad=$request->input('cantidadPago');
        $data->Observacion=$request->input('observacionPago');
        $data->idUsuario=session('idUsuario');
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
        $data = Pagos_del_me::find($id);
        $data->delete();
    }
}
