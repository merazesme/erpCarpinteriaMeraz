<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

//modelo
use App\Cliente;
use App\Cotizacion;
class Clientes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $data = Cliente::all();
            return response()->json(json_encode($data));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }


    public function getCotizaciones($id){
        try{
            $data = Cotizacion::where('Clientes_idCliente', $id)->get();
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function getCotizacion($id){
        try{
            $sql = "SELECT `productos`.`id` AS idProducto, `productos`.`Descripcion` AS nombreProducto,
            `productos_has_cotizaciones`.`Productos_id` AS idProductoCotizacion, `productos_has_cotizaciones`.`Cantidad`,
            `productos_has_cotizaciones`.`subtotal`, `productos_has_cotizaciones`.`iva`, `productos_has_cotizaciones`.`total`,
            `productos_has_cotizaciones`.`Descripcion` AS descripcion
            FROM `productos`
            INNER JOIN `productos_has_cotizaciones` ON `productos_has_cotizaciones`.`Productos_id` = `productos`.`id`
            WHERE `productos_has_cotizaciones`.`Cotizaciones_id` = ?
            ORDER BY `productos`.`id` ASC";

            $cotizacion = DB::select($sql,array($id));
            foreach ($cotizacion as $key => $value) {
                $cotizacion[$key]->materiales = $this->getMateriales($value->idProducto);
            }
            return response()->json(json_encode($cotizacion));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function getMateriales($id){
        try {
            $data = DB::table('materia_primas')
            ->join('productos_has_materia_prima', 'productos_has_materia_prima.Materia_prima_idMateria_prima', '=', 'materia_primas.id')
            ->select('materia_primas.id', 'materia_primas.Descripcion')
            ->where('productos_has_materia_prima.Productos_idProducto', '=', $id)
            ->get();
            return $data;
        } catch (\Exception $e) {
            return "-1";
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

    public function listarClientes()
    {
        $clientes = Cliente::all();
        return $clientes;
    }

    public function store(Request $request)
    {
        //modelo
        try{
            $data=new Cliente();
            $data->Nombre=$request->input('txtNombre');
            $data->Apellidos=$request->input('txtApellidos');
            $data->Email=$request->input('txtEmail');
            $data->Telefono=$request->input('txtTelefono');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $data = Cliente::find($id);
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
    public function update(Request $request, $id)
    {
        try{
            $data = Cliente::find($id);
            $data->Nombre=$request->input('txtNombre');
            $data->Apellidos=$request->input('txtApellidos');
            $data->Email=$request->input('txtEmail');
            $data->Telefono=$request->input('txtTelefono');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado=$request->input('Estado');

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
    public function destroy(Request $request, $id)
    {
        //
        try{
            $data = Cliente::find($id);
            $data->Estado=$request->input('Estado');
            $data->idUsuario=$request->input('idUsuario');
            $data->save();
            return response()->json(json_encode(0));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }

    }
}
