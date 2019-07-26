<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\proveedore as Proveedor;

class proveedorController extends Controller
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
        $modulo = 'Agregar proveedor';
		return view('proveedores.proveedores_agregar', compact('modulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gasoline_list()
    {
        $modulo = 'Gasolina';
		return view('proveedores.proveedores_gasolina', compact('modulo'));
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
     * Store a newly created provider resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregar_proveedor(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('proveedor_nombre') )    ||
            empty( $request->input('proveedor_rfc') )       ||
            empty( $request->input('proveedor_correo') )    ||
            empty( $request->input('proveedor_telefono') )
        ) {
            return 'empty';
        }

        $proveedor = new Proveedor();

        $proveedor->RFC         = $request->input('proveedor_rfc');
        $proveedor->Nombre      = $request->input('proveedor_nombre');
        $proveedor->Telefono    = $request->input('proveedor_telefono');
        $proveedor->Email       = $request->input('proveedor_correo');
        $proveedor->Adeudo      = 0;
        $proveedor->estatus     = 0;
        $proveedor->idUsuario   = session('idUsuario');

        if(!$proveedor->save()) {
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
        $modulo = 'Editar proveedor';
		return view('proveedores.proveedores_agregar', compact('modulo'));
    }

    /**
     * Show all the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_resources()
    {
        $modulo = 'Lista de proveedores';
		return view('proveedores.proveedores_show', compact('modulo'));
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_proveedores() 
    {
        // $query = 
        //     DB::table('proveedores')
        //     ->  select('*')
        //     ->  get();
        // return $query;
        return Proveedor::all();
    }

    /**
     * Show the data of provider for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datos_proveedor_especifico($id) 
    {
        return Proveedor::find($id);
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
     * Update the specified resource (provider) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_proveedor(Request $request, $id)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('proveedor_nombre') )    ||
            empty( $request->input('proveedor_rfc') )       ||
            empty( $request->input('proveedor_correo') )    ||
            empty( $request->input('proveedor_telefono') )
        ) {
            return 'empty';
        }

        $proveedor = Proveedor::find($id);

        $proveedor->RFC         = $request->input('proveedor_rfc');
        $proveedor->Nombre      = $request->input('proveedor_nombre');
        $proveedor->Telefono    = $request->input('proveedor_telefono');
        $proveedor->Email       = $request->input('proveedor_correo');
        $proveedor->idUsuario   = session('idUsuario');

        if(!$proveedor->update()) {
            return 'error';
        }
        return 'true';
    }

    /**
     * Update the specified status in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_proveedor_estatus($id) 
    {
        if(!session('Usuario')) {
            return 'session';
        }
        $proveedor  = Proveedor::find($id);
        $estatus    = $proveedor->estatus == 0 ? 1 : 0;
        $proveedor->estatus = $estatus;

        if(!$proveedor->update()) {
            return 'false';
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
