<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Cotizacion;
use App\Cliente;
use App\Recomendacion;
use App\Producto;
use App\Materia_Prima;
use App\Producto_MateriaPrima;
use App\Configuracion;
use App\Producto_Cotizacion;

class Cotizaciones extends Controller
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


    public function getIVA()
    {
        //
        try{
             $datos = Configuracion::select('IVA')->get();
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listRecomendados()
    {
        //
        try{
             $datos = Recomendacion::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listClientes()
    {
        //
        try{
             $datos = Cliente::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listProductos()
    {
        //
        try{
             $datos = Producto::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listMateria()
    {
        //
        try{
             $datos = Materia_Prima::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
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
        try{
            $data=new Cotizacion();

            $data->Descripcion=$request->input('descripcion');
            $data->Estado="3";
            $data->Prioridad=$request->input('prioridad');
            $data->Documento=$request->input('documento');
            $data->Costo=$request->input('costo');
            $data->idUsuario=$request->input('idUsuario');
            $data->Clientes_idCliente=$request->input('idCliente');


            if(!empty( $request->input('idRecomendado'))){
                $data->Recomendacion_idRecomendacion=$request->input('idRecomendado');
                $data->porcentaje_recomendacion=$request->input('porcentaje');
            }

            $productos = json_decode($request->input('productos'));
            if($data->save()){
                foreach ($productos as $key => $value) {
                    $dataPC=new Producto_Cotizacion();
                    $dataPC->Cotizaciones_id=$data->id;
                    $dataPC->Productos_id=$value->idProducto;
                    $dataPC->Cantidad=$value->cantidad;
                    $dataPC->Descripcion=$value->descripcion;
                    $dataPC->subtotal=$value->subtotal;
                    $dataPC->iva=$value->iva;
                    $dataPC->total=$value->total;

                    $dataPC->idUsuario=$request->input('idUsuario');
                    if(!$dataPC->save()){
                        return response()->json(json_encode(-1));
                    }
                }
            }
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode($e));
       }
    }

    public function storeRecomendado(Request $request)
    {
        //
        try{
            $data=new Recomendacion();

            $data->Nombre=$request->input('nombreReco');
            $data->Porcentaje=$request->input('porcentajeReco');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado="0";

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function storeProducto(Request $request)
    {
        //
        try{
            $data=new Producto();

            $data->Descripcion=$request->input('descripcionProducto');
            $data->Subtotal=$request->input('subtotalProducto');
            $data->IVA=$request->input('ivaProducto');
            $data->Total=$request->input('totalProducto');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado="0";

            $materia = json_decode($request->input('materiaPrima'));
            if($data->save()){
                foreach ($materia as $key => $value) {
                    $dataPM=new Producto_MateriaPrima();
                    $dataPM->Productos_idProducto=$data->id;
                    $dataPM->Materia_prima_idMateria_prima=$value;

                    $dataPM->idUsuario=$request->input('idUsuario');
                    if(!$dataPM->save()){
                        return response()->json(json_encode(-1));
                    }
                }
            }
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
    }

    public function showRecomendado($id)
    {
        //
        try{
            $data = Recomendacion::find($id);
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function showProducto($id)
    {
        //
        try{
            // $data = Producto::find($id);
            $final = DB::table('productos')
              ->join('productos_has_materia_prima', 'productos_has_materia_prima.Productos_idProducto', '=', 'productos.id')
                ->where('productos.id', '=', $id)
                  ->get();
            return response()->json(json_encode($final));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function showProductoMaterial($id)
    {
        //
        try{
            // $data = Producto::find($id);
            $final = DB::table('productos')
                ->join('productos_has_materia_prima', 'productos_has_materia_prima.Productos_idProducto', '=', 'productos.id')
                ->join('materia_primas', 'productos_has_materia_prima.Materia_prima_idMateria_prima', '=', 'materia_primas.id')
                ->where('productos.id', '=', $id)
                ->select('productos.id', 'productos.Descripcion', 'productos.Subtotal', 'productos.IVA', 'productos.Total',
                    'materia_primas.id AS idMateria', 'materia_primas.Descripcion AS descripcionMateria')
                ->get();
            return response()->json(json_encode($final));
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

    public function updateRecomendado(Request $request, $id)
    {
        //
        try{
            $data = Recomendacion::find($id);

            $data->Nombre=$request->input('nombreReco');
            $data->Porcentaje=$request->input('porcentajeReco');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
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
