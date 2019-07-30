<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Configuracion;
class Configuraciones extends Controller
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
            $datos = Configuracion::all();
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
    public function storeGeneral(Request $request)
    {
        //
        try{
            $datos = Configuracion::all();
            if(sizeof($datos) > 0){
                $data = Configuracion::find($datos[0]->id);
            }else{
                $data=new Configuracion();
            }

            $data->IVA=$request->input('ivaConfig');
            $data->Minimo_caja_chica=$request->input('cajaConfig');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function storeHorario(Request $request)
    {
        //
        try{
            $datos = Configuracion::all();
            if(sizeof($datos) > 0){
                $data = Configuracion::find($datos[0]->id);
            }else{
                $data=new Configuracion();
            }

            $data->Hora_entrada=$request->input('entrada_LV');
            $data->Hora_salida=$request->input('salida_LV');

            $data->Hora_entrada_Sab=$request->input('entrada_S');
            $data->Hora_salida_Sab=$request->input('salida_S');

            $data->Hora_entrada_extra=$request->input('entrada_E');
            $data->Hora_salida_extra=$request->input('salida_E');

            $data->Hora_entrada_obra=$request->input('entrada_obra');
            $data->Hora_salida_obra=$request->input('salida_obra');

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
        try{
            if($id == 1){
                $datos = Configuracion::select('IVA','Minimo_caja_chica')->get();
            }else{
                $datos = Configuracion::select('Hora_entrada','Hora_salida',
                'Hora_entrada_Sab', 'Hora_salida_Sab',
                'Hora_entrada_extra', 'Hora_salida_extra',
                'Hora_entrada_obra', 'Hora_salida_obra')->get();
            }
             return response()->json(json_encode($datos));
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
