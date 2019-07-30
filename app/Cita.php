<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    /**
     * Get the cliente that owns the cita.
     */

    protected $table = "Citas";
    public function citas(){
		return $this->hasMany('App/Cliente');
	}
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'Clientes_id');
    }
}
