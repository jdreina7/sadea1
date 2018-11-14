<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';

    // Relación con tipo_id
    public function tipo_id(){
    	return $this->belongsTo('App\Tipo_id', 'tipo_doc_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'usu_tipo_doc', 'usu_num_doc', 'usu_primer_apellido', 'usu_segundo_apellido', 'usu_primer_nombre', 'usu_segundo_nombre', 'usu_mail', 'usu_password', 'usu_fec_nac', 'usu_tel_fijo', 'usu_celular', 'usu_role', 'usu_created_at', 'usu_usu_creo', 'usu_estado'
    ];

    public $timestamps = false;
}
