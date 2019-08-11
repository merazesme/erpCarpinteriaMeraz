<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nomina;
use App\DetalleNomina;
use App\ConceptosNomina;
use App\Trabajador;
use App\TipoNomina;
use App\Prestamo;
use App\Mov_prestamo;
use Illuminate\Support\Facades\DB;
use DateTime;

class NominaController extends Controller
{
    /**
     * Muestra las vistas de nomina Semanal
     *
     *
     */
    public function nominaSemanal() {
        $modulo = "Nómina Semanal";
        return view('nomina/semanal/nominaSemanal', compact('modulo'));
    }

    public function detallesSemanal($semana) {
        $modulo = "Detalles de Nómina Semanal";
        return view('nomina/semanal/detalles', compact('modulo', 'semana'));
    }

    /**
     * Muestra las vistas de nomina Aguinaldo
     *
     *
     */
    public function nominaAguinaldo() {
        $modulo = "Nómina Aguinaldo";
        return view('nomina/aguinaldo/nominaAguinaldo', compact('modulo'));
    }

    public function detallesAguinaldo($anio) {
        $modulo = "Detalles de Nómina Aguinaldo";
        return view('nomina/aguinaldo/detalles', compact('modulo', 'anio'));
    }
    /**
     * Muestra las vistas de nomina Vacacional
     *
     *
     */
    public function nominaVacacional() {
        $modulo = "Nómina Vacacional";
        return view('nomina/vacacional/nominaVacacional', compact('modulo'));
    }

    public function detallesVacacional($anios) {
        $modulo = "Detalles de Nómina Vacacional";
        return view('nomina/vacacional/detalles', compact('modulo', 'anios'));
    }

