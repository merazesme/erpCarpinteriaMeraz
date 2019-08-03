<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Roles as Rol;
use App\relacion_roles_modulos as Relacion;

class rolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modulo = "Roles de usuario";
        return view('roles.roles', compact('modulo'));
    }

    /**
     * Display all the resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list_resources()
    {
        $data = array(
            'roles'     => DB::table('roles')->get(),
            'relacion'  => Relacion::all(),
            'modulos'   => DB::table('modulos')->where('Estado', '=', '0')->get()
        );
        return $data;
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
        $prueba = (new loginController)->check_session();
        return $prueba;

        if(!session('Usuario')) {
            return 'session';
        }
        if(empty( $request->input('rol_nombre') )) {
            return 'empty';
        }

        /** Registrar el rol en la tabla */
        $rol = new Rol();

        $rol->Nombre    = $request->rol_nombre;
        $rol->Estado    = 0;
        $rol->idUsuario = session('idUsuario');

        if(!$rol->save()) {
            return 'error-rol';
        }

        /** Guardar la relación entre los módulos y el rol */
        $errores = 0;
        $modulos = json_decode($request->rol_modulos);
        foreach ($modulos as $modulo) {
            $relacion = new Relacion();
    
            $relacion->Roles_idRol = $rol->id;
            $relacion->Modulos_idModulo = $modulo;

            if(!$relacion->save()) {
                $errores++;
            }
        }

        if($errores > 0) {
            /** Ocurre error, borrar rol, retornar error de relación */
            $this->destroy($rol->id);
            return 'error-relacion';
        }

        return 'true';
    }

    /**
     * Display the specified resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function usuarios_per_role($id)
    {
        return DB::table('usuarios')
                        ->select('Usuario')
                        ->where('Estado', '=', '0')
                        ->where('Roles_idRol', '=', $id)
                        ->get();
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
        $registros = DB::table('roles')
                    ->select('roles.Nombre as nombre_rol', 'modulos.Nombre as nombre_modulo', 'modulos.id', 
                             'modulos.submodulos', 'modulos.Enlace', 'modulos.Icono')
                    ->join('roles_has_modulos', 'roles_has_modulos.Roles_idRol', '=', 'roles.id')
                    ->join('modulos', 'roles_has_modulos.Modulos_idModulo', '=', 'modulos.id')
                    ->where('roles.id', '=', $id)
                    ->get();
        if(sizeof($registros) <= 0) {
            $registros = DB::table('roles')
                    ->select('roles.Nombre as nombre_rol')
                    ->where('roles.id', '=', $id)
                    ->get();
        }
        
        return $registros;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_submodulos($id)
    {
        //
        $submodulos = DB::table('submodulos')
                    ->select('submodulos.Nombre as nombre_submodulo', 'submodulos.Enlace as enlace_submodulo')
                    ->where('submodulos.id_modulo', '=', $id)
                    ->get();
        
        return $submodulos;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function get_roles_usuario($id) 
    // {

    // }

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
        if(!session('Usuario')) {
            return 'session';
        }
        if(empty( $request->input('rol_nombre') )) {
            return 'empty';
        }

        /** Registrar el rol en la tabla */
        $rol = Rol::find($id);

        $rol->Nombre    = $request->rol_nombre;
        $rol->idUsuario = session('idUsuario');

        if(!$rol->update()) {
            return 'error-rol';
        }

        /** Guardar la nueva relación entre los módulos y el rol */

        if(!$this->destroy_multiple($id)) {
            return 'error-relacion';
        }

        $errores = 0;
        $modulos = json_decode($request->rol_modulos);
        foreach ($modulos as $modulo) {
            $relacion = new Relacion();
    
            $relacion->Roles_idRol = $rol->id;
            $relacion->Modulos_idModulo = $modulo;

            if(!$relacion->save()) {
                $errores++;
            }
        }

        if($errores > 0) {
            /** Ocurre error, retornar error de relación */
            return 'error-relacion';
        }

        return 'true';
    }

    /**
     * Update the status of specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_estatus($id)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        $rol = Rol::find($id);
        $estatus     = $rol->Estado == 0 ? 1 : 0;
        $rol->Estado = $estatus;

        if(!$rol->update()) {
            return 'false';
        }
        return 'true';
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
        $rol = Rol::find($id);
        if(!$rol->delete()) {
            return 'false';
        }
        return 'true';
    }

    /**
     * Remove multiples resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_multiple($id)
    {
        //
        $roles = DB::table('roles_has_modulos')
                    ->where('Roles_idRol', '=', $id);
        if(!$roles->delete()) {
            return 'false';
        }
        return 'true';
    }
}
