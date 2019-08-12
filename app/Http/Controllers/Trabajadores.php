<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Crypt;

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
                ->select('trabajadores.id as id_trabajador', 'trabajadores.Nombre', 'trabajadores.Apellidos',
                          'trabajadores.Estado as trabajador_estado', 'contratos.id as id_contrato', 'contratos.Puesto',
                          'contratos.Estado as contrato_estado', 'contratos.Fecha_final')
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
          $trabajador->Firma=bcrypt($request->input('firma'));
          $trabajador->Tipo=$request->input('tipo');
          $trabajador->Nacionalidad=$request->input('nacionalidad');
          $trabajador->Estado=1;
          $trabajador->idUsuario=$request->input('idUsuario');

          $trabajador->save();
          $trabajador->id=$trabajador->id;

          $contrato = new Contrato();
          $contrato->Puesto=$request->input('puesto');
          $contrato->Tiempo=$request->input('tiempo');
          $contrato->Fecha_inicio=$request->input('fecha_inicio');
          $contrato->Fecha_final=$request->input('fecha_final');
          $contrato->Sueldo=$request->input('sueldo');
          $contrato->Documento="Hola";
          $contrato->Monto_Hora_Extra=$request->input('hora_extra');
          $contrato->Bono_extra=$request->input('bono_extra');
          $contrato->Bono_produc_asis=$request->input('bono_asistencia');
          $contrato->Estado=1;
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
        try{
            $final = DB::table('trabajadores')
              ->join('contratos', 'contratos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                ->where('trabajadores.id', '=', $id)
                  ->get();

            return $final;
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
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
        try
        {
          $trabajador = Trabajador::find($id);
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
          if($request->input('cambiarFirma')==1){
            $trabajador->Firma=bcrypt($request->input('firma'));
          }
          $trabajador->Tipo=$request->input('tipo');
          $trabajador->Nacionalidad=$request->input('nacionalidad');
          // $trabajador->Estado=1;
          $trabajador->idUsuario=$request->input('idUsuario');

          $trabajador->save();

          $contratos = DB::table('contratos')
            ->where('id', $request->input('id_contrato'))
              ->update(
                ['Puesto' => $request->input('puesto'),
                'Tiempo' => $request->input('tiempo'),
                'Fecha_inicio' => $request->input('fecha_inicio'),
                'Fecha_final' => $request->input('fecha_final'),
                'Sueldo' => $request->input('sueldo'),
                'Documento' => 'Hola',
                'Monto_Hora_Extra' => $request->input('hora_extra'),
                'Bono_extra' => $request->input('bono_extra'),
                'Bono_produc_asis' => $request->input('bono_asistencia'),
                'idUsuario' => $request->input('idUsuario')]
              );

          return response()->json(['success'=>'Se agrego exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function liquidar(Request $request, $id)
    {
        try
        {
          // GENERAR LIQUIDACION


          // CAMBIAR ESTADO DEL CONTRATO
          $contratos = DB::table('contratos')
            ->where('Trabajadores_idTrabajador',$id)
              ->update(
                ['Estado' => 0,
                'idUsuario' => $request->input('idUsuario')]
              );

          // CAMBIAR ESTADO TRABAJADOR ACTIVO
          $trabajador = DB::table('trabajadores')
            ->where('id',$id)
              ->update(
                ['Estado' => 0,
                'idUsuario' => $request->input('idUsuario')]
              );

          return response()->json(['success'=>'Se liquido exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function contratar(Request $request, $id)
    {
        try
        {
          // SE ACTUALIZAN LOS DATOS DE TRABAJADOR
          $trabajador = Trabajador::find($id);
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
          if($request->input('cambiarFirma')==1){
            $trabajador->Firma=bcrypt($request->input('firma'));
          }
          $trabajador->Tipo=$request->input('tipo');
          $trabajador->Nacionalidad=$request->input('nacionalidad');
          $trabajador->Estado=1;
          $trabajador->idUsuario=$request->input('idUsuario');

          $trabajador->save();

          // SE AGREGA EL NUEVO CONTRATO
          $contrato = new Contrato();
          $contrato->Puesto=$request->input('puesto');
          $contrato->Tiempo=$request->input('tiempo');
          $contrato->Fecha_inicio=$request->input('fecha_inicio');
          $contrato->Fecha_final=$request->input('fecha_final');
          $contrato->Sueldo=$request->input('sueldo');
          $contrato->Documento="Hola";
          $contrato->Monto_Hora_Extra=$request->input('hora_extra');
          $contrato->Bono_extra=$request->input('bono_extra');
          $contrato->Bono_produc_asis=$request->input('bono_asistencia');
          $contrato->Estado=1;
          $contrato->idUsuario=$request->input('idUsuario');
          $contrato->Trabajadores_idTrabajador=$id;

          $contrato->save();

          return response()->json(['success'=>'Se contrato exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
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
