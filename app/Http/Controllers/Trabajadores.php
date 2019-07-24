<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

//Importar Modelo
use App\Trabajador;
use App\Contrato;

class Trabajadores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $final = DB::table('trabajadores')
              ->join('contratos', 'contratos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                ->select('trabajadores.id', 'trabajadores.Nombre', 'trabajadores.Apellidos', 'contratos.Puesto', 'contratos.Fecha_final')
                  ->get();

            return $final;
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
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
        try
        {
          $trabajador = new Trabajador();
          $trabajador->Nombre=$request->input('nombre');
          $trabajador->Apellidos=$request->input('apellidos');
          $trabajador->Apodo=$request->input('apodo');
          $trabajador->Fecha_nacimiento=$request->input('fecha_nacimiento');
          $trabajador->Lugar_nacimiento=$request->input('lugar_nacimiento');
          $trabajador->Celular=$request->input('celular');
          $trabajador->Num_alternativo=$request->input('numero_alternativo');
          $trabajador->NSS=$request->input('NSS');
          $trabajador->Estado_civil=$request->input('estado_civil');
          $trabajador->Domicilio=$request->input('domicilio');
          $trabajador->Num_credencial=$request->input('numero_credencial');
          $trabajador->Infonavit=$request->input('infonavit');
          $trabajador->Escolaridad=$request->input('escolaridad');
          $trabajador->Asistencia_total=0;
          $trabajador->Firma=$request->input('firma');
          $trabajador->Tipo=1;
          $trabajador->Nacionalidad='Mexicano';
          $trabajador->Estado=1;
          $trabajador->idUsuario=$request->input('idUsuario');

          $trabajador->save();
          $trabajador->id=$trabajador->id;

          $contrato = new Contrato();
          $contrato->Puesto=$request->input('puesto');
          $contrato->Fecha_inicio=$request->input('fecha_inicio');
          $contrato->Fecha_final=$request->input('fecha_final');
          $contrato->Sueldo=$request->input('sueldo');
          $contrato->Documento="Hola";
          $contrato->Monto_Hora_Extra=$request->input('hora_extra');
          $contrato->Bono_extra=$request->input('bono_extra');
          $contrato->Bono_produc_asis=$request->input('bono_asistencia');
          $contrato->estado=1;
          $contrato->idUsuario=$request->input('idUsuario');
          $contrato->Trabajadores_idTrabajador=$trabajador->id;

          $contrato->save();

          return response()->json(['success'=>'Se agrego exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
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
