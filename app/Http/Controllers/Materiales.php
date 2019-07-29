<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//modelo
use App\Materiale;
use DB;
class Materiales extends Controller
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
          //Funcion para traer datos de dos tablas por si la okupan aki ta un ejemplo vien shido
          $data = DB::select('SELECT materiales.id, materiales.Nombre, clasificacion_materiales.Concepto, materiales.Existencia, materiales.Estado
                              FROM `materiales`, `clasificacion_materiales`
                              WHERE clasificacion_materiales.id = materiales.Clasificacion_material_idClasificacion_material');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data=new Materiale();
        $data->Clasificacion_material_idClasificacion_material=$request->input('select_tipoMateriall');
        $data->Estado=$request->input('estado_material');
        $data->idUsuario=$request->input('idUsuario_material');
        $data->Existencia=$request->input('txtCantidadMaterial');
        $data->Nombre=$request->input('txtNombreMaterial');

        $data->save();
        return response()->json(json_encode(0));

        // $data=new Materiale();
        // $data->Nombre=$request->input('Perilla');
        // $data->Existencia=$request->input('20');
        // $data->Estado=$request->input('1');
        // $data->idUsuario=$request->input('1');
        // $data->Clasificacion_material_idClasificacion_material=('1');
        //
        // $data->save();
        // return response()->json(json_encode(0));
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
        try{
            $data = Materiale::find($id);
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
        //
        $data = Materiale::find($id);
        $data->Clasificacion_material_idClasificacion_material=$request->input('select_tipoMaterialModificar');
        $data->Estado=$request->input('estado_material');
        $data->idUsuario=$request->input('idUsuario_material');
        $data->Existencia=$request->input('txtCantidadMaterialModificar');
        $data->Nombre=$request->input('txtNombreMaterialModificar');

        $data->save();
        return response()->json(json_encode(0));
    }

    public function status($id)
    {
        //
        $data = Materiale::find($id);
        $data->Estado=('0');

        $data->save();
        return response()->json(json_encode(0));
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
