<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\usuario;
use App\trabajadore;
use Session;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('login');
        if(session()) {
            
            return redirect('/');
        } else {
            return view('login');
        }
    }

    /**
     * Function for login
     */
    public function ingresar(Request $request)
    {
        $query = new usuario();
        
        if($query   ->where('Usuario',    '=', $request->input('login_usuario'))
                    ->where('Contraseña', '=', $request->input('login_password'))
                    ->count() > 0)
        {
            $user = DB::table('usuarios')
                    ->join('trabajadores', 'usuarios.Trabajadores_idTrabajador', '=', 'trabajadores.id')
                    ->where('Usuario',     '=', $request->input('login_usuario'))
                    ->where('Contraseña',  '=', $request->input('login_password'))
                    ->select(
                            'usuarios.idUsuario',
                            'usuarios.Usuario',
                            'usuarios.Estado',
                            'usuarios.Roles_idRol',
                            'trabajadores.Nombre'
                            )
                    ->first();
                if($user->Estado == 0) {
                    session([
                            'idUsuario' => $user->idUsuario,
                            'idRol'     => $user->Roles_idRol,
                            'Usuario'   => $user->Usuario,
                            'Nombre'    => $user->Nombre,
                        ]);
                    // return $user->idRol;
                    return 'true';
                } else {
                    return 'inactivo';
                }
        } else
            return 'false';
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
