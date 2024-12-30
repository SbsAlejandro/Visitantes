<!-- Begin Page Content -->

<?php

if (session_status() === PHP_SESSION_ACTIVE) {
  //echo "La sesión está activa.";
  $usuario            = $_SESSION['usuario'];
  $id_usuario         = $_SESSION['user_id'];
  $rol                = $_SESSION['rol_usuario'];
} else {
  //echo "La sesión no está activa.";
  session_start();
  $usuario            = $_SESSION['usuario'];
  $id_usuario         = $_SESSION['user_id'];
  $rol           = $_SESSION['rol_usuario'];
}


?>

<style>
  .file-upload {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 150px;
    padding: 30px;
    border: 1px dashed silver;
    border-radius: 8px;
  }

  .file-upload input {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    cursor: pointer;
    opacity: 0;
  }

  .preview_img {
    height: 80px;
    width: 80px;
    border: 4px solid silver;
    border-radius: 100%;
    object-fit: cover;
  }
</style>


<?php

if ($rol == 3) {
  echo "<h1>No tienes los permisos suficientes para ingresar en este modulo</h1>";
} else {
?>
  <div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
justify-content: space-between;">
        <h3 class="m-0">Personal no Autorizado</h3>
        <button class="btn btn-primary btn-circle" title="Agregar Personal" data-toggle="modal" data-target="#modalAgregarPersonal">
          <i class="fas fa-plus"></i>
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="tablaPersonal" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Estatus</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
<?php
}

?>



<!-- Modal Agregar Personal-->
<div class="modal fade" id="modalAgregarPersonal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarPersonalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarPersonalLabel">Agregar Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="formRegistrarPersonal">

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cedula">Cedula</label>
                <input class="form-control" type="text" id="cedula" placeholder="V/E">
              </div>
            </div>


            <div class="col-sm-6">
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input class="form-control" type="text" onkeyup="mayus(this);" id="nombre" placeholder="Ingresa el nombre">
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input class="form-control" type="apellido" onkeyup="mayus(this);" id="apellido" placeholder="Ingresa el apellido">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="estatus">Estatus</label>
                <select class="form-control" name="estatus" id="estatus">
                  <option value="">Seleccione</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>





        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="agregar_personal" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Actualizar Personal-->
<div class="modal fade" id="modalActualizarPersonal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarPersonalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalActualizarPersonalLabel">Modificar Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="formActualizarPersonal">

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <input id="id_personal_update" type="hidden" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cedula_update">Cedula</label>
                <input class="form-control" type="text" onkeyup="mayus(this);" id="cedula_update" placeholder="V/E">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="nombre_update">Nombre</label>
                <input class="form-control" type="text" onkeyup="mayus(this);" id="nombre_update" placeholder="Ingresa el nombre">
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="apellido_update">Apellido</label>
                <input class="form-control" type="apellido" onkeyup="mayus(this);" id="apellido_update" placeholder="Ingresa la Apellido">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="estatus_update">Estatus</label>
                <select class="form-control" name="estatus" id="estatus_update">
                  <option value="">Seleccione</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="modificar_personal" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>








<!-- Modal Visualizar Personal-->
<div class="modal fade" id="modalVisualizarPersonal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalVisualizarPersonalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVisualizarPersonalLabel">Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="list-group">
          <a href="#" class="list-group-item  list-group-item-action active">
            <div class="d-flex w-100 justify-content-between">
              <h5 id="nombre_apellido" class="mb-1">Informacion del Personal</h5>
              <small id="fecha_personal"></small>
            </div>
            <p id="cedula_personal" class="mb-1"></p>
            <p id="nombre_personal" class="mb-1"></p>
            <p id="empresa_personal" class="mb-1"></p>
            <p id="autorizador_personal" class="mb-1"></p>
            <p id="piso_personal" class="mb-1"></p>
            <p id="asunto_personal" class="mb-1"></p>
            <p id="apellido_personal" class="mb-1"></p>
            <p id="estatus_personal" class="mb-1"></p>
          </a>
        </div>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>