<?php

require_once './models/DepartamentosModel.php';
require_once './config/validacion.php';


class DepartamentosController
{

	#estableciendo la vista del login
	public function inicioDepartamentos()
	{

		/*HEADER */
		require_once('./views/includes/cabecera.php');

		require_once('./views/paginas/departamentos/inicioDepartamentos.php');

		/* FOOTER */
		require_once('./views/includes/pie.php');
	}


	public function listarDepartamentos()
	{
		// Database connection info 
		$dbDetails = array(
			'host' => 'localhost',
			'user' => 'postgres',
			'pass' => 'postgres',
			'db'   => 'bd_visitante'
		);


		$table = 'departamentos';

		// Table's primary key 
		$primaryKey = 'id';

		//?? Array of database columns which should be read and sent back to DataTables. 
		// !The `db` parameter represents the column name in the database.  
		// The `dt` parameter represents the DataTables column identifier. 
		$columns = array(

			array('db' => 'id', 		'dt' => 0),
			array('db' => 'nombre',     	'dt' => 1),
			array(
				'db'        => 'estatus',
				'dt'        => 2,
				'formatter' => function ($d, $row) {
					return ($d == 1) ? '<button class="btn btn-success btn-sm">Activo</button>' : '<button class="btn btn-danger btn-sm">Inactivo</button>';
				}
			),
			array('db' => 'id', 'dt' => 3),
			array('db' => 'estatus', 'dt' => 4)
			//array( 'db' => 'fecha_registro','dt' => 9 ),

		);

		// Include SQL query processing class 
		require './config/ssp.class.php';

		// Output data as json format 
		echo json_encode(
			SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
		);
	}


	public function obtenerDepartamentos()
	{
		$modelDepartamentos = new DepartamentosModel();

		return $departamentos = $modelDepartamentos->listarDepartamentos();
	}

	public function registrarDepartamentos()
	{

		$modelDepartamentos = new DepartamentosModel();

		/* --------- Funcion limpiar cadenas ---------*/

		$nombre 				= Validacion::limpiar_cadena($_POST['nombre']);
		$estatus 				= Validacion::limpiar_cadena($_POST['estatus']);
		$fecha_actual = date("Y-m-d");

		//Validar que el visitante no ingrese dos veces al sistema el mismo día
		$entrada_departamento_hoy = $modelDepartamentos->validarEntradaDia($nombre, $fecha_actual);

		foreach ($entrada_departamento_hoy as $entrada_departamento_hoy) {
			$id_entrada_departamento = $entrada_departamento_hoy['id'];
		}



		if (!empty($id_entrada_departamento)) {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'El departamento ya ha sido ingresado el día de hoy',
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
					'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el nombre de el departamento.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}



		/* comprobar campos vacios */
		if ($nombre == "" || $estatus == "") {
			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Verifica que todos los campos estén llenos a la hora de registrar un departamento.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		$datos = array(
			'nombre'		=> $_POST['nombre'],
			'estatus'		=> $_POST['estatus'],
			'fecha'			=> $fecha_actual,
		);

		$resultado = $modelDepartamentos->registrarDepartamentos($datos);

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El departamento ha sido guardado en la base de datos'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al guardar el departamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	public function verDepartamentos()
	{
		$modeldepartamentos = new DepartamentosModel();

		$id_departamento = $_POST['id_departamento'];

		$listar = $modeldepartamentos->obtenerDepartamento($id_departamento);


		foreach ($listar as $listar) {

			$id_departamento 	= $listar['id'];
			$nombre 		= $listar['nombre'];
			$estatus 		= $listar['estatus'];
			$fecha 				= $listar['fecha'];
		}

		$data = [
			'data' => [
				'success'            =>  true,
				'message'            => 'Registro encontrado',
				'info'               =>  '',
				'id'				 => $id_departamento,
				'nombre'			 => $nombre,
				'estatus'		     => $estatus,
				'fecha'		     	 => $fecha,
			],
			'code' => 0,
		];

		echo json_encode($data);

		exit();
	}



	public function modificarDepartamentos()
	{

		$modeldepartamento  = new DepartamentosModel();
		$id_departamento  = $_POST['id_departamento'];
		/* --------- Funcion limpiar cadenas ---------*/

		$nombre			= Validacion::limpiar_cadena($_POST['nombre']);
		$estatus 				= Validacion::limpiar_cadena($_POST['estatus']);

		$fecha_actual = date("Y-m-d");

		//Validar que el visitante no ingrese dos veces al sistema el mismo día
		$entrada_departamento_hoy = $modeldepartamento->validarEntradaDia($nombre, $fecha_actual);
		foreach ($entrada_departamento_hoy as $entrada_departamento_hoy) {
			$id_entrada_departamento = $entrada_departamento_hoy['id'];
		}



		if (!empty($id_entrada_departamento)) {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'El Departamento ya ha sido ingresado el día de hoy',
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
					'info'         => 'Solo se permiten caracteres alfabéticos con una longitud de 40 caracteres en el departamento.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}

		$datos = array(

			'nombre'		=> $_POST['nombre'],

			'estatus'		=> $_POST['estatus'],
		);

		/* comprobar campos vacios */
		if ($nombre == "" || $estatus == "") {
			$data = [
				'data' => [
					'error'        => true,
					'message'      => 'Datos inválidos',
					'info'         => 'Verifica que todos los campos estén llenos a la hora de registrar un departamento.'
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}



		$resultado = $modeldepartamento->modificarDepartamentos($id_departamento, $datos);


		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'Los datos del Departamento han sido modificados'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar los datos del departamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}

	/*----------Metodo para inactivar Departamentos-------*/


	public function inactivarDepartamento()
	{
		$modeldepartamentos = new DepartamentosModel();
		$id_departamento = $_POST['id_departamento'];

		$estado = $modeldepartamentos->obtenerDepartamento($id_departamento);

		foreach ($estado as $estado) {
			$estado_Departamentos = $estado['estatus'];
		}

		if ($estado_Departamentos == 1) {
			$datos = array(
				'estatus'		=> 0,
			);

			$resultado = $modeldepartamentos->modificarDepartamentos($id_departamento, $datos);
		} else {
			$datos = array(
				'estatus'		=> 1,
			);

			$resultado = $modeldepartamentos->modificarDepartamentos($id_departamento, $datos);
		}

		if ($resultado) {
			$data = [
				'data' => [
					'success'            =>  true,
					'message'            => 'Guardado exitosamente',
					'info'               =>  'El estado del departamento ha sido modificado'
				],
				'code' => 1,
			];

			echo json_encode($data);
			exit();
		} else {
			$data = [
				'data' => [
					'success'            =>  false,
					'message'            => 'Ocurrió un error al modificar el estado del departamento',
					'info'               =>  ''
				],
				'code' => 0,
			];

			echo json_encode($data);
			exit();
		}
	}
}
