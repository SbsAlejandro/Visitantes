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
                <h3 class="m-0">Roles</h3>
                <button class="btn btn-primary btn-circle" title="Agregar Roles" data-toggle="modal" data-target="#modalAgregarRoles">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablaRoles" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre de los roles</th>
                                <th>Estado</th>
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

<!-- Modal Agregar Roles-->
<div class="modal fade" id="modalAgregarRoles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarRolesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarRolesLabel">Agregar Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarRoles">

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rol">nombre</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="rol" placeholder="Ingresa el rol">
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
                <button type="button" class="btn btn-primary" id="agregar_roles" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>










<!-- Modal Actualizar Role-->
<div class="modal fade" id="modalActualizarRoles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarRolesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarRolesLabel">Modificar Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarRoles">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_roles_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rol_update">Nombre de roles</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="rol_update" placeholder="Ingresa el rol">
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
                <button type="submit" class="btn btn-primary" id="modificar_roles" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>






<!-- Modal Visualizar Roles-->
<div class="modal fade" id="modalVisualizarRoles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalVisualizarRolesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarRolesLabel">Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <a href="#" class="list-group-item  list-group-item-action active">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 id="rol_roles" class="mb-1">Informacion del Usuario</h5>
                            <small id="fecha_roles"></small>
                        </div>

                        <p id="estatus_roles" class="mb-1"></p>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>