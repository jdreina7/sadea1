<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Usuario;

class UsuarioController extends Controller
{

	public function index(){
    	echo 'Index de UsuarioController';
    }


    public function registrarUsuario(Request $request){

    	$now = new \DateTime();
    	
    	//echo $now->format('d-m-Y H:i:s');
    	$hoy = $now->format('d-m-Y H:i:s');
    	
    	// Recibimos y transformamos el post que nos llega
    	$json = $request->input('json', null);
    	$params = json_decode($json);

    	$tipo_doc = (!is_null($json) && isset($params->tipo_doc)) ? $params->tipo_doc : '';
    	$num_doc = (!is_null($json) && isset($params->num_doc)) ? $params->num_doc : '';
    	$apellido1 = (!is_null($json) && isset($params->primer_apellido)) ? $params->primer_apellido : '';
    	$apellido2 = (!is_null($json) && isset($params->segundo_apellido)) ? $params->segundo_apellido : '';
    	$nombre1 = (!is_null($json) && isset($params->primer_nombre)) ? $params->primer_nombre : '';
    	$nombre2 = (!is_null($json) && isset($params->segundo_nombre)) ? $params->segundo_nombre : '';
    	$email = (!is_null($json) && isset($params->email)) ? $params->email : '';
    	$password = (!is_null($json) && isset($params->password)) ? $params->password : '';
    	$fec_nac = (!is_null($json) && isset($params->fec_nac)) ? $params->fec_nac : '';
    	$tel_fijo = (!is_null($json) && isset($params->tel_fijo)) ? $params->tel_fijo : '';
    	$celular = (!is_null($json) && isset($params->celular)) ? $params->celular : '';
    	$role  = (!is_null($json) && isset($params->role)) ? $params->role : '';
    	$fec_actual  = (!is_null($json) && isset($params->fec_actual)) ? $params->fec_actual : '';
    	$usu_creo = (!is_null($json) && isset($params->usu_login)) ? $params->usu_login : '';
    	$estado = true;

    	if( !is_null($tipo_doc) && !is_null($num_doc) && !is_null($apellido1) && !is_null($nombre1) 
    		&& !is_null($email) && !is_null($password) && !is_null($role) && !is_null($usu_creo) ) {

    		// inserta el usuario

    		$user = new Usuario();

    		$user ->usu_tipo_doc = $tipo_doc;
			$user ->usu_num_doc = $num_doc;
			$user ->usu_primer_apellido = $apellido1;
			$user ->usu_segundo_apellido = $apellido2;
			$user ->usu_primer_nombre = $nombre1;
			$user ->usu_segundo_nombre = $nombre2;
			$user ->usu_mail = $email;

			$pwd = hash('sha256', $password);
			$user ->usu_password = $pwd;

			$user ->usu_fec_nac = $fec_nac;
			$user ->usu_tel_fijo = $tel_fijo;
			$user ->usu_celular = $celular;
			$user ->usu_role = $role;
			$user ->usu_created_at = $hoy;
			$user ->usu_usu_creo = $usu_creo;
			$user ->usu_estado = $estado;

			// Comprobar que ya no exista el usuario en la BD

			$isset_documento = Usuario::where('usu_num_doc', '=', $num_doc)->first();
			$isset_email = Usuario::where('usu_mail', '=', $email)->first();

			if( isset($isset_documento) && count($isset_documento) != 0){
				$data = array(
	    			'status' => 'error',
	    			'code' => 400,
	    			'message' => 'Este número de Identificación ya existe en la BD!'
	    		);

			} else if( isset($isset_email) && count($isset_email) != 0) {
				$data = array(
	    			'status' => 'error',
	    			'code' => 400,
	    			'message' => 'Este email ya existe en la BD!'
	    		);

			}else {

				$user->save();

				$data = array(
	    			'status' => 'success',
	    			'code' => 200,
	    			'message' => 'Usuario registrado correctamente!'
	    		);
								
			}

    	} else {
    		$data = array(
    			'status' => 'error',
    			'code' => 400,
    			'message' => 'Faltan campos obligatorios para el almacenamiento del usuario!'
    		);
    	}

    	return response()->json($data, 200);

    }


    public function autenticarUsuario(Request $request){
    	echo 'Acción Autenticar'; die();
    }
}
