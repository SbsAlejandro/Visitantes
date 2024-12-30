<?php

require_once 'config.php';

$page = $_GET['page'];

if (!empty($page)) {
	#http://crud-mvc/index.php?page=insertar
	$data = array(
		'inicio' => array('model' => 'dashboardModel', 'view' => 'inicio', 'controller' => 'dashboardController'),
		/* Url Modulo Pacientes */
		// 'inicioPacientes' => array('model' => 'PacientesModel', 'view' => 'inicioPacientes', 'controller' => 'PacientesController'),
		// 'registrarPaciente' => array('model' => 'PacientesModel', 'view' => 'registrarPaciente', 'controller' => 'PacientesController'),
		// 'listarPacientes' => array('model' => 'PacientesModel', 'view' => 'listarPacientes', 'controller' => 'PacientesController'),
		// 'listarActualizacion' => array('model' => 'PacientesModel', 'view' => 'listarActualizacion', 'controller' => 'PacientesController'),
		// 'modificarPaciente' => array('model' => 'PacientesModel', 'view' => 'modificarPaciente', 'controller' => 'PacientesController'),
		// 'inactivarPaciente' => array('model' => 'PacientesModel', 'view' => 'inactivarPaciente', 'controller' => 'PacientesController'),
		/* Url Login*/
		'inicioUsuario' => array('model' => 'UsuarioModel', 'view' => 'inicioUsuario', 'controller' => 'UsuarioController'),
		'loginUsuario' => array('model' => 'UsuarioModel', 'view' => 'loginUsuario', 'controller' => 'UsuarioController'),
		'logoutUsuario' => array('model' => 'UsuarioModel', 'view' => 'logoutUsuario', 'controller' => 'UsuarioController'),
		/*Url Modulo Usuario*/
		'listarUsuarios' => array('model' => 'UsuarioModel', 'view' => 'listarUsuarios', 'controller' => 'UsuarioController'),
		'ModuloUsuario' => array('model' => 'UsuarioModel', 'view' => 'ModuloUsuario', 'controller' => 'UsuarioController'),
		'registrarUsuario' => array('model' => 'UsuarioModel', 'view' => 'registrarUsuario', 'controller' => 'UsuarioController'),
		'verUsuario' => array('model' => 'UsuarioModel', 'view' => 'verUsuario', 'controller' => 'UsuarioController'),
		'modificarUsuario' => array('model' => 'UsuarioModel', 'view' => 'modificarUsuario', 'controller' => 'UsuarioController'),
		'inactivarUsuario' => array('model' => 'UsuarioModel', 'view' => 'inactivarUsuario', 'controller' => 'UsuarioController'),
		'registrarUsuarioConFoto' => array('model' => 'UsuarioModel', 'view' => 'registrarUsuarioConFoto', 'controller' => 'UsuarioController'),


		/* Modulo Visitantes */
		'inicioVisitantes' => array('model' => 'VisitanteModel', 'view' => 'inicioVisitantes', 'controller' => 'VisitanteController'),
		'listarVisitantes' => array('model' => 'VisitanteModel', 'view' => 'listarVisitantes', 'controller' => 'VisitanteController'),
		'registrarVisitante' => array('model' => 'VisitanteModel', 'view' => 'registrarVisitante', 'controller' => 'VisitanteController'),
		'verVisitante' => array('model' => 'VisitanteModel', 'view' => 'verVisitante', 'controller' => 'VisitanteController'),
		'modificarVisitante' => array('model' => 'VisitanteModel', 'view' => 'modificarVisitante', 'controller' => 'VisitanteController'),
		'inactivarVisitante' => array('model' => 'VisitanteModel', 'view' => 'inactivarVisitante', 'controller' => 'VisitanteController'),
		'registrarVisitanteConFoto' => array('model' => 'VisitanteModel', 'view' => 'registrarVisitanteConFoto', 'controller' => 'VisitanteController'),
		'modificarVisitanteConFoto' => array('model' => 'VisitanteModel', 'view' => 'modificarVisitanteConFoto', 'controller' => 'VisitanteController'),
		'consultarVisitanteCedula' => array('model' => 'VisitanteModel', 'view' => 'consultarVisitanteCedula', 'controller' => 'VisitanteController'),
		/* Modulo Departamentos */
		'inicioDepartamentos' => array('model' => 'DepartamentosModel', 'view' => 'inicioDepartamentos', 'controller' => 'DepartamentosController'),
		'listarDepartamentos' => array('model' => 'DepartamentosModel', 'view' => 'listarDepartamentos', 'controller' => 'DepartamentosController'),
		'registrarDepartamentos' => array('model' => 'DepartamentosModel', 'view' => 'registrarDepartamentos', 'controller' => 'DepartamentosController'),
		'verDepartamentos' => array('model' => 'DepartamentosModel', 'view' => 'verDepartamentos', 'controller' => 'DepartamentosController'),
		'modificarDepartamentos' => array('model' => 'DepartamentosModel', 'view' => 'modificarDepartamentos', 'controller' => 'DepartamentosController'),
		'inactivarDepartamento' => array('model' => 'DepartamentosModel', 'view' => 'inactivarDepartamento', 'controller' => 'DepartamentosController'),

		/* Modulo persona no deseadas */
		'inicioPersonal' => array('model' => 'PersonalModel', 'view' => 'inicioPersonal', 'controller' => 'PersonalController'),
		'listarPersonal' => array('model' => 'PersonalModel', 'view' => 'listarPersonal', 'controller' => 'PersonalController'),
		'registrarPersonal' => array('model' => 'PersonalModel', 'view' => 'registrarPersonal', 'controller' => 'PersonalController'),
		'verPersonal' => array('model' => 'PersonalModel', 'view' => 'verPersonal', 'controller' => 'PersonalController'),
		'modificarPersonal' => array('model' => 'PersonalModel', 'view' => 'modificarPersonal', 'controller' => 'PersonalController'),
		'inactivarPersonal' => array('model' => 'PersonalModel', 'view' => 'inactivarPersonal', 'controller' => 'PersonalController'),


		/* Modulo Roles */
		'inicioRoles' => array('model' => 'RolesModel', 'view' => 'inicioRoles', 'controller' => 'RolesController'),
		'listarRoles' => array('model' => 'RolesModel', 'view' => 'listarRoles', 'controller' => 'RolesController'),
		'registrarRoles' => array('model' => 'RolesModel', 'view' => 'registrarRoles', 'controller' => 'RolesController'),
		'verRoles' => array('model' => 'RolesModel', 'view' => 'verRoles', 'controller' => 'RolesController'),
		'modificarRoles' => array('model' => 'RolesModel', 'view' => 'modificarRoles', 'controller' => 'RolesController'),
		'inactivarRoles' => array('model' => 'RolesModel', 'view' => 'inactivarRoles', 'controller' => 'RolesController'),

	


	);

	foreach ($data as $key => $components) {
		if ($page == $key) {
			$model = $components['model'];
			$view = $components['view'];
			$controller = $components['controller'];
		}
	}

	if (isset($model)) {
		require_once 'controllers/' . $controller . '.php';
		$objeto = new $controller();
		$objeto->$view();
	}
} else {
	header('Location: index.php?page=inicioUsuario');
}
