<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Materiale;
use App\Mov_materiale;
use App\Orden_salida;
use App\Salida_movmateriale;
use DB;

class Orden_salidas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function showTablaOrdenSalida()
     {
         //
         try {
           $data = DB::table('orden_salidas')
           ->join('trabajadores', 'trabajadores.id', '=', 'orden_salidas.Trabajadores_idTrabajadore')
            ->select('orden_salidas.id','orden_salidas.Num_nota','orden_salidas.Fecha', 'orden_salidas.Descripcion', 'orden_salidas.Estado', 'trabajadores.Nombre')
             ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function showTrabajadores()
     {
         //
         try {
           $data = DB::table('trabajadores')
            ->select('trabajadores.id','trabajadores.Nombre')
             ->where('trabajadores.Estado', '=', 1)
              ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function showMateriales()
     {
         //
         try {
           $data = DB::table('materiales')
            ->select('materiales.id','materiales.Nombre', 'materiales.Existencia')
             ->where('materiales.Estado', '=', 1)
              ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function showMaterialesExistencia($id)
     {
         //
         try {
           $data = DB::table('materiales')
            ->select('materiales.id','materiales.Nombre', 'materiales.Existencia')
             ->where('materiales.id', '=', $id)
              ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function update_materialExistencia(Request $request, $id)
     {
         //
         try
         {
           $materiales = Materiale::find($id);
           $materiales->Existencia=$request->input('Existencia');
           $materiales->idUsuario=$request->input('idUsuario');

           $materiales->save();

           return response()->json(json_encode(0));
         }
         catch(\Exception $e){
            return response()->json(json_encode(1));
         }
     }

     public function showOrdenSalida($id)
     {
         //
         try {
           $data = DB::table('orden_salidas')
            ->select('orden_salidas.Trabajadores_idTrabajadore','orden_salidas.Num_nota', 'orden_salidas.Descripcion')
             ->where('orden_salidas.id', '=', $id)
              ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function showOrdenSalidaDetalles($id)
     {
         //

         try {
           $data = DB::table('orden_salidas')
           ->join('salida_movmateriales', 'salida_movmateriales.Orden_salida_idOrden_Salidas', '=', 'orden_salidas.id')
            ->join('mov_materiales', 'mov_materiales.id', '=', 'salida_movmateriales.Mov_materiale_idMov_Materiales')
             ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
              ->select('mov_materiales.Cantidad','materiales.Nombre','materiales.Existencia', 'orden_salidas.Descripcion', 'mov_materiales.Materiales_idMateriale')
               ->where('orden_salidas.id', '=', $id)
                ->get();
           // dd($data);
           return response()->json(json_encode($data));
         } catch (\Exception $e) {
           return response()->json(json_encode(1));
         }
     }

     public function new_ordeSalida(Request $request)
     {
         //
         try
         {
           $data=new Orden_salida();
           $data->Num_nota=$request->input('Num_nota');
           $data->Fecha=$request->input('Fecha');
           $data->Estado=$request->input('Estado');
           $data->idUsuario=$request->input('idUsuario');
           $data->Descripcion=$request->input('Descripcion');
           $data->Trabajadores_idTrabajadore=$request->input('Trabajadores_idTrabajadore');

           $data->save();
           $data->id=$data->id;
           return response()->json(json_encode($data->id));
         }
         catch(\Exception $e){
            return response()->json(json_encode(-1));
         }
     }

     public function cancel_ordenSalida(Request $request, $id)
     {
         //
         // try
         // {
           $materiales = Orden_salida::find($id);
           $materiales->Estado=$request->input('Estado');
           $materiales->idUsuario=$request->input('idUsuario');

           $materiales->save();
           $materiales->id=$materiales->id;

           $data = DB::table('orden_salidas')
           ->join('salida_movmateriales', 'salida_movmateriales.Orden_salida_idOrden_Salidas', '=', 'orden_salidas.id')
            ->join('mov_materiales', 'mov_materiales.id', '=', 'salida_movmateriales.Mov_materiale_idMov_Materiales')
             ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
              ->select('mov_materiales.Cantidad','materiales.Nombre','materiales.Existencia', 'orden_salidas.Descripcion', 'mov_materiales.Materiales_idMateriale')
               ->where('orden_salidas.id', '=', $id)
                ->get();

           return response()->json(['id'=>$materiales->id, 'Cantidad' =>$data]);

           // return response()->json(json_encode($materiales->id));
         // }
         // catch(\Exception $e){
         //    return response()->json(json_encode(1));
         // }
     }

     public function update_ordenSalida(Request $request, $id)
     {
         //
         try
         {
           $Orden_salida = Orden_salida::find($id);
           $Orden_salida->Trabajadores_idTrabajadore=$request->input('Trabajadores_idTrabajadore');
           $Orden_salida->Num_nota=$request->input('Num_nota');
           $Orden_salida->Descripcion=$request->input('Descripcion');
           $Orden_salida->Fecha=$request->input('fecha');
           $Orden_salida->idUsuario=$request->input('idUsuario');

           $Orden_salida->save();

           return response()->json(json_encode(0));
         }
         catch(\Exception $e){
            return response()->json(json_encode(1));
         }
     }

     public function new_movmateriales(Request $request)
     {
         //
         try
         {
           $data=new Mov_materiale();
           $data->Tipo_mov=$request->input('Tipo_mov');
           $data->Cantidad=$request->input('Cantidad');
           $data->Fecha=$request->input('Fecha');
           $data->Estado=$request->input('Estado');
           $data->idUsuario=$request->input('idUsuario');
           $data->Materiales_idMateriale=$request->input('Materiales_idMateriale');

           $data->save();
           $data->id=$data->id;
           $Materialid = $request->input('Materiales_idMateriale');

           $material = DB::table('materiales')
            ->select('materiales.Existencia', 'materiales.id AS materialid')
             ->where('materiales.id', '=', $Materialid)
              ->get();

           return response()->json(['id'=>$data->id, 'Cantidad' =>$data->Cantidad, 'Existencia' => $material]);
           // return response()->json(json_encode();
         }
         catch(\Exception $e){
            return response()->json(json_encode(-1));
         }
     }

     public function new_salida_movmateriales(Request $request)
     {
         //
         try
         {
           $data=new Salida_movmateriale();
           $data->Mov_materiale_idMov_Materiales=$request->input('Mov_materiale_idMov_Materiales');
           $data->Orden_salida_idOrden_Salidas=$request->input('Orden_salida_idOrden_Salidas');
           $data->idUsuario=$request->input('idUsuario');

           $data->save();
           $data->id=$data->id;
           return response()->json(json_encode(0));
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
           $Orden_salida = Orden_salida::find($id);
           $Orden_salida->Estado=$request->input('Estado_Compra');
           $Orden_salida->Factura=$request->input('Factura');
           $Orden_salida->idUsuario=$request->input('idUsuario');

           $Orden_salida->save();

           return response()->json(json_encode(0));
         }
         catch(\Exception $e){
            return response()->json(json_encode(1));
         }
     }

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
