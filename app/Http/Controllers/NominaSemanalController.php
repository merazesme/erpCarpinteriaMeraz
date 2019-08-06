<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nomina;
use App\DetalleNomina;
use App\ConceptosNomina;
use App\Trabajador;
use App\TipoNomina;
use Illuminate\Support\Facades\DB;
use DateTime;

class NominaSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Nómina Semanal";
        return view('nomina/semanal/nominaSemanal', compact('modulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detalles($semana)
    {
        $modulo = "Detalles de Nómina Semanal";
        return view('nomina/semanal/detalles', compact('modulo', 'semana'));
    }

    public function detalleNomina($semana, $fechai = null, $fechaf = null ) {
      try {
        $nomina = Nomina::where('Semana', '=', $semana)->firstOrFail();

        $nomina->detalleNomina = DetalleNomina::where('Nomina_idNomina', '=', $nomina->id)
                                ->select('detalle_nominas.*', 'Nombre', 'Apellidos', 'Apodo', 'Asistencia_total', 'Sueldo')
                                ->join('trabajadores', 'detalle_nominas.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                                ->join('contratos', 'contratos.id', '=', 'detalle_nominas.Contratos_idContrato')
                                ->get();
        foreach ($nomina->detalleNomina as $conceptosNomina) {
          $conceptos = ConceptosNomina::where('conceptos_nominas.DetalleNomina_idDetalleNomina',$conceptosNomina->id)
                    ->get();
          if($fechai != null && $fechaf != null ) {
            $asistencia = DB::table('trabajadores')
                      ->select('asistencias.Fecha', 'asistencias.Hora_extra', 'asistencias.Hora_entrada',
                                'asistencias.Hora_salida')
                      ->join('asistencias', 'asistencias.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                      ->where('trabajadores.id',$conceptosNomina->Trabajadores_idTrabajador)
                      ->whereBetween('asistencias.Fecha', [$fechai, $fechaf])
                                ->get();
            $conceptosNomina->asistencia = $asistencia;
          }
          $conceptosNomina->conceptos = $conceptos;
        }
        return response()->json($nomina);
      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['NotFound' => 'No se encontraron resultados de la consulta.']);
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function trabajadores($fechai, $fechaf) {
      try {
          $data = DB::table('trabajadores')
                    ->select('trabajadores.id', 'contratos.id as contrato', 'Nombre' ,'Apellidos', 'Apodo', 'Asistencia_total', 'Bono_Produc_Asis', 'Bono_Extra', 'Sueldo', 'Monto_Hora_Extra', 'Infonavit')
                    ->join('contratos', 'contratos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                    ->where('trabajadores.Estado',1)
                    ->where('contratos.estado', 1)
                    ->get();

          foreach ($data as $trabajadores) { // Se consulta el totaL de prestamo que tiene cada empleado
            $monto = DB::table('trabajadores')
                      ->select(DB::raw('SUM(prestamos.Monto) as monto'))
                      ->join('prestamos', 'prestamos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                      ->where('trabajadores.id',$trabajadores->id)
                      ->first();
            //dd($monto->monto);
            $asistencia = DB::table('trabajadores')
                      ->select('asistencias.Fecha', 'asistencias.Hora_extra', 'asistencias.Hora_entrada',
                                'asistencias.Hora_salida')
                      ->join('asistencias', 'asistencias.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                      ->where('trabajadores.id',$trabajadores->id)
                      ->whereBetween('asistencias.Fecha', [$fechai, $fechaf])
                      ->get();
            //dd($monto->monto);
            $trabajadores->totalPrestamos = $monto->monto;
            $trabajadores->asistencia = $asistencia;
          }
         return response()->json($data);
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function nomina(Request $request)
    {
      try{
        $tipoNomina = TipoNomina::where('Concepto', '=', $request->input('tipo'))->first();
        if(!isset($tipoNomina)) {
          $tipoNomina = new TipoNomina;
          $tipoNomina->idUsuario = 1;
          $tipoNomina->Concepto  = $request->input('tipo');
          if(!$tipoNomina->save())
            return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
        }

        // Inserta una nueva nomina
        $nominaData = new Nomina();
        $nominaData->Fecha                     = new DateTime();
        $nominaData->idUsuario                 = 1;
        $nominaData->Tipo_nomina_idTipo_nomina = $tipoNomina->id;
        $nominaData->Semana                    = $request->input('semana');
        $nominaData->save();

        // Inserta los detalles de cada nomina para cada trabajador
        foreach ($request->trabajadores as $trabajador) {
          $dataDetalleNomina=new DetalleNomina();
          $dataDetalleNomina->Cantidad                  = $trabajador['xTotal'];
          $dataDetalleNomina->Fecha                     = new DateTime();
          $dataDetalleNomina->Estado                    = 1;
          $dataDetalleNomina->idUsuario                 = 1;
          $dataDetalleNomina->Nomina_idNomina           = $nominaData->id;
          $dataDetalleNomina->Trabajadores_idTrabajador = $trabajador['id'];
          $dataDetalleNomina->Contratos_idContrato      = $trabajador['contrato'];
          $dataDetalleNomina->save();
          if($request->input('tipo') == 'semanal') {
            $trabajadorAsistencia = Trabajador::find($trabajador['id']);
            $trabajadorAsistencia->Asistencia_total += $trabajador['diasTrabajados'] + 1;
            $trabajadorAsistencia->save();
          }
          // Inserta los conceptos de cada detalle de nomina de cada nomina
          $objNomina = $trabajador['Nomina'];
          $_arr = is_object($objNomina) ? get_object_vars($objNomina) : $objNomina;
          foreach ($_arr as $key => $val) {
              if($key == 'xPercepciones') $tipo = 1;
              else if($key == 'xDeducciones') $tipo = 0;
              foreach ($val as $concepto => $valor) {
                      $data = new ConceptosNomina();
                      $data->Descripcion                   = $concepto;
                      $data->Tipo                          = $tipo;
                      $data->idUsuario                     = 1;
                      $data->DetalleNomina_idDetalleNomina = $dataDetalleNomina->id;
                      $data->Monto                         = $valor;
                      $data->save();
              }
          }
        }
        return response()->json(["success" => "Guardado exitosamente."]);
      }
      catch(\Exception $e){
         return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.'.$e]);
      }
    }

    function object_to_array($obj) {
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach ($_arr as $key => $val) {
                $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
                $arr[$key] = $val;
        }
        return $arr;
      }

    public function historialNominaSemanal($tipo)
    {
      try {
          $tipoNomina = TipoNomina::where('Concepto', '=', $tipo)->first();
          if(!isset($tipoNomina)) {
              return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
          }
          $data = Nomina::join('usuarios', 'usuarios.id', '=', 'nominas.idUsuario')
                          ->select('usuarios.usuario', 'nominas.Fecha', 'nominas.Semana')
                          ->orderBy('nominas.Semana', 'desc')
                          ->where('nominas.Tipo_nomina_idTipo_nomina', '=', $tipoNomina->id)
                          ->get();
          return response()->json($data);
      } catch (\Exception $e) {
        return response()->json($e);
      }
    }

    public function validaNomina($numero) {
      try {
        $data = Nomina::where('Semana', '=', $numero)->firstOrFail();
        return response()->json($data);
      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['NotFound' => 'No se encontraron resultados de la consulta.']);
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
      }

    }


}
