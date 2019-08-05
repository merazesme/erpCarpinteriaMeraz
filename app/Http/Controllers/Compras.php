<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Compra;
use App\Materiale;
use App\proveedore;
use App\Mov_materiale;
use App\Compras_movmateriale;
use App\Pago_compra;
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

        // $data = DB::select('SELECT compras.id, compras.Num_nota, compras.Fecha, proveedores.Nombre AS Proveedor,
        //                     materiales.Nombre as Material, compras.Estado, compras.id FROM `compras`
        //                     INNER JOIN proveedores ON compras.Proveedores_idProveedor = proveedores.id
        //                     INNER JOIN compras_movmateriales ON compras_movmateriales.Compras_idCompra = compras.id
        //                     INNER JOIN mov_materiales ON mov_materiales.id = compras_movmateriales.Mov_material_idMov_material
        //                     INNER JOIN materiales ON materiales.id = mov_materiales.Materiales_idMateriale');

        try {
          //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
          $data = DB::select('SELECT compras.id, compras.Num_nota, compras.Fecha, proveedores.Nombre AS Proveedor, compras.Estado FROM `compras` INNER JOIN proveedores ON compras.Proveedores_idProveedor = proveedores.id');
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
             $data = DB::select('SELECT materiales.Nombre, materiales.id, materiales.Estado FROM  `materiales`');
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

     public function new_compra(Request $request)
     {
         //
         try
         {
           $compra = new Compra();
           $compra->Num_nota=$request->input('num_nota');
           $compra->Fecha=$request->input('Fecha');
           $compra->Estado=$request->input('EstadoCompra');
           $compra->idUsuario=$request->input('idUsuario');
           $compra->Proveedores_idProveedor=$request->input('Proveedores_idProveedor');

           $compra->save();
           $compra->id=$compra->id;

           return response()->json(json_encode($compra->id));
         }
         catch(\Exception $e){
            return response()->json(json_encode(-1));
         }
     }

    public function store(Request $request)
    {
        //
        try
        {
          //Aqui se hara el for para insertar los materiales de la compra
          //El arry Materiales_idMateriale
          $Mov_materiale = new Mov_materiale();

          $Mov_materiale->Cantidad=$request->input('CantidadMovMaterial');
          $Mov_materiale->Fecha=$request->input('Fecha');
          $Mov_materiale->idUsuario=$request->input('idUsuario');
          $Mov_materiale->Materiales_idMateriale=$request->input('Materiales_idMateriale');

          $Mov_materiale->save();
          $Mov_materiale->id=$Mov_materiale->id;


          $Compras_has_mov_materia = new Compras_movmateriale();
          $Compras_has_mov_materia->Compras_idCompra=$request->input('idCompra');
          $Compras_has_mov_materia->Mov_material_idMov_material=$Mov_materiale->id;
          $Compras_has_mov_materia->idUsuario=$request->input('idUsuario');

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
                   ->select('materiales.Nombre as Material','materiales.Existencia', 'mov_materiales.Cantidad', 'proveedores.id AS proid','proveedores.Adeudo', 'mov_materiales.Cantidad', 'mov_materiales.Materiales_idMateriale','mov_materiales.id AS movid', 'compras.Num_nota', 'compras.Estado', 'compras.id AS comid')
                    ->where('compras.id', '=', $id)
                     ->get();

            // dd($data);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

    }

    public function showAdeudoProveedor($id)
    {
        //
        try{
            //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
            $data = DB::table('proveedores')
             ->select('proveedores.id', 'proveedores.Adeudo')
              ->where('proveedores.id', '=', $id)
               ->get();

            // dd($data);
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

    }

    public function insertar_pago_proveedor(Request $request, $idprove)
    {
        //
        try
        {
          $proveedore = proveedore::find($idprove);
          $proveedore->Adeudo=$request->input('adeudo_sobrante');
          $proveedore->idUsuario=$request->input('idUsuario');

          $proveedore->save();

          $Pago_compra = new Pago_compra();
          $Pago_compra->Total=$request->input('Total');
          $Pago_compra->Fecha=$request->input('Fecha');
          $Pago_compra->Tipo_Pago=$request->input('Tipo_Pago');
          $Pago_compra->Num_cheque=$request->input('Num_cheque');
          $Pago_compra->idUsuario=$request->input('idUsuario');

          $Pago_compra->save();

          return response()->json(json_encode(0));
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
                   ->select('materiales.Existencia', 'materiales.id', 'mov_materiales.id AS movid', 'mov_materiales.Tipo_mov', 'proveedores.Adeudo', 'proveedores.id AS proveid')
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

    public function showcompras($id)
    {
        //
        try{
            //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
            // $data = DB::table('compras')
            //   ->join('proveedores', 'proveedores.id', '=', 'compras.Proveedores_idProveedor')
            //     ->join('compras_movmateriales', 'compras_movmateriales.Compras_idCompra', '=', 'compras.id')
            //      ->join('mov_materiales', 'mov_materiales.id', '=', 'compras_movmateriales.Mov_material_idMov_material')
            //       ->join('materiales', 'materiales.id', '=', 'mov_materiales.Materiales_idMateriale')
            //        ->select('compras.id', 'compras.Num_nota', 'materiales.Nombre', 'compras.Estado AS estatus')
            //          ->where('compras.Proveedores_idProveedor', '=', $id)
            //           ->get();

            $data = DB::table('compras')
              ->join('proveedores', 'proveedores.id', '=', 'compras.Proveedores_idProveedor')
                 ->select('compras.id', 'compras.Num_nota', 'compras.Estado AS estatus')
                   ->where('compras.Proveedores_idProveedor', '=', $id)
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
    public function update(Request $request, $idcompra)
    {
        //
        try
        {
          $compra = Compra::find($idcompra);
          $compra->Num_nota=$request->input('num_notaModificar');
          $compra->Estado=$request->input('Estado_Compra');
          $compra->Proveedores_idProveedor=$request->input('ProveedorSelect');
          $compra->idUsuario=$request->input('idUsuario');

          $compra->save();

          return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function actualizarcantidad(Request $request, $idMa, $idmov, $idprove, $idCompra)
    {
        //
        try
        {
          $material = Materiale::find($idMa);
          $material->Existencia=$request->input('total');
          $material->idUsuario=$request->input('idUsuario');

          $material->save();

          $Mov_materiale = Mov_materiale::find($idmov);
          $Mov_materiale->Tipo_mov=$request->input('Tipo_mov');
          $Mov_materiale->idUsuario=$request->input('idUsuario');

          $Mov_materiale->save();

          $proveedor = proveedore::find($idprove);
          $proveedor->Adeudo=$request->input('total_money');
          $proveedor->idUsuario=$request->input('idUsuario');

          $proveedor->save();

          $Compra = Compra::find($idCompra);
          $Compra->Estado=$request->input('Estado');
          $Compra->idUsuario=$request->input('idUsuario');

          $Compra->save();

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
          $compra->Factura=$request->input('Factura');
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
