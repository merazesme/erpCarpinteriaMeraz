<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Producto;
use App\Materia_Prima;
use App\Producto_MateriaPrima;
use DB;

class Productos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
          $data = DB::table('productos')
           ->select('productos.id','productos.Descripcion','productos.Subtotal', 'productos.IVA', 'productos.Total', 'productos.Estado', 'productos.Fecha', 'productos.Costo_adicional')
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function IVA()
    {
        //
        try {
          $data = DB::table('configuracions')
           ->select('configuracions.IVA')
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function showMateriaPrima()
    {
        //
        try {
          $data = DB::table('materia_primas')
           ->select('materia_primas.id','materia_primas.Descripcion','materia_primas.Unidad_de_medida', 'materia_primas.Precio_por_unidad', 'materia_primas.Estado')
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function showMateriaPrimaEspecifico($id)
    {
        //
        try {
          $data = DB::table('materia_primas')
           ->select('materia_primas.id','materia_primas.Descripcion','materia_primas.Unidad_de_medida', 'materia_primas.Precio_por_unidad', 'materia_primas.Estado')
            ->where('materia_primas.id', '=', $id)
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function showProductoEspecifico($id)
    {
        //
        try {
          $data = DB::table('productos')
          ->join('productos_has_materia_prima', 'productos_has_materia_prima.Productos_idProducto', '=' , 'productos.id')
           ->join('materia_primas', 'materia_primas.id', '=' , 'productos_has_materia_prima.Materia_prima_idMateria_prima')
            ->select('productos.id','productos.Descripcion','productos.Subtotal', 'productos.IVA', 'productos.Total', 'productos.Estado', 'productos.Fecha', 'productos.Costo_adicional', 'materia_primas.id AS Mateid')
             ->where('productos.id', '=', $id)
              ->get();

          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function new_producto(Request $request)
    {
        //
        try
        {
          $data=new Producto();
          $data->Descripcion=$request->input('Descripcion');
          $data->Subtotal=$request->input('Subtotal');
          $data->Costo_adicional=$request->input('Costo_adicional');
          $data->IVA=$request->input('IVA');
          $data->Total=$request->input('Total');
          $data->idUsuario=$request->input('idUsuario');
          $data->Fecha=$request->input('Fecha');
          $data->Estado=$request->input('Estado');

          $data->save();
          $data->id=$data->id;
          return response()->json(json_encode($data->id));
        }
        catch(\Exception $e){
           return response()->json(json_encode(-1));
        }
    }

    public function update_producto(Request $request, $id)
    {
        //
        try
        {
          $data = Producto::find($id);
          $data->Descripcion=$request->input('Descripcion');
          $data->Subtotal=$request->input('Subtotal');
          $data->Costo_adicional=$request->input('Costo_adicional');
          $data->IVA=$request->input('IVA');
          $data->Total=$request->input('Total');
          $data->idUsuario=$request->input('idUsuario');
          $data->Estado=$request->input('Estado');

          $data->save();
          $data->id=$data->id;
          return response()->json(json_encode($data->id));
        }
        catch(\Exception $e){
           return response()->json(json_encode(-1));
        }
    }

    public function new_producto_has_prima(Request $request)
    {
        //
        try
        {
          $data=new Producto_MateriaPrima();
          $data->Productos_idProducto=$request->input('Productos_idProducto');
          $data->Materia_prima_idMateria_prima=$request->input('Materia_prima_idMateria_prima');
          $data->idUsuario=$request->input('idUsuario');

          $data->save();
          $data->id=$data->id;
          return response()->json(json_encode($data->id));
        }
        catch(\Exception $e){
           return response()->json(json_encode(-1));
        }
    }

    public function update_producto_has_prima(Request $request)
    {
        //
        try
        {
          $data=new Producto_MateriaPrima();
          $data->Productos_idProducto=$request->input('Productos_idProducto');
          $data->Materia_prima_idMateria_prima=$request->input('Materia_prima_idMateria_prima');
          $data->idUsuario=$request->input('idUsuario');

          $data->save();
          $data->id=$data->id;
          return response()->json(json_encode($data->id));
        }
        catch(\Exception $e){
           return response()->json(json_encode(-1));
        }
    }

    public function cancelar(Request $request, $id)
    {
        //
        try
        {
          $data = Producto::find($id);
          $data->idUsuario=$request->input('idUsuario');
          $data->Estado=$request->input('Estado');

          $data->save();
          $data->id=$data->id;
          return response()->json(json_encode($data->id));
        }
        catch(\Exception $e){
           return response()->json(json_encode(-1));
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
