<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\usuario;
// use App\trabajadore;
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
        if(session('Usuario')) {
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
                            'usuarios.id',
                            'usuarios.Usuario',
                            'usuarios.Estado',
                            'usuarios.Roles_idRol',
                            'trabajadores.Nombre'
                            )
                    ->first();
                if($user->Estado == 0) {
                    /** Obtener los módulos permitidos por el rol */
                    $modulos = (new rolController)->show($user->Roles_idRol);

                    $band=false;

                    for ($i=0; $i < sizeof($modulos); $i++) { 
                        # code...
                        if(!property_exists($modulos[$i], 'nombre_modulo') && (!$band)) {
                            /** Quiere decir que no tiene ningún módulo asignado */
                            // return $modulos[$i];
                            $modulos = "no-modulos";
                            break;
                        }
                        $band=true;
                        if($modulos[$i]->submodulos == 1) {
                            $modulos[$i] = array(
                                $modulos[$i],
                                (new rolController)->get_submodulos($modulos[$i]->id)
                            );
                        }
                    }
                    // return session('Modulos');

                    session([
                            'idUsuario' => $user->id,
                            'idRol'     => $user->Roles_idRol,
                            'Usuario'   => $user->Usuario,
                            'Nombre'    => $user->Nombre,
                            'Modulos'   => $modulos
                        ]);
                        // return session('Modulos');
                    return 'true';
                } else {
                    return 'inactivo';
                }
        } else
            return 'false';
    }

    /**
     * Delete the currently session
     */
    public function salir() {
        Session::flush();
        return 'true';
    }

    public function check_session($modulo) {
        if(session('Usuario')) {
            /** 
             * Tiene sesión 
             * La opción de módulos es un arreglo
             * */
            $modulos = session('Modulos');
            foreach ($modulos as $item) {
                if(is_object($item)) {
                    if($item->nombre_modulo == $modulo) {
                        return 'permitir';
                    }
                } else {
                    if($item[0]->nombre_modulo == $modulo) {
                        return 'permitir';
                    }
                }
            }

            return 'sesion';
        } else {
            /** No tiene sesión */
            return view('login');
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
