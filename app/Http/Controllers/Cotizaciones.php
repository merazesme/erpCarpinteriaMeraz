<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Mail; //Importante incluir la clase Mail, que será la encargada del envío


use App\Cotizacion;
use App\Cliente;
use App\Recomendacion;
use App\Producto;
use App\Materia_Prima;
use App\Producto_MateriaPrima;
use App\Configuracion;
use App\Producto_Cotizacion;

class Cotizaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function imprimir($id){
        try {
            $day = date('d')-1;
            $m = date('m');
            $m = (int) $m-1;
            $year = date('Y');
            $month = ["enero", "febrero", "marzo","abril", "mayo", "junio", "nulio", "agosto", "septiembre", "octubre", "novimebre", "dicimebre"];

            $cotizacion = (object) [];
            $prueba = DB::table('cotizaciones')
                ->join('clientes', 'cotizaciones.Clientes_idCliente', '=', 'clientes.id')
                ->select('cotizaciones.id', 'cotizaciones.Descripcion','cotizaciones.costo',
                    'clientes.id AS idCliente', 'clientes.Nombre as NombreCliente', 'clientes.Apellidos as ApellidoCliente')
                ->where('cotizaciones.id', $id)
                ->get();

            $cotizacion = $prueba[0];

            //Productos de la cotización
            $sql = "SELECT `productos`.`id` AS idProducto, `productos`.`Descripcion` AS nombreProducto,
            `productos_has_cotizaciones`.`Productos_id` AS idProductoCotizacion, `productos_has_cotizaciones`.`Cantidad`,
            `productos_has_cotizaciones`.`subtotal`, `productos_has_cotizaciones`.`iva`, `productos_has_cotizaciones`.`total`,
            `productos_has_cotizaciones`.`Descripcion` AS descripcion
            FROM `productos`
            INNER JOIN `productos_has_cotizaciones` ON `productos_has_cotizaciones`.`Productos_id` = `productos`.`id`
            WHERE `productos_has_cotizaciones`.`Cotizaciones_id` = ?
            ORDER BY `productos`.`id` ASC";

            $cotizacion = (array)$cotizacion;

            $cotizacion['iva'] =  0;
            $cotizacion['suma'] = 0;

            $pruebaProductos = DB::select($sql,array($id));
            foreach ($pruebaProductos as $key => $value) {
                $pruebaProductos[$key]->materiales = $this->getMateriales($value->idProducto);
                $cotizacion['iva'] +=  ($value->iva*$value->Cantidad);
                $cotizacion['suma'] +=  ($value->subtotal*$value->Cantidad);
            }

            // echo print_r($pruebaProductos);

            $cotizacion['fecha'] = "Mazatlán Sin. A ".$day." de ".$month[$m]." del ".$year;
            $cotizacion['productos'] = $pruebaProductos;
            $cotizacion = (object)$cotizacion;


            $dompdf = \PDF::loadView('documentos/base/cotizacion', compact('cotizacion'));

            //Donde guardar el documento
            $rutaGuardado = public_path('documentos/cotizaciones/');
            //Nombre del Documento.
            $nombre = time().$id;
            $nombreArchivo = $nombre.".pdf";
            //Guardalo en una variable
            $output = $dompdf->output();
            file_put_contents( $rutaGuardado.$nombreArchivo, $output);
            // Una vez lo guardes en local lo puedes subir o enviar a un ftp.

            $ultimoNombre = $this->getLastNameDocCotizacion($id);
            try {
                $data = Cotizacion::find($id);
                $data->Documento=$nombreArchivo;
                $data->idUsuario=1;
                if ($data->save()){
                    if($ultimoNombre != null){
                        $eliminar = $this->delete_file( $rutaGuardado.$ultimoNombre);
                    }
                }
            } catch (\Exception $e) {
                return response()->json(json_encode(-2));
            }

            // return $dompdf->download('cotizaciones/documento.pdf');
            return response()->json(json_encode($nombreArchivo));
        } catch (\Exception $e) {
            return response()->json(json_encode(-1));
        }
    }

    public function delete_file($path){
        if(file_exists($path)){
            if (unlink($path)) {
                return 0;
            } else {
                return 1;
            }
        }else{
            return 3;
        }
    }

    public function getLastNameDocCotizacion($id){
        try{
            $data = DB::table('cotizaciones')->select('Documento')
            ->where('id', $id)->get();
            return $data[0]->Documento;
       }
       catch(\Exception $e){
          return -3;
       }
    }

    public function documento($id){
        $day = date('d');
        $m = date('m');
        $m = (int) $m-1;
        $year = date('Y');
        $month = ["enero", "febrero", "marzo","abril", "mayo", "junio", "nulio", "agosto", "septiembre", "octubre", "novimebre", "dicimebre"];

        $cotizacion = (object) [];
        $prueba = DB::table('cotizaciones')
            ->join('clientes', 'cotizaciones.Clientes_idCliente', '=', 'clientes.id')
            ->select('cotizaciones.id', 'cotizaciones.Descripcion','cotizaciones.costo',
                'clientes.id AS idCliente', 'clientes.Nombre as NombreCliente', 'clientes.Apellidos as ApellidoCliente')
            ->where('cotizaciones.id', $id)
            ->get();

        $cotizacion = $prueba[0];

        //Productos de la cotización
        $sql = "SELECT `productos`.`id` AS idProducto, `productos`.`Descripcion` AS nombreProducto,
        `productos_has_cotizaciones`.`Productos_id` AS idProductoCotizacion, `productos_has_cotizaciones`.`Cantidad`,
        `productos_has_cotizaciones`.`subtotal`, `productos_has_cotizaciones`.`iva`, `productos_has_cotizaciones`.`total`,
        `productos_has_cotizaciones`.`Descripcion` AS descripcion
        FROM `productos`
        INNER JOIN `productos_has_cotizaciones` ON `productos_has_cotizaciones`.`Productos_id` = `productos`.`id`
        WHERE `productos_has_cotizaciones`.`Cotizaciones_id` = ?
        ORDER BY `productos`.`id` ASC";

        $cotizacion = (array)$cotizacion;

        $cotizacion['iva'] =  0;
        $cotizacion['suma'] = 0;

        $pruebaProductos = DB::select($sql,array($id));
        foreach ($pruebaProductos as $key => $value) {
            $pruebaProductos[$key]->materiales = $this->getMateriales($value->idProducto);
            $cotizacion['iva'] +=  ($value->iva*$value->Cantidad);
            $cotizacion['suma'] +=  ($value->subtotal*$value->Cantidad);
        }

        // echo print_r($pruebaProductos);

        $cotizacion['fecha'] = "Mazatlán Sin. A ".$day." de ".$month[$m]." del ".$year;
        $cotizacion['productos'] = $pruebaProductos;

        echo print_r($cotizacion);


        // $cotizacion['nombre'] = "Victor Rueda";
        // $cotizacion['descripcion'] = "Casa Habitación  Fam. Ibarra García Tomas de rueda #1807-1808 Fracc. El. Cid";

        $cotizacion = (object)$cotizacion;
        return view('documentos/base/cotizacion', compact('cotizacion'));
    }

    public function email($id){
        try{
            $data = DB::table('cotizaciones')
                ->join('clientes', 'cotizaciones.Clientes_idCliente', '=', 'clientes.id')
                ->select('cotizaciones.Documento', 'clientes.Email', 'clientes.Nombre', 'clientes.Apellidos',
                    'cotizaciones.fecha_inicio', 'cotizaciones.fecha_fin')
                ->where('cotizaciones.id', "=", $id)
                ->get();
            $data = $data[0];

            $subject = "Cotización";
            $for = $data->Email;
            $documento = public_path('documentos/cotizaciones/').$data->Documento;
            Mail::send('cotizaciones/email',compact('data'), function($msj) use($subject,$for,$documento){
                $msj->from("empresa.tunas.mx@gmail.com","Carpintería Meraz");
                $msj->subject($subject);
                $msj->to($for);
                $msj->attach($documento, [
                    'as' => 'cotizacion.pdf',
                    'mime' => 'application/pdf',
                ]);
            });
            // return view('cotizaciones/email',compact('data'));
            return response()->json(json_encode(0));
        }
        catch(\Exception $e){
          return response()->json(json_encode(1));
        }

   }

    public function index()
    {
        //
        try{
            $data = DB::table('cotizaciones')
                ->join('clientes', 'cotizaciones.Clientes_idCliente', '=', 'clientes.id')
                ->select('cotizaciones.id', 'cotizaciones.correoCalidad', 'cotizaciones.Descripcion', 'cotizaciones.Estado', 'cotizaciones.Prioridad', 'cotizaciones.Documento',
                    'cotizaciones.costo', 'clientes.id AS idCliente', 'clientes.Nombre', 'clientes.Apellidos',
                    'cotizaciones.fecha_inicio', 'cotizaciones.fecha_fin')
                ->get();
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }

    }

    public function getCotizaciones_Cliente($id){
        try{
            $data = Cotizacion::where('Clientes_idCliente', $id)->get();
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function getCotizacionDetalle($id){
        try{
            $sql = "SELECT `productos`.`id` AS idProducto, `productos`.`Descripcion` AS nombreProducto,
            `productos_has_cotizaciones`.`Productos_id` AS idProductoCotizacion, `productos_has_cotizaciones`.`Cantidad`,
            `productos_has_cotizaciones`.`subtotal`, `productos_has_cotizaciones`.`iva`, `productos_has_cotizaciones`.`total`,
            `productos_has_cotizaciones`.`Descripcion` AS descripcion
            FROM `productos`
            INNER JOIN `productos_has_cotizaciones` ON `productos_has_cotizaciones`.`Productos_id` = `productos`.`id`
            WHERE `productos_has_cotizaciones`.`Cotizaciones_id` = ?
            ORDER BY `productos`.`id` ASC";

            $cotizacion = DB::select($sql,array($id));
            foreach ($cotizacion as $key => $value) {
                $cotizacion[$key]->materiales = $this->getMateriales($value->idProducto);
            }
            return response()->json(json_encode($cotizacion));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function getMateriales($id){
        try {
            $data = DB::table('materia_primas')
            ->join('productos_has_materia_prima', 'productos_has_materia_prima.Materia_prima_idMateria_prima', '=', 'materia_primas.id')
            ->select('materia_primas.id', 'materia_primas.Descripcion')
            ->where('productos_has_materia_prima.Productos_idProducto', '=', $id)
            ->get();
            return $data;
        } catch (\Exception $e) {
            return "-1";
        }
    }

    public function getIVA()
    {
        //
        try{
             $datos = Configuracion::select('IVA')->get();
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function getImagenBase64(Request $request){
        $im = file_get_contents($request->input('imagen'));
        $imdata = base64_encode($im);
        return response()->json(json_encode($imdata));
    }

    public function listRecomendados()
    {
        //
        try{
             $datos = Recomendacion::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listClientes()
    {
        //
        try{
             $datos = Cliente::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listProductos()
    {
        //
        try{
             $datos = Producto::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
           return response()->json(json_encode(1));
        }
    }

    public function listMateria()
    {
        //
        try{
             $datos = Materia_Prima::all()->where ('Estado', '=', '0');
             return response()->json(json_encode($datos));
        }
        catch(\Exception $e){
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
        try{
            $data=new Cotizacion();

            $data->Descripcion=$request->input('descripcion');
            $data->Estado="3";
            $data->Prioridad=$request->input('prioridad');
            $data->Costo=$request->input('costo');
            $data->fecha_inicio=$request->input('fecha_inicio');
            $data->fecha_fin=$request->input('fecha_fin');
            $data->idUsuario=$request->input('idUsuario');
            $data->Clientes_idCliente=$request->input('idCliente');
            $data->correoCalidad=0;

            if(!empty( $request->input('idRecomendado'))){
                $data->Recomendacion_idRecomendacion=$request->input('idRecomendado');
                $data->porcentaje_recomendacion=$request->input('porcentaje');
            }

            $productos = json_decode($request->input('productos'));
            if($data->save()){
                foreach ($productos as $key => $value) {
                    $dataPC=new Producto_Cotizacion();
                    $dataPC->Cotizaciones_id=$data->id;
                    $dataPC->Productos_id=$value->idProducto;
                    $dataPC->Cantidad=$value->cantidad;
                    $dataPC->Descripcion=$value->descripcion;
                    $dataPC->subtotal=$value->subtotal;
                    $dataPC->iva=$value->iva;
                    $dataPC->total=$value->total;

                    $dataPC->idUsuario=$request->input('idUsuario');
                    if(!$dataPC->save()){
                        return response()->json(json_encode(-1));
                    }
                }
            }
            return response()->json(json_encode($data->id));
       }
       catch(\Exception $e){
          return response()->json(json_encode(-2));
       }
    }

    public function storeRecomendado(Request $request)
    {
        //
        try{
            $data=new Recomendacion();

            $data->Nombre=$request->input('nombreReco');
            $data->Porcentaje=$request->input('porcentajeReco');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado="0";

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function storeProducto(Request $request)
    {
        //
        try{
            $data=new Producto();

            $data->Descripcion=$request->input('descripcionProducto');
            $data->Subtotal=$request->input('subtotalProducto');
            $data->IVA=$request->input('ivaProducto');
            $data->Total=$request->input('totalProducto');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado="0";

            $materia = json_decode($request->input('materiaPrima'));
            if($data->save()){
                foreach ($materia as $key => $value) {
                    $dataPM=new Producto_MateriaPrima();
                    $dataPM->Productos_idProducto=$data->id;
                    $dataPM->Materia_prima_idMateria_prima=$value;

                    $dataPM->idUsuario=$request->input('idUsuario');
                    if(!$dataPM->save()){
                        return response()->json(json_encode(-1));
                    }
                }
            }
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
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

    public function showRecomendado($id)
    {
        //
        try{
            $data = Recomendacion::find($id);
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function showProducto($id)
    {
        //
        try{
            // $data = Producto::find($id);
            $final = DB::table('productos')
              ->join('productos_has_materia_prima', 'productos_has_materia_prima.Productos_idProducto', '=', 'productos.id')
                ->where('productos.id', '=', $id)
                  ->get();
            return response()->json(json_encode($final));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function showProductoMaterial($id)
    {
        //
        try{
            // $data = Producto::find($id);
            $final = DB::table('productos')
                ->join('productos_has_materia_prima', 'productos_has_materia_prima.Productos_idProducto', '=', 'productos.id')
                ->join('materia_primas', 'productos_has_materia_prima.Materia_prima_idMateria_prima', '=', 'materia_primas.id')
                ->where('productos.id', '=', $id)
                ->select('productos.id', 'productos.Descripcion', 'productos.Subtotal', 'productos.IVA', 'productos.Total',
                    'materia_primas.id AS idMateria', 'materia_primas.Descripcion AS descripcionMateria')
                ->get();
            return response()->json(json_encode($final));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
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
        try{
            $data = Cotizacion::find($id);
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function editCotiProducto($id)
    {
        //
        try{
            $data = Cotizacion::find($id);
            return response()->json(json_encode($data));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
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
        //
        try{
            $data = Cotizacion::find($id);

            $data->Descripcion=$request->input('descripcion');
            $data->Prioridad=$request->input('prioridad');
            $data->Costo=$request->input('costo');
            $data->fecha_inicio=$request->input('fecha_inicio');
            $data->fecha_fin=$request->input('fecha_fin');
            $data->idUsuario=$request->input('idUsuario');
            $data->Clientes_idCliente=$request->input('idCliente');


            if(!empty( $request->input('idRecomendado'))){
                $data->Recomendacion_idRecomendacion=$request->input('idRecomendado');
                $data->porcentaje_recomendacion=$request->input('porcentaje');
            }

            $productos = json_decode($request->input('productos'));
            if($data->save()){
                $ProductosCotizacion = Producto_Cotizacion::where('Cotizaciones_id', '=', $id);
                if($ProductosCotizacion->delete()){
                    foreach ($productos as $key => $value) {
                        $dataPC=new Producto_Cotizacion();
                        $dataPC->Cotizaciones_id=$data->id;
                        $dataPC->Productos_id=$value->idProducto;
                        $dataPC->Cantidad=$value->cantidad;
                        $dataPC->Descripcion=$value->descripcion;
                        $dataPC->subtotal=$value->subtotal;
                        $dataPC->iva=$value->iva;
                        $dataPC->total=$value->total;

                        $dataPC->idUsuario=$request->input('idUsuario');
                        if(!$dataPC->save()){
                            return response()->json(json_encode(-1));
                        }
                    }
                }else{
                    return response()->json(json_encode(-2));
                }
            }
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function updateEstado(Request $request, $id)
    {
        //
        try{
            $data = Cotizacion::find($id);

            $data->Estado=$request->input('selectEstadoCotizacion');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }


    public function updateRecomendado(Request $request, $id)
    {
        //
        try{
            $data = Recomendacion::find($id);

            $data->Nombre=$request->input('nombreReco');
            $data->Porcentaje=$request->input('porcentajeReco');
            $data->idUsuario=$request->input('idUsuario');

            $data->save();
            return response()->json(json_encode(0));
       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
       }
    }

    public function updateProducto(Request $request, $id)
    {
        //
        try{
            $data = Producto::find($id);

            $data->Descripcion=$request->input('descripcionProducto');
            $data->Subtotal=$request->input('subtotalProducto');
            $data->IVA=$request->input('ivaProducto');
            $data->Total=$request->input('totalProducto');
            $data->idUsuario=$request->input('idUsuario');
            $data->Estado="0";

            $materia = json_decode($request->input('materiaPrima'));
            if($data->save()){
                //consulta para eliminar todas las que hay
                $materiaG = Producto_MateriaPrima::where('Productos_idProducto', '=', $id);
                if($materiaG->delete()){
                    foreach ($materia as $key => $value) {
                        $dataPM=new Producto_MateriaPrima();
                        $dataPM->Productos_idProducto=$data->id;
                        $dataPM->Materia_prima_idMateria_prima=$value;

                        $dataPM->idUsuario=$request->input('idUsuario');
                        if(!$dataPM->save()){
                            return response()->json(json_encode(-1));
                        }
                    }
                }else{
                    return response()->json(json_encode(-2));
                }
            }
            return response()->json(json_encode(0));

       }
       catch(\Exception $e){
          return response()->json(json_encode(1));
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
