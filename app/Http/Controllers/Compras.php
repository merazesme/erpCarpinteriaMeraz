<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Compra;
use App\Materiale;
use App\proveedor;
use DB;
class Compras extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // try{
        //     $data = Compra::all();
        //     return response()->json(json_encode($data));
        // }
        // catch(\Exception $e){
        //    return response()->json(json_encode(1));
        // }
        try {
          //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
          $data = DB::select('SELECT compras.Num_nota, compras.Fecha, proveedores.Nombre AS Proveedor,
                              materiales.Nombre as Material, compras.Cantidad, compras.Estado FROM `compras`
                              INNER JOIN proveedores ON compras.Proveedores_idProveedor = proveedores.id
                              INNER JOIN compras_has_mov_material ON compras_has_mov_material.Compras_idCompra = compras.id
                              INNER JOIN mov_materiales ON mov_materiales.id = compras_has_mov_material.Mov_material_idMov_material
                              INNER JOIN materiales ON materiales.id = mov_materiales.Materiales_idMateriale');
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function datosmaterial()
     {
         //
         try{
             // $data = Materiale::all();
             $data = DB::select('SELECT materiales.Nombre, materiales.id FROM `materiales`');
             return response()->json(json_encode($data));
         }
         catch(\Exception $e){
            return response()->json(json_encode(1));
         }
     }

     public function datosproveedor()
     {
         //
         try{
             // $data = Materiale::all();
             $data = DB::select('SELECT proveedores.Nombre, proveedores.id FROM `proveedores`');
             return response()->json(json_encode($data));
         }
         catch(\Exception $e){
            return response()->json(json_encode(1));
         }
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
