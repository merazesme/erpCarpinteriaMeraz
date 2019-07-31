<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

	protected $table = 'Clientes';

	public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'Clientes_id');
    }
}
