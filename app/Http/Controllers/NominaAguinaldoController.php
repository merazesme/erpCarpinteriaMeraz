<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NominaAguinaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Nómina Aguinaldo";
        return view('nomina/aguinaldo/nominaAguinaldo', compact('modulo'));
    }

    public function detalles($anio)
    {
        $modulo = "Detalles de Nómina Aguinaldo";
        return view('nomina/aguinaldo/detalles', compact('modulo', 'anio'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $data = DB::table('trabajadores')
                      ->select('trabajadores.id', 'contratos.id as contrato', 'Nombre' ,'Apellidos', 'Apodo', 'Asistencia_total', 'Bono_Produc_Asis', 'Bono_Extra', 'Sueldo', 'Monto_Hora_Extra', 'Infonavit')
                      ->join('contratos', 'contratos.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                      ->where('trabajadores.Estado',1)
                      ->where('contratos.estado', 1)
                      ->get();
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
    public function store(Request $request)
    {
        //
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
