<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\carro as Carro;

class carroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acceso = (new loginController)->check_session('Carros');

        if($acceso == 'permitir') {
            $modulo = "Carros";
            return view('carros/carro', compact('modulo'));
        } else if($acceso == 'denegar') {
            return redirect('/');
        } else {
            return redirect('/login/');
        }
    }

    /**
     * Display all the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        //
        return Carro::all();
    }

    /**
     * Display all the workers resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataTrabajadores()
    {
        //
        // return DB::table('trabajadores')->get();
        return DB::table('trabajadores')
                    ->select('trabajadores.id', 'trabajadores.Nombre', 'trabajadores.Apellidos')
                    ->where('trabajadores.Estado','=','1')
                    ->get();
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
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->carro_marca )  ||
            empty( $request->carro_modelo ) ||
            empty( $request->carro_placas )
        ) {
            return 'empty';
        }

        $carro_trabajador = (empty($request->carro_trabajador)) ? null : $request->carro_trabajador;

        $carro = new Carro();

        $carro->Marca           = $request->carro_marca;
        $carro->Modelo          = $request->carro_modelo;
        $carro->placa           = $request->carro_placas;
        $carro->idTrabajador    = $carro_trabajador;
        $carro->Estado      = 1;
        $carro->idUsuario   = session('idUsuario');

        if(!$carro->save()) {
            return 'error';
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
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->carro_marca )  ||
            empty( $request->carro_modelo ) ||
            empty( $request->carro_placas )
        ) {
            return 'empty';
        }

        $carro_trabajador = (empty($request->carro_trabajador)) ? null : $request->carro_trabajador;

        $carro = Carro::find($id);

        $carro->Marca           = $request->carro_marca;
        $carro->Modelo          = $request->carro_modelo;
        $carro->placa           = $request->carro_placas;
        $carro->idTrabajador    = $carro_trabajador;
        $carro->idUsuario = session('idUsuario');

        if(!$carro->update()) {
            return 'error';
        }
        return 'true';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_estatus($id)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        $carro = Carro::find($id);
        $Estado = $carro->Estado == 0 ? 1 : 0;
        $carro->Estado = $Estado;

        if(!$carro->update()) {
            return 'false';
        }
        return 'true';
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
