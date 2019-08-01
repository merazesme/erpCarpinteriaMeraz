<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Compra;
use App\Materiale;
use App\proveedor;
use App\Mov_materiale;
use App\Compras_movmateriale;
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
                              materiales.Nombre as Material, compras.Cantidad, compras.Estado, compras.id FROM `compras`
                              INNER JOIN proveedores ON compras.Proveedores_idProveedor = proveedores.id
                              INNER JOIN compras_movmateriales ON compras_movmateriales.Compras_idCompra = compras.id
                              INNER JOIN mov_materiales ON mov_materiales.id = compras_movmateriales.Mov_material_idMov_material
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
             $data = DB::select('SELECT proveedores.Nombre, proveedores.id, proveedores.estatus FROM `proveedores`');
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
        try
        {
          $compra = new Compra();
          $compra->Num_nota=$request->input('num_nota');
          $compra->Fecha=$request->input('FechaCompra');
          $compra->Cantidad=$request->input('cantidadOrdenCompra');
          $compra->Estado=$request->input('EstadoCompra');
          $compra->idUsuario=$request->input('idUsuarioCompra');
          $compra->Proveedores_idProveedor=$request->input('Proveedores_idProveedor');

          $compra->save();
          $compra->id=$compra->id;


          $Mov_materiale = new Mov_materiale();

          $Mov_materiale->Cantidad=$request->input('CantidadMovMaterial');
          $Mov_materiale->Fecha=$request->input('FechaMovMaterial');
          $Mov_materiale->idUsuario=$request->input('idUsuarioMovMaterial');
          $Mov_materiale->Materiales_idMateriale=$request->input('Materiales_idMateriale');

          $Mov_materiale->save();
          $Mov_materiale->id=$Mov_materiale->id;


          $Compras_has_mov_materia = new Compras_movmateriale();
          $Compras_has_mov_materia->Compras_idCompra=$compra->id;
          $Compras_has_mov_materia->Mov_material_idMov_material=$Mov_materiale->id;
          $Compras_has_mov_materia->idUsuario=$request->input('idUsuariocompras_has_mov_material');

          $Compras_has_mov_materia->save();

          return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
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
        try{
            //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
            $data = DB::table('compras')
              ->join('proveedores', 'proveedores.id', '=', 'compras.Proveedores_idProveedor')
                ->join('compras_movmateriales', 'compras_movmateriales.Compras_idCompra', '=', 'compras.id')
                 ->join('mov_materiales', 'mov_materiales.id', '=', 'compras_movmateriales.Mov_material_idMov_material')
                  ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
                   ->select('compras.Num_nota', 'compras.Fecha', 'proveedores.Nombre AS Proveedor','proveedores.id AS Proid','materiales.id AS MaterialesId', 'materiales.Nombre as Material', 'compras.Cantidad', 'compras.Estado', 'compras.id')
                    ->where('compras.id', '=', $id)
                  ->get();

            // dd($data);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

    }

    public function cantidadMaterial($id)
    {
        //
        try{
            //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
            $data = DB::table('compras')
              ->join('proveedores', 'proveedores.id', '=', 'compras.Proveedores_idProveedor')
                ->join('compras_movmateriales', 'compras_movmateriales.Compras_idCompra', '=', 'compras.id')
                 ->join('mov_materiales', 'mov_materiales.id', '=', 'compras_movmateriales.Mov_material_idMov_material')
                  ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
                   ->select('materiales.Existencia', 'materiales.id', 'mov_materiales.id AS movid', 'mov_materiales.Tipo_mov')
                    ->where('compras.id', '=', $id)
                  ->get();

            // dd($data);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

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
        try{
            //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
            $data = DB::table('compras')
              ->join('proveedores', 'proveedores.id', '=', 'compras.Proveedores_idProveedor')
                ->join('compras_movmateriales', 'compras_movmateriales.Compras_idCompra', '=', 'compras.id')
                 ->join('mov_materiales', 'mov_materiales.id', '=', 'compras_movmateriales.Mov_material_idMov_material')
                  ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
                   ->select('mov_materiales.id')
                    ->where('compras.id', '=', $id)
                  ->get();

            // dd($data);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idcompra,$idmovmaterial)
    {
        //
        try
        {
          $compra = Compra::find($idcompra);
          $compra->Num_nota=$request->input('num_notaModificar');
          $compra->Cantidad=$request->input('cantidadOrdenCompra');
          $compra->Estado=$request->input('Estado_Compra');
          $compra->Proveedores_idProveedor=$request->input('ProveedorSelect');
          $compra->idUsuario=$request->input('idUsuario');

          $compra->save();

          $Mov_materiale = Mov_materiale::find($idmovmaterial);
          $Mov_materiale->Materiales_idMateriale=$request->input('NombreMaterial');
          $compra->idUsuario=$request->input('idUsuario');

          $Mov_materiale->save();

          return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function actualizarcantidad(Request $request, $id, $idmov)
    {
        //
        try
        {
          $material = Materiale::find($id);
          $material->Existencia=$request->input('total');

          $material->save();

          $Mov_materiale = Mov_materiale::find($idmov);
          $Mov_materiale->Tipo_mov=$request->input('Tipo_mov');

          $Mov_materiale->save();

          return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function cancelar(Request $request, $id)
    {
        //
        try
        {
          $compra = Compra::find($id);
          $compra->Estado=$request->input('Estado_Compra');
          $compra->idUsuario=$request->input('idUsuario');

          $compra->save();

          return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
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
