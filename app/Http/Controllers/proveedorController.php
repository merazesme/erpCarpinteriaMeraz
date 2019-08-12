<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\proveedore as Proveedor;
use App\gasolina as Gasolina;
use App\pago_gasolina as Pago;
use App\relacion_gasolina_pago as Relacion;
use Image;

class proveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acceso = (new loginController)->check_session('Proveedores');

        if($acceso == 'permitir') {
            $modulo = 'Agregar proveedor';
            return view('proveedores.proveedores_agregar', compact('modulo'));
        } else if($acceso == 'denegar') {
            return redirect('/');
        } else {
            return redirect('/login/');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gasoline_list()
    {
        $acceso = (new loginController)->check_session('Proveedores');

        if($acceso == 'permitir') {
            $modulo = 'Facturas de gasolina';
            return view('proveedores.proveedores_gasolina', compact('modulo'));
        } else if($acceso == 'denegar') {
            return redirect('/');
        } else {
            return redirect('/login/');
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
     * Store a newly created provider resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregar_proveedor(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('proveedor_nombre') )    ||
            empty( $request->input('proveedor_rfc') )       ||
            empty( $request->input('proveedor_correo') )    ||
            empty( $request->input('proveedor_telefono') )
        ) {
            return 'empty';
        }

        $proveedor = new Proveedor();

        $proveedor->RFC         = $request->input('proveedor_rfc');
        $proveedor->Nombre      = $request->input('proveedor_nombre');
        $proveedor->Telefono    = $request->input('proveedor_telefono');
        $proveedor->Email       = $request->input('proveedor_correo');
        $proveedor->Adeudo      = 0;
        $proveedor->estatus     = 0;
        $proveedor->idUsuario   = session('idUsuario');

        if(!$proveedor->save()) {
            return 'error';
        }
        return 'true';
    }

    /** 
     * Store a newly created register gas resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregar_factura_gasolina(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('mdate') )           ||
            empty( $request->input('gasolina_ticket') ) ||
            $request->input('gasolina_auto') == null    ||
            empty( $request->input('gasolina_litros') ) ||
            empty( $request->input('gasolina_total') ) 
        ) {
            return 'empty';
        }
        // if($request->hasFile('gasolina_archivo')) {
        //     return 'Tiene archivo';
        // } else {
        //     return 'No tiene';
        // } 

        $file = $request->file('gasolina_archivo');
        $nombre = time().$file->getClientOriginalName();
        $location = public_path('images/modulos/proveedor/gasolina/'.$nombre);
        // Image::make($file)->resize(250, 450)->save($location);
        Image::make($file)->save($location);

        $factura = new Gasolina();

        $factura->Fecha             = $request->input('mdate');
        $factura->Litros            = $request->input('gasolina_litros');
        $factura->Total             = $request->input('gasolina_total');
        $factura->Ticket            = $request->input('gasolina_ticket');
        $factura->Documento         = $nombre;
        $factura->Carros_idCarro    = $request->input('gasolina_auto');
        $factura->Estado            = 1;
        $factura->idUsuario         = session('idUsuario');

        if(!$factura->save()) {
            return 'error';
        }
        return 'true';
    }

    /** 
     * Store a newly created pay ticket resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function agregar_pagar_factura(Request $request)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('factura_folio') )   ||
            empty( $request->input('factura_tickets') ) ||
            empty( $request->input('fecha') )
        ) {
            return 'empty';
        }

        $file = $request->file('factura_archivo');
        $nombre = time().$file->getClientOriginalName();
        $location = public_path('images/modulos/proveedor/gasolina/pagos/'.$nombre);
        // Image::make($file)->resize(250, 450)->save($location);
        Image::make($file)->save($location);

        /** Registrar el pago en la tabla */
        $pago = new Pago();

        $pago->Fecha        = $request->fecha;
        $pago->Metodo_pago  = $request->factura_metodo;
        $pago->Folio_pago   = $request->factura_folio;
        $pago->Documento    = $nombre;
        $pago->idUsuario    = session('idUsuario');

        if(!$pago->save()) {
            return 'error-pago';
        }

        /** Guardar la relación entre los tickets y pagos */
        $errores = 0;
        $tickets = json_decode($request->factura_tickets);
        foreach ($tickets as $ticket) {
            $relacion = new Relacion();
    
            $relacion->Gasolina_id = $ticket;
            $relacion->Pago_gasolina_idPago_gasolina = $pago->id;
            

            if(!$relacion->save()) {
                $errores++;
            }
        }

        if($errores > 0) {
            /** Ocurre error, borrar pago, retornar error de relación */
            $this->destroy($pago->id);
            return 'error-relacion';
        }

        $total = 0;
        /** Cambiar de estado a cero a los tickets */
        foreach ($tickets as $ticket) {
            $ticket_update = Gasolina::find($ticket);
            $ticket_update->Estado = 0;
            $total += $ticket_update->Total;
            $ticket_update->update();
        }

        $pago->Cantidad = $total;

        if(!$pago->update()) {
            $this->destroy($pago->id);
            $this->destroy_multiple($pago->id);
            return 'error-pago';
        }
        return 'true';
    }

    /**
     * Change the status of resource
     */
    private function update_status_gasolina($id) 
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acceso = (new loginController)->check_session('Proveedores');

        if($acceso == 'permitir') {
            $modulo = 'Editar proveedor';
            return view('proveedores.proveedores_agregar', compact('modulo'));
        } else if($acceso == 'sesion') {
            return redirect('/login/');
        } else {
            return redirect('/');
        }
    }

    /**
     * Show all the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_resources()
    {
        $acceso = (new loginController)->check_session('Proveedores');

        if($acceso == 'permitir') {
            $modulo = 'Lista de proveedores';
            return view('proveedores.proveedores_show', compact('modulo'));
        } else if($acceso == 'denegar') {
            return redirect('/');
        } else {
            return redirect('/login/');
        }
        
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_proveedores() 
    {
        return Proveedor::all();
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_gasolina() 
    {
        $registros = DB::table('gasolinas')
            ->join  ('carros', 'gasolinas.Carros_idCarro', '=', 'carros.id')
            ->select('gasolinas.id', 'gasolinas.Fecha', 'gasolinas.Litros', 'gasolinas.Total', 
                     'gasolinas.Documento', 'gasolinas.Ticket', 'gasolinas.Estado', 'carros.Marca', 
                     'carros.Modelo')
            ->get();
        return $registros;
        // return Gasolina::all();
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_gasolina_cheques() 
    {
        $registros = DB::table('pago_gasolinas')
            ->join('gasolina_has_pago_gasolina', 
                   'gasolina_has_pago_gasolina.Pago_gasolina_idPago_gasolina', '=', 'pago_gasolinas.id')
            ->join('gasolinas', 'gasolinas.id', '=', 'gasolina_has_pago_gasolina.Gasolina_id')
            ->select('pago_gasolinas.id', 'pago_gasolinas.Fecha', 'pago_gasolinas.Folio_pago', 
                     'gasolinas.Ticket', 'pago_gasolinas.Cantidad', 'pago_gasolinas.Metodo_pago',
                     'pago_gasolinas.Documento')
            ->get();
        return $registros;
    }

    /** 
     * Return all the resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function datos_carros() 
    {
        $registros = DB::table('carros')
            ->where ('carros.Estado', '=', '0')
            ->select('carros.id', 'carros.Marca', 'carros.Modelo')
            ->get();
        return $registros;
    }

    /**
     * Show the data of provider for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datos_proveedor_especifico($id) 
    {
        return Proveedor::find($id);
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
     * Update the specified resource (provider) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_proveedor(Request $request, $id)
    {
        if(!session('Usuario')) {
            return 'session';
        }
        if(
            empty( $request->input('proveedor_nombre') )    ||
            empty( $request->input('proveedor_rfc') )       ||
            empty( $request->input('proveedor_correo') )    ||
            empty( $request->input('proveedor_telefono') )
        ) {
            return 'empty';
        }

        $proveedor = Proveedor::find($id);

        $proveedor->RFC         = $request->input('proveedor_rfc');
        $proveedor->Nombre      = $request->input('proveedor_nombre');
        $proveedor->Telefono    = $request->input('proveedor_telefono');
        $proveedor->Email       = $request->input('proveedor_correo');
        $proveedor->idUsuario   = session('idUsuario');

        if(!$proveedor->update()) {
            return 'error';
        }
        return 'true';
    }

    /**
     * Update the specified status in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_proveedor_estatus($id) 
    {
        if(!session('Usuario')) {
            return 'session';
        }
        $proveedor  = Proveedor::find($id);
        $estatus    = $proveedor->estatus == 0 ? 1 : 0;
        $proveedor->estatus = $estatus;

        if(!$proveedor->update()) {
            return 'false';
        }
        return 'true';
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
        $pago = Pago::find($id);
        if(!$pago->delete()) {
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
        $relacion = DB::table('gasolina_has_pago_gasolina')
                    ->where('Pago_gasolina_idPago_gasolina', '=', $id);
        if(!$relacion->delete()) {
            return 'false';
        }
        return 'true';
    }
}
