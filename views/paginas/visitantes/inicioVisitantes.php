<!-- Begin Page Content -->
<?php


require_once 'controllers/DepartamentosController.php';
$objeto                 = new DepartamentosController();

$departamentos          = $objeto->obtenerDepartamentos();
$departamentos_update   = $objeto->obtenerDepartamentos();


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


<?php

    if($rol == 3)
    {
        ?>
            <style>
                .btn_update {
                    display: none !important;
                }
            </style>
        <?php
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
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
                justify-content: space-between;">
            <h3 class="m-0">Visitantes</h3>
            <button class="btn btn-primary btn-circle" title="Agregar Visitante" data-toggle="modal" data-target="#modalAgregarVisitante">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablaVisitante" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <!-- <th>Empresa</th>
                            <th>Asunto</th> -->
                            <th>Piso</th>
                            <th>fecha</th>
                            <th>hora</th>
                            <th>meridien</th>
                            <th>Departamentos</th>
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

<!-- Modal Agregar Visitantes-->
<div class="modal fade" id="modalAgregarVisitante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarVisitanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarVisitanteLabel">Agregar Visitante</h5>        
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="" id="cont_consultar_visitante">
                    
                        <div class="row" style="display: flex; justify-content:center;" >
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" id="cedula_visitante" placeholder="Ingrese la cédula del visitante...">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <button class="btn btn-primary" type="button" id="buscar_cedula_visitante">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    
                </div>
                <form id="formRegistrarVisitante" style="display: none;">
                    <!-- style="display: none;" -->
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cedula">Cedula</label>
                                        <input class="form-control" type="text" name="cedula" maxlength="10" id="cedula" placeholder="Ingresa el número de cèdula">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control" type="text" name="nombre" onkeyup="mayus(this);" maxlength="25" id="nombre" placeholder="Ingresa el nombre">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input class="form-control" type="apellido" name="apellido" onkeyup="mayus(this);" maxlength="25" id="apellido" placeholder="Ingresa el apellido">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="empresa">Empresa</label>
                                        <input class="form-control" type="text" name="empresa" onkeyup="mayus(this);" maxlength="100" id="empresa" placeholder="Ingresa la empresa de donde viene ">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="autorizador">Autorizador</label>
                                        <input class="form-control" type="text" name="autorizador" onkeyup="mayus(this);" maxlength="100" id="autorizador" placeholder="Ingresa el autorizador">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="asunto">Asunto</label>
                                        <input class="form-control"style="height: 71px;" type="text" name="asunto" onkeyup="mayus(this);" maxlength="100" id="asunto" placeholder="Asunto">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="piso">Piso</label>
                                        <select class="form-control" name="piso" id="piso">
                                            <option value="">Seleccione</option>
                                            <option value="17">17</option>
                                            <option value="22">22</option>
                                        </select>
                                    </div>

                                    
                                </div>

                                

                                <div class="col-sm-6">

                                    <!-- <div class="form-group">
                                        <label for="nombre">Fecha</label>
                                        <input class="form-control" type="datetime-local" name="fecha" onkeyup="mayus(this);" maxlength="25" id="fecha">
                                    </div> -->

                                    <div class="form-group">
                                        <label for="departamento">Departamento</label>
                                        <select class="form-control" name="departamento" id="departamento">
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($departamentos as $departamentos) {
                                            ?>
                                                <option value="<?= $departamentos['id'] ?>"><?= $departamentos['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono</label>
                                        <input class="form-control" type="text" name="telefono"  id="telefono" placeholder="Ingresa el número de telefono">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="codigo_carnet">Codigo de carnet</label>
                                        <input class="form-control" type="text" name="codigo_carnet" onkeyup="mayus(this);" maxlength="25" id="codigo_carnet" placeholder="Ingrese el codigo de el carnet">
                                    </div>
                                </div>

                            </div>      



                            <div class="row">
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

                                <div class="col-sm-6" id="cont_input_file">
                                    <div class="form-group">
                                        <label for="Foto">Foto</label>
                                        <input type="file" class=" form-control" name="archivo" id="subirfoto" accept="image/*">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <div class="row">
                                        <div class="form-check radio_check">
                                            <input class="form-check-input" type="radio" name="radio_select" id="radiosfoto" value="1" checked>
                                            <label class="form-check-label" for="radiosfoto">Seleccionar Foto</label>
                                        </div>
                                        <div class="form-check radio_check">
                                            <input class="form-check-input" type="radio" name="radio_select" id="radiotfoto" value="0">
                                            <label class="form-check-label" for="radiotfoto">Tomar Foto</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="canvas" class="none" style="display: none;"></canvas>
                                    <div style="width: 100%;" class="container_radio">
                                        <video style="width: 100%;" id="video" autoplay="autoplay" class="video_container none"></video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="agregar_visitante" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>





<!-- Modal Actualizar Visitantes-->
<div class="modal fade" id="modalActualizarVisitante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarVisitanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarVisitanteLabel">Modificar Visitante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModificarVisitante">

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cedula_update">Cedula</label>
                                        <input class="form-control" type="text" name="cedula_update" maxlength="10" id="cedula_update" placeholder="Ingresa el número de Foto">
                                        <input type="hidden" value="" name="id_visitante_update" id="id_visitante_update">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nombre_update">Nombre</label>
                                        <input class="form-control" type="text" name="nombre_update" onkeyup="mayus(this);" maxlength="25" id="nombre_update" placeholder="Ingresa el nombre">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="apellido_update">Apellido</label>
                                        <input class="form-control" type="text" name="apellido_update" onkeyup="mayus(this);" maxlength="25" id="apellido_update" placeholder="Ingresa el apellido">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="empresa_update">Empresa</label>
                                        <input class="form-control" type="text" name="empresa_update" onkeyup="mayus(this);" maxlength="100" id="empresa_update" placeholder="Ingresa la empresa de donde viene ">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="telefono_update">Telefono</label>
                                        <input class="form-control" type="text" name="telefono_update"  id="telefono_update" placeholder="Ingresa el número de telefono">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="codigo_carnet_update">Codigo de carnet</label>
                                        <input class="form-control" type="text" name="codigo_carnet_update" onkeyup="mayus(this);" maxlength="25" id="codigo_carnet_update" placeholder="Ingrese el codigo de el carnet">
                                    </div>
                                </div>

                            </div>                        

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="autorizador_update">Autorizador</label>
                                        <input class="form-control" type="text" name="autorizador_update" onkeyup="mayus(this);" maxlength="100" id="autorizador_update" placeholder="Ingresa el autorizador">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="asunto_update">Asunto</label>
                                        <input class="form-control" type="text" name="asunto_update" onkeyup="mayus(this);" maxlength="100" id="asunto_update" placeholder="Asunto">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="piso_update">Piso</label>
                                        <select class="form-control" name="piso_update" id="piso_update">
                                            <option value="">Seleccione</option>
                                            <option value="17">17</option>
                                            <option value="22">22</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="departamento_update">Departamento</label>
                                        <select class="form-control" name="departamento_update" id="departamento_update">
                                            <option value="">Seleccione</option>
                                            <?php
                                            foreach ($departamentos_update as $departamentos_update) {
                                            ?>
                                                <option value="<?= $departamentos_update['id'] ?>"><?= $departamentos_update['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="estatus_update">Estatus</label>
                                        <select class="form-control" name="estatus_update" id="estatus_update">
                                            <option value="">Seleccione</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="cont_input_file_update">
                                    <div class="form-group">
                                        <label for="foto_update">Foto</label>
                                        <input type="file" class=" form-control" name="archivo" id="subirfotoUpdate" accept="image/*">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <div class="row">
                                        <div class="form-check radio_check">
                                            <input class="form-check-input" type="radio" name="radio_select_update" id="radiosfotoUpdate" value="1" checked>
                                            <label class="form-check-label" for="radiosfotoUpdate">Seleccionar Foto</label>
                                        </div>
                                        <div class="form-check radio_check">
                                            <input class="form-check-input" type="radio" name="radio_select_update" id="radiostfotoUpdate" value="0">
                                            <label class="form-check-label" for="radiostfotoUpdate">Tomar Foto</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="canvas_update" class="none" style="display:none;"></canvas>
                                    <div style="width: 100%;" class="container_radio">
                                        <video style="display:none; width:100%;" id="video_update" autoplay="autoplay" class="video_container none"></video>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <p>Foto del visitante</p>
                            <img title="Foto del visitante" style="width: 100%; height: 100%;" id="foto_view_update" src="" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="modificar_visitante" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








<!-- Modal Visualizar Visitantes-->
<div class="modal fade" id="modalVisualizarVisitante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalVisualizarVisitanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarVisitanteLabel">Visitantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <a title="Datos del visitante" href="#" class="list-group-item  list-group-item-action active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 id="nombre_apellido" class="mb-1">Informacion del Visitantes</h5>
                                    <small id="fecha_visitante"></small>
                                </div>
                                <p id="consultarVisitanteCedula" class="mb-1"></p>
                                <p id="nombre_visitante" class="mb-1"></p>
                                <p id="apellido_visitante" class="mb-1"></p>
                                <p id="asunto_visitante" class="mb-1"></p>
                                <p id="autorizador_visitante" class="mb-1"></p>
                                <p id="departamento_visitante" class="mb-1"></p>
                                <p id="empresa_visitante" class="mb-1"></p>            
                                <p id="telefono_visitante" class="mb-1"></p>            
                                <p id="codigo_carnet_visitante" class="mb-1"></p>            
                                <p id="piso_visitante" class="mb-1"></p>
                                
                                

                                <br>
                                <p id="estatus_visitante" class="mb-1"></p>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <img title="Foto del visitante" style="width: 100%; height: 100%;" id="foto_visitante" src="" alt="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


