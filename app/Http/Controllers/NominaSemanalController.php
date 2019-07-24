<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nomina;
use App\DetalleNomina;
use App\ConceptosNomina;
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
        return view('nomina/nominaSemanal', compact('modulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function trabajadores() {

          $data = DB::table('trabajadores')
                    ->select('trabajadores.id', 'Nombre' ,'Apellidos', 'Apodo', 'Asistencia_total', 'Bono_Produc_Asis', 'Bono_Extra', 'Sueldo', 'Monto_Hora_Extra', 'Infonavit')
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
            $trabajadores->totalPrestamos = $monto->monto;
          }
         return response()->json($data);
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
        // Inserta una nueva nomina
        $nominaData=new Nomina();
        $nominaData->Fecha= new DateTime();
        $nominaData->idUsuario=1;
        $nominaData->Tipo_nomina_idTipo_nomina= 2;
        $nominaData->save();

        // Inserta los detalles de cada nomina para cada trabajador
        foreach ($request->trabajadores as $trabajador) {
          $dataDetalleNomina=new DetalleNomina();
          $dataDetalleNomina->Cantidad= $trabajador['xTotal'];
          $dataDetalleNomina->Fecha=new DateTime();
          $dataDetalleNomina->Estado= 1;
          $dataDetalleNomina->idUsuario = 1;
          $dataDetalleNomina->Nomina_idNomina = $nominaData->id;
          $dataDetalleNomina->Trabajadores_idTrabajador = $trabajador['id'];
          $dataDetalleNomina->save();

          // Inserta los conceptos de cada detalle de nomina de cada nomina
          $objNomina = $trabajador['Nomina'];
          $_arr = is_object($objNomina) ? get_object_vars($objNomina) : $objNomina;
          foreach ($_arr as $key => $val) {
              if($key == 'xPercepciones') $tipo = 1;
              else if($key == 'xDeducciones') $tipo = 0;
              foreach ($val as $concepto => $valor) {
                      $data=new ConceptosNomina();
                      $data->Descripcion= $concepto;
                      $data->Tipo = $tipo;
                      $data->idUsuario = 1;
                      $data->DetalleNomina_idDetalleNomina = $dataDetalleNomina->id;
                      $data->Monto = $valor;
                      $data->save();
              }
          }
        }
        return response()->json($data);
      }
      catch(\Exception $e){
         return response()->json(1);
      }
    }

    public function detalleNomina(Request $request) {

        foreach ($request->trabajadores as $trabajador) {

          $data=new DetalleNomina();
          $data->Cantidad= $trabajador['xTotal'];
          $data->Fecha=new DateTime();
          $data->Estado= 1;
          $data->idUsuario = 1;
          $data->Nomina_idNomina = 21;
          $data->Trabajadores_idTrabajador = 1;
          $data->save();
          //conceptoNomina($trabajador);
          //return response()->json($trabajador);
        }
       return response()->json($data);

    }

    public function conceptoNomina(Request $request) {
      try{
        $objNomina = $request->trabajadores['Nomina'];
        $_arr = is_object($objNomina) ? get_object_vars($objNomina) : $objNomina;
        foreach ($_arr as $key => $val) {
            if($key == 'xPercepciones') $tipo = 1;
            else if($key == 'xDeducciones') $tipo = 0;
            foreach ($val as $concepto => $valor) {
                    $data=new ConceptosNomina();
                    $data->Descripcion= $concepto;
                    $data->Tipo = $tipo;
                    $data->idUsuario = 1;
                    $data->DetalleNomina_idDetalleNomina = 29;
                    $data->Monto = $valor;
                    $data->save();
            }
        }
      }
      catch(\Exception $e){
         return response()->json(1);
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
