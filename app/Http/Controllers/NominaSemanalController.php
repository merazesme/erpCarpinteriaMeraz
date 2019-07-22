<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nomina;
use Illuminate\Support\Facades\DB;

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
      try{
          $data = DB::table('trabajadores')
                    ->select('id', 'Nombre', 'Asistencia_total', 'Bono_Produc_Asis', 'Bono_Extra', 'sb', 'montoHoraExtra', 'Infonavit')
                    ->where('Estado',1)
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
      catch(\Exception $e){
         return response()->json(1);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
      $data=new Nomina();
      $data->Fecha='2019-07-02';
      $data->idUsuario=1;
      $data->save();
      return response()->json($data);
      //return 'ok';
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
