<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Producto;
use App\Materia_Prima;
use DB;

class Productos extends Controller
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
          $data = DB::table('productos')
           ->select('productos.id','productos.Descripcion','productos.Subtotal', 'productos.IVA', 'productos.Total', 'productos.Estado')
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function showMateriaPrima()
    {
        //
        try {
          $data = DB::table('materia_primas')
           ->select('materia_primas.id','materia_primas.Descripcion','materia_primas.Unidad_de_medida', 'materia_primas.Precio_por_unidad', 'materia_primas.Estado')
            ->get();
          // dd($data);
          return response()->json(json_encode($data));
        } catch (\Exception $e) {
          return response()->json(json_encode(1));
        }
    }

    public function showMateriaPrimaEspecifico($id)
    {
        //
        try {
          $data = DB::table('materia_primas')
           ->select('materia_primas.id','materia_primas.Descripcion','materia_primas.Unidad_de_medida', 'materia_primas.Precio_por_unidad', 'materia_primas.Estado')
            ->where('materia_primas.id', '=', $id)
            ->get();
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
