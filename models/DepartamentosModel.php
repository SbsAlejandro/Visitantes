<?php

require_once 'ModeloBase.php';

class DepartamentosModel extends ModeloBase {

	public function __construct() {
		parent::__construct();
	}

/*------------Metodo para listar Departamentos--------*/
	public function listarDepartamentos() {
		$db = new ModeloBase();
		$query = "SELECT * FROM departamentos";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}	
/*------------ Metodo para registrar departamentos--------*/
    public function registrarDepartamentos($datos) {
        $db = new ModeloBase();
		try {
			$insertar = $db->insertar('departamentos', $datos);
			return $insertar;
		}catch	(PDOException $e) {
			echo $e->getMessage();
		} 
    }

/*------------ Metodo para mostrar un registro Departamentos --------*/
public function obtenerDepartamento($id) {
	$db = new ModeloBase();
	$query = "SELECT * FROM departamentos WHERE id = ".$id."";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}



/*------------ Metodo para modificar un registro --------*/
	public function modificarDepartamentos($id, $datos) {
		$db = new ModeloBase();
		try {
			$editar = $db->editar('departamentos', $id, $datos);
			return $editar;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


/*------------ Metodo para mostrar un registro Departamentos --------*/

public function validarEntradaDia($nombre, $fecha_actual) {
	$db = new ModeloBase();
	$query = "SELECT * FROM departamentos WHERE nombre = '$nombre' AND fecha = '$fecha_actual'";
	$resultado = $db->obtenerTodos($query);
	return $resultado;
}



	
/*


	public function eliminarCliente($id) {
		$db = new ModeloBase();
		try {
			$eliminar = $db->eliminar('cliente', $id);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	*/


}


	
	

