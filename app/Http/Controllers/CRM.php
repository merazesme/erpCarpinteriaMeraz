<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Mail; //Importante incluir la clase Mail, que será la encargada del envío

use App\Cotizacion;
use App\Cliente;
use App\Configuracion;

class CRM extends Controller
{


    public function email(Request $request){
        try{
            $variable = json_decode($request->input('usuarios'));
            // return json_encode($variable);

            $encuesta = $this->getEncuesta();
            $encuesta = $encuesta[0]->formulario_calidad;
            if($encuesta == 1){
                return response()->json(json_encode(5));
            }

            foreach ($variable as $key => $value) {
                // return json_encode($value);

                $data = DB::table('cotizaciones')
                    ->join('clientes', 'cotizaciones.Clientes_idCliente', '=', 'clientes.id')
                    ->select('clientes.Email')
                    ->where('cotizaciones.id', "=", $value)
                    ->get();

                $subject = "Encuesta de Calidad";
                $for = $data[0]->Email;
                // return json_encode($for);
                Mail::send('crm/correo',compact('encuesta'), function($msj) use($subject,$for){
                    $msj->from("empresa.tunas.mx@gmail.com","Carpintería Meraz");
                    $msj->subject($subject);
                    $msj->to($for);
                });

                $dataActualizar = Cotizacion::find($value);
                $dataActualizar->correoCalidad=1;

                $dataActualizar->save();
            }
            // return view('cotizaciones/email',compact('data'));
            return response()->json(json_encode(0));
        }
        catch(\Exception $e){
          return $e;
        }
   }

   public function getEncuesta()
   {
       //
       try{
            $datos = Configuracion::select('formulario_calidad')->get();
            return $datos;
       }
       catch(\Exception $e){
          return 1;
       }
   }

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