    /**
     * Obtine los datos de las nominas guardadas
     *
     *
     */
    public function detalleNomina($semana, $fechai = null, $fechaf = null ) {
      try {
        // Se busca la nomina que se desea consultar
        $nomina = Nomina::where('Semana', '=', $semana)->firstOrFail();

        // Se obtienen los detalles de la nomina (cada trabajador)
        $nomina->detalleNomina = DetalleNomina::where('Nomina_idNomina', '=', $nomina->id)
                                                ->select('detalle_nominas.*', 'Nombre', 'Apellidos', 'Apodo', 'Asistencia_total', 'Sueldo')
                                                ->join('trabajadores', 'detalle_nominas.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                                                ->join('contratos', 'contratos.id', '=', 'detalle_nominas.Contratos_idContrato')
                                                ->get();

        // Se obtinen los conceptos de cada nomina correspondiente a cada trabajador
        foreach ($nomina->detalleNomina as $conceptosNomina) {
          $conceptos = ConceptosNomina::where('conceptos_nominas.DetalleNomina_idDetalleNomina',$conceptosNomina->id)
                                        ->get();
          // Si se mandan las fechas
          // ($fechai = primer dia de la semana)
          // ($fechaf = ultimo dia de la semana),
          // quiere decir que es una nomina semanal,
          // por lo tanto se obtienen los dias trabajados de esa semana
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

          // Se asignan los valores de la consulta al objeto
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
     * Obtine los datos de los trabajadores para generar la nomina semanal
     *
     *
     */
    public function trabajadores($fechai = null, $fechaf = null) {
      try {
          // Se buscan los trabajadores activos, ademas de el contrato que tienen vigente
          $data = DB::table('trabajadores')
                    ->select('trabajadores.id', 'contratos.id as contrato', 'Nombre' ,'Apellidos', 'Apodo', 'Asistencia_total', 'Bono_Produc_Asis', 'Bono_Extra', 'Sueldo', 'Monto_Hora_Extra', 'Infonavit')
                    ->join('contratos', 'contratos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                    ->where('trabajadores.Estado',1)
                    ->where('contratos.estado', 1)
                    ->get();

          // Si se mandan las fechas
          // ($fechai = primer dia de la semana)
          // ($fechaf = ultimo dia de la semana),
          // quiere decir que es una nomina semanal,
          // por lo tanto se obtienen los dias trabajados de esa semana
          if($fechai != null && $fechaf != null ) {
            // Se consulta el totaL de prestamos pendientes que tiene cada empleado
            foreach ($data as $trabajadores) {
              $monto = DB::table('trabajadores')
                        ->select(DB::raw('SUM(prestamos.Monto) as monto'))
                        ->join('prestamos', 'prestamos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                        ->where('trabajadores.id',$trabajadores->id)
                        ->where('prestamos.Estado', '=', 1)
                        ->first();

              // Se consulta cuanto ha pagado de los prestamos que tiene
              $abonoPrestamos = Prestamo::select(DB::raw('SUM(mov_prestamos.Abono) as abono'))
                                     ->where('Trabajadores_idTrabajador','=',$trabajadores->id)
                                     ->where('Estado', '=', 1)
                                     ->join('mov_prestamos', 'mov_prestamos.Prestamos_idPrestamo', '=', 'prestamos.id')
                                     ->first();

              // Se consultan las asistencias
              $asistencia = DB::table('trabajadores')
                        ->select('asistencias.Fecha', 'asistencias.Hora_extra', 'asistencias.Hora_entrada',
                                  'asistencias.Hora_salida')
                        ->join('asistencias', 'asistencias.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                        ->where('trabajadores.id',$trabajadores->id)
                        ->whereBetween('asistencias.Fecha', [$fechai, $fechaf])
                        ->get();

              // Se calcula cuanto es lo que debe de los prestamos y se asignan al objeto
              $trabajadores->totalPrestamos = $monto->monto - $abonoPrestamos->abono;

              // Se asignan las asistencias al objeto
              $trabajadores->asistencia = $asistencia;
            }
          }
         return response()->json($data);
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
      }
    }

    /**
     * Guarda todas las nominas, debe haber una estructura del objeto que se manda
     * (La estrcutura se construye desde el javascript)
     *
     */
    public function guardaNomina(Request $request) {
      try{
        // Consulta si existe el tipo de nomina, si no lo crea
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

          // Actualiza los dias trabajados del trabajador para obtener los de todo el año
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

                      // Se hac el descuento de los prestamos
                      if($data->Descripcion == 'Abono Prestamo')
                        $this->pagoPrestamo($valor, $trabajador['id']);
              }
          }
        }
        return response()->json(["success" => "Guardado exitosamente."]);
      }
      catch(\Exception $e){
         return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.'.$e]);
      }
    }

    // function object_to_array($obj) {
    //     $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    //     foreach ($_arr as $key => $val) {
    //             $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
    //             $arr[$key] = $val;
    //     }
    //     return $arr;
    //   }


    /**
     * Obtine las nominas que han sido guardadas por el tipo de nomina
     *
     *
     */
    public function historialNominaSemanal($tipo) {
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

    /**
     * Verfiica si la nomina ya se genero
     *
     *
     */
    public function validaNomina($numero) {
      try {
        $data = Nomina::where('Semana', '=', $numero)->firstOrFail();
        $anioActual = new DateTime();
        $anioBD = new DateTime($data->Fecha);
        if($anioActual->format('Y') == $anioBD->format('Y'))
          return response()->json($data);
        else
          return response()->json(['NotFound' => 'No se encontraron resultados de la consulta.']);
      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['NotFound' => 'No se encontraron resultados de la consulta.']);
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.']);
      }
    }


    /**
     * Metodo que hace el abono de los prestamos
     *
     *
     */
    public function pagoPrestamo($dinero, $id) {
      try {
          // Se selecciona el primer prestamo que tenga pendiente de pago
          $prestamo = Prestamo::select('id', 'Monto')
                                ->where('Trabajadores_idTrabajador', $id)
                                ->where('Estado', '=', 1)
                                ->first();
          if($prestamo ) {
          // Se obtine el total de los abonos de ese prestamo
          $abono = Mov_prestamo::select(DB::raw('SUM(Abono) as abono'))
                                 ->where('Prestamos_idPrestamo', $prestamo->id)
                                 ->first();

          // Se resta para saber cuanto es lo que debe
          $resta = $prestamo->Monto - $abono->abono;
          $pago = $dinero;

          // Si lo que se va a pagar es mayor o igual a lo que falta de pagar *
          if($dinero >= $resta) {
              $pago = $resta;
              $dinero -= $resta;
              // * Se actualiza el prestamo a Estado 2, porque ese prestamo ya esta liquidado **
              $prestamo->Estado = 2;
              $prestamo->save();
              // Se vuelve a llamar esta funcion (recursividad papá) para agregar en otro prestamo la cantidad que falta
              $this->pagoPrestamo($dinero, $id);
          }

          // Se guarda ese pago de prestamo
          $abonoPrestamo = new Mov_prestamo();
          $abonoPrestamo->Abono = $pago;
          $abonoPrestamo->Fecha = new DateTime();
          $abonoPrestamo->idUsuario = 1;
          $abonoPrestamo->Prestamos_idPrestamo = $prestamo->id;
          $abonoPrestamo->save();
         }
         return ['success' => 'No hay prestamos pendientes'];
      } catch (\Exception $e) {
        return response()->json(['Error'=>'Ha ocucurrido un erro al intentar acceder a los datos.'.$e]);
      }
    }
}
