<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Hash;

use App\Prestamo;
use App\Trabajador;
use App\Mov_prestamo;

class Prestamos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $prestamos = DB::table('prestamos')
              ->join('trabajadores', 'trabajadores.id', '=', 'prestamos.Trabajadores_idTrabajador')
                ->select('trabajadores.id as id_trabajador', 'trabajadores.Nombre', 'trabajadores.Apellidos',
                         'prestamos.id as id_prestamo', 'prestamos.Monto')
                  ->where('prestamos.Estado', '=', 1)
                    ->get();

            $movimientos = DB::table('prestamos')
              ->join('mov_prestamos', 'mov_prestamos.Prestamos_idPrestamo', '=', 'prestamos.id')
                ->select('mov_prestamos.Abono', 'prestamos.Trabajadores_idTrabajador as id_trabajador','prestamos.id as id_prestamo')
                  ->where('prestamos.Estado', '=', 1)
                    ->get();

            return response()->json(['prestamos'=>$prestamos, 'movimientos'=>$movimientos]);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function trabajadores()
    {
        try{
            $trabajadores = DB::table('trabajadores')
              ->select('id as id_trabajador', 'Nombre', 'Apellidos')
                  ->where('Estado', '=', 1)
                    ->get();

            return $trabajadores;
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function verificarFirma($id, $firma)
    {
        try
        {
          $firma_BD = DB::table('trabajadores')
            ->select('Firma')
              ->where('id', '=', $id)
                ->get();

          $firma_BD = $firma_BD[0]->Firma;

          if (Hash::check($firma, $firma_BD)){
            return response()->json(['success'=>'La firma coincide']);
          }
          else{
            return response()->json(['fail'=>'La firma no coinciden']);
          }
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
          $prestamo = new Prestamo();
          $prestamo->Concepto=$request->input('concepto');
          $prestamo->Monto=$request->input('montoPrestamo');
          $prestamo->Fecha=$request->input('fecha');
          $prestamo->Descripción=$request->input('descripcion');
          $prestamo->Estado=1;
          $prestamo->idUsuario=$request->input('idUsuario');
          $prestamo->Trabajadores_idTrabajador=$request->input('id_trabajador');

          $prestamo->save();

          return response()->json(['success'=>'Se agrego exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function movimiento(Request $request)
    {
        try
        {
          $movimiento = new Mov_prestamo();
          $movimiento->Abono=$request->input('montoAbono');
          $movimiento->Fecha=$request->input('fecha');
          $movimiento->idUsuario=$request->input('idUsuario');
          $movimiento->Prestamos_idPrestamo=$request->input('id_pre');

          $movimiento->save();

          return response()->json(['success'=>'Se agrego exitosamente']);
        }
        catch(\Exception $e){
           return response()->json(['error'=>'Ocurrio un error']);
        }
    }

    public function movimientosPrestamo($id_prestamo)
    {
        try{
            $movimientos = DB::table('prestamos')
              ->join('mov_prestamos', 'mov_prestamos.Prestamos_idPrestamo', '=', 'prestamos.id')
                ->where('prestamos.Estado', '=', 1)
                  ->where('prestamos.id', '=', $id_prestamo)
                    ->get();

            return $movimientos;
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
    public function edit($id, $estado)
    {
        try{
            $final = DB::table('prestamos')
              ->join('trabajadores', 'trabajadores.id', '=', 'prestamos.Trabajadores_idTrabajador')
                ->select('trabajadores.id as id_trabajador', 'trabajadores.Nombre', 'trabajadores.Apellidos',
                         'prestamos.id as id_prestamo', 'prestamos.Concepto', 'prestamos.Monto',
                         'prestamos.Descripción', 'prestamos.Estado as prestamo_estado', 'prestamos.Fecha')
                  ->where('prestamos.Trabajadores_idTrabajador', '=', $id)
                    ->where('prestamos.Estado', '=', $estado)
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
          $prestamos = Prestamo::find($id);
          $prestamos->Concepto=$request->input('concepto');
          $prestamos->Descripción=$request->input('descripcion');
          $prestamos->idUsuario=$request->input('idUsuario');

          $prestamos->save();

          return response()->json(['success'=>'Se agrego exitosamente']);
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
