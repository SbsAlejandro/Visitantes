<?php

require_once './models/PersonalModel.php';
require_once './config/validacion.php';

class PersonalController
{

	#estableciendo las vistas
	public function inicioPersonal()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/personal/inicioPersonal.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}



	public function listarPersonal()
	{

		// Database connection info 
		$dbDetails = array(
			'host' => 'localhost',
			'user' => 'postgres',
			'pass' => 'postgres',
			'db'   => 'bd_visitante'
		);

		// DB table to use 
		$table = 'personasno';


		// Table's primary key 
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'id', 		'dt' => 0),
			array('db' => 'cedula',     	'dt' => 1),
			array('db' => 'nombre',     	'dt' => 2),
			array('db' => 'apellido',     	'dt' => 3),



			array(
				'db'        => 'estatus',
				'dt'        => 4,
				'formatter' => function ($d, $row) {
					return ($d == 1) ? '<button class="btn btn-success btn-sm">Activo</button>' : '<button class="btn btn-danger btn-sm">Inactivo</button>';
				}
			),
			array('db' => 'id', 'dt' => 5),
			array('db' => 'estatus', 'dt' => 6)
			//array( 'db' => 'fecha_registro','dt' => 9 ),

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}







	public function registrarPersonal()
	{

		$modelpersonal = new PersonalModel();
		/* --------- Funcion limpiar cadenas ---------*/
		$cedula 				= Validacion::limpiar_cadena($_POST['cedula']);
		$nombre 				= Validacion::limpiar_cadena($_POST['nombre']);
		$apellido 				= Validacion::limpiar_cadena($_POST['apellido']);
		$estatus 				= Validacion::limpiar_cadena($_POST['estatus']);
		$fecha_actual = date("Y-m-d");

//Validar que el visitante no ingrese dos veces al sistema el mismo día
$entrada_personal_hoy = $modelpersonal->validarEntradaDia($nombre,$apellido ,$cedula, $fecha_actual);

foreach ($entrada_personal_hoy as $entrada_personal_hoy) {
	$id_entrada_personal = $entrada_personal_hoy['id'];
}



if (!empty($id_entrada_personal)) {
	$data = [
		'data' => [
			'success'            =>  false,
			'message'            => 'El personal ya ha sido ingresado el día de hoy',
			'info'               =>  'Fecha de hoy ' . $fecha_actual . ''
		],
		'code' => 0,
	];

	echo json_encode($data);
	exit();
}
//caracteres especiales 
		if (Validacion::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $nombre)) {

			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
		$datos = array(
			'cedula'    	=> $_POST['cedula'],
			'nombre'		=> $_POST['nombre'],
			'apellido'		=> $_POST['apellido'],
			'estatus'		=> $_POST['estatus'],
			'fecha'			=> $fecha_actual,
		);
		//Validar los numeros
		if (Validacion::verificar_datos("[0-9]{1,10}", $cedula)) {

			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Solo se permiten numeros en el campo cédula del Personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		/* comprobar campos vacios */
		if ($cedula == "" || $nombre == ""  || $apellido == "" || $estatus == "") {
			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Verifica que todos los campos estén llenos a la hora de registrar un personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		$resultado = $modelpersonal->registrarpersonal($datos);

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El Personal ha sido guardado en la base de datos'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar el Personal',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function verPersonal()
	{
		$modelpersonal = new PersonalModel();

		$id_personal = $_POST['id_personal'];

		$listar = $modelpersonal->obtenerPersonal($id_personal);



		foreach ($listar as $listar) {

			$id_personal 	= $listar['id'];
			$cedula 		= $listar['cedula'];
			$nombre 		= $listar['nombre'];
			$apellido 		= $listar['apellido'];
			$estatus 		= $listar['estatus'];
			$fecha 				= $listar['fecha'];
				
		}

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'id'				 => $id_personal,
				'cedula'    		 => $cedula,
				'nombre'			 => $nombre,
				'apellido'			 => $apellido,
				'estatus'		     => $estatus,
				'fecha'		     	 => $fecha,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}


	public function modificarPersonal()
	{

		$modelPersonal = new PersonalModel();





		
		$id_personal = $_POST['id_personal'];
		/* --------- Funcion limpiar cadenas ---------*/
		$cedula 				= Validacion::limpiar_cadena($_POST['cedula']);
		$nombre 				= Validacion::limpiar_cadena($_POST['nombre']);
		$apellido 				= Validacion::limpiar_cadena($_POST['apellido']);
		$estatus 				= Validacion::limpiar_cadena($_POST['estatus']);
		$fecha_actual = date("Y-m-d");

//Validar que el visitante no ingrese dos veces al sistema el mismo día
$entrada_personal_hoy = $modelPersonal->validarEntradaDia($nombre,$apellido ,$cedula, $fecha_actual);

foreach ($entrada_personal_hoy as $entrada_personal_hoy) {
	$id_entrada_personal = $entrada_personal_hoy['id'];
}



if (!empty($id_entrada_personal)) {
	$data = [
		'data' => [
			'success'            =>  false,
			'message'            => 'El personal ya ha sido ingresado el día de hoy',
			'info'               =>  'Fecha de hoy ' . $fecha_actual . ''
		],
		'code' => 0,
	];

	echo json_encode($data);
	exit();
}
		

		//caracteres especiales 
		if (Validacion::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $nombre)) {

			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		$datos = array(
			'cedula'    	=> $_POST['cedula'],
			'nombre'		=> $_POST['nombre'],
			'apellido'		=> $_POST['apellido'],
			'estatus'		=> $_POST['estatus'],
		);	//Validar los numeros
		if (Validacion::verificar_datos("[0-9]{1,10}", $cedula)) {

			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Solo se permiten numeros en el campo cédula del Personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		/* comprobar campos vacios */
		if ($cedula == "" || $nombre == ""  || $apellido == "" || $estatus == "") {
			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Verifica que todos los campos estén llenos a la hora de registrar un personal.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}



		$resultado = $modelPersonal->modificarPersonal($id_personal, $datos);

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos del Personal han sido modificados'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar los datos del Personal',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}




	/*----------Metodo para inactivar personal-------*/
	public function inactivarPersonal()
	{

		$modelpersonal = new PersonalModel();
		$id_personal = $_POST['id_personal'];

		$estado = $modelpersonal->obtenerPersonal($id_personal);

		foreach ($estado as $estado) {
			$estado_Personal = $estado['estatus'];
		}

		if ($estado_Personal == 1) {
			$datos = array(
				'estatus'		=> 0,
			);

			$resultado = $modelpersonal->modificarPersonal($id_personal, $datos);
		} else {
			$datos = array(
				'estatus'		=> 1,
			);

			$resultado = $modelpersonal->modificarPersonal($id_personal, $datos);
		}

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El estado del Personal ha sido modificado'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar el estado del Personal',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}
}
