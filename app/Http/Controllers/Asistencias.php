<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Log;
use DateTime;

//Importar Modelo
use App\Asistencia;
use App\Trabajador;
use App\Configuracion;

class Asistencias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
          $trabajadores = DB::table('trabajadores')
            ->select('id as id_trabajador', 'Nombre', 'Apellidos')
              ->where('Estado', '=', 1)
                ->get();

          date_default_timezone_set("America/Mazatlan");
          $fecha = new DateTime();
          $fecha = date_format($fecha, 'Y-m-d');

          $asistencia = DB::table('asistencias')
            ->select('id', 'Trabajadores_idTrabajador as id_trabajador', 'Hora_entrada', 'Hora_salida',
                     'Hora_extra')
              ->where('Fecha', '=', $fecha)
                ->get();

            return response()->json(['asistencia'=>$asistencia, 'trabajadores'=>$trabajadores]);
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
          date_default_timezone_set("America/Mazatlan");
          $fecha = new DateTime();
          $fecha = date_format($fecha, 'Y-m-d');

          // VERIFICA SI ALGUNA ASISTENCIA SE AGREGO O CAMBIO
          if($request->tamañoTodos >= 1) {
            // NO TIENE ELEMENTOS
            // hacer una consulta que todas las fechas de ese dia tengan 0
            // CHECA SI YA EXISTE UN REGISTRO CON LA ASISTENCIA DEL TRABAJADOR CON LA FECHA DE HOY
            foreach ($request->idsTodos as $id) {
              // CHECA SI YA EXISTE UN REGISTRO CON LA ASISTENCIA DEL TRABAJADOR CON LA FECHA DE HOY
              $idTrabajador = DB::table('asistencias')
                ->select('id')
                  ->where('Trabajadores_idTrabajador', '=', $id)
                    ->where('Fecha', '=', $fecha)
                      ->get();

              // COMPARA SI YA EXISTE ESE REGISTRO EN LA BD
              $result = sizeof($idTrabajador);
              if($result == 0) {
                // NO TIENE HECHO EL REGISTRO
                // CREA REGISTRO DE ASISTENCIA
                $asistencias = new Asistencia();
                $asistencias->Fecha=$fecha;
                $asistencias->idUsuario=$request->idUsuario;
                $asistencias->Trabajadores_idTrabajador=$id;

                $asistencias->save();
              }

              $nuevoMañana = 0;
              $nuevoTarde = 0;
              $nuevoHoraExtra = 0;

              // VERIFICAR SI TAMBIEN FUE EN LA MAÑANA
              $bandera = false;
              if($request->tamañoMañana >= 1) {
                foreach ($request->idsMañana as $idM) {
                  if($id == $idM){
                    $bandera = true;
                  }
                }
                if($bandera == true){
                  $nuevoMañana=$request->diferenciaMañana;
                }
              }

              // VERIFICAR SI TAMBIEN FUE EN LA TARDE
              $bandera2 = false;
              if($request->tamañoTarde >= 1) {
                foreach ($request->idsTarde as $idT) {
                  if($id == $idT){
                    $bandera2 = true;
                  }
                }
                if($bandera2 == true){
                  $nuevoTarde=$request->diferenciaTarde;
                }
              }

              // VERIFICAR SI TAMBIEN FUE A LA HORA EXTRA
              $bandera3 = false;
              if($request->tamañoHoraExtra >= 1) {
                foreach ($request->idsHoraExtra as $idH) {
                  if($id == $idH){
                    $bandera3 = true;
                  }
                }
                if($bandera3 == true){
                  $nuevoHoraExtra=$request->diferenciaHoraExtra;
                }
              }

              // ACTUALIZAR REGISTRO
              $actualizar = DB::table('asistencias')
                ->where('Fecha', $fecha)
                  ->where('Trabajadores_idTrabajador', $id)
                    ->update(
                      ['Hora_entrada' => $nuevoMañana,
                      'Hora_salida'   => $nuevoTarde,
                      'Hora_extra'    => $nuevoHoraExtra,
                      'idUsuario'     => $request->idUsuario]
                    );
            }
          }

          // VERIFICA SI ALGUNA USUARIO YA AGREGADO NO TIENE NIGUNA ASISTENCIA
          if($request->tamañoFaltas >= 1) {
            foreach ($request->idsFaltas as $id) {
              // ACTUALIZAR REGISTRO
              $actualizar = DB::table('asistencias')
                ->where('Fecha', $fecha)
                  ->where('Trabajadores_idTrabajador', $id)
                    ->update(
                      ['Hora_entrada' => 0,
                      'Hora_salida'   => 0,
                      'Hora_extra'    => 0,
                      'idUsuario'     => $request->idUsuario]
                    );
            }
          }

          return response()->json(['success'=>'Se agrego exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function horarios()
    {
        try
        {
          $horarios = DB::table('configuracions')
            ->get();

          return $horarios;
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
