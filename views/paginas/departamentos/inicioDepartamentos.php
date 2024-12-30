<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 title_boton" style="background-color: #FFF;  display: flex;
    justify-content: space-between;">
            <h3 class="m-0">Departamentos</h3>
            <button class="btn btn-primary btn-circle" title="Agregar paciente" data-toggle="modal" data-target="#modalAgregarDepartamentos">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablaDepartamentos" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre de Departamentos</th>
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


<!-- Modal Agregar Departamento-->
<div class="modal fade" id="modalAgregarDepartamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAgregarDepartamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarDepartamentosLabel">Agregar Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formRegistrarDepartamento">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre">Nombre del departamento</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="nombre" placeholder="Nombre...">
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <select class="form-control" name="estatus" id="estatus">
                                    <option value="">Seleccione</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="Cerrar el modal" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregar_departamentos" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Actualizar Departamento-->

<div class="modal fade" id="modalActualizarDepartamento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarDepartamentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarDepartamentoLabel">Modificar Departamentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formActualizarDepartamento">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input id="id_departamento_update" type="hidden" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre_update">Nombre de nombres</label>
                                <input class="form-control" type="text" onkeyup="mayus(this);" id="nombre_update" placeholder="Ingresa el nombre">
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
                <button type="button" class="btn btn-primary" id="modificar_departamentos" title="Guardar cambios"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>







<!-- Modal Visualizar Paciente-->
<div class="modal fade" id="modalVisualizarDepartamento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalVisualizarDepartamentoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVisualizarDepartamentoLabel">Departamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <a href="#" class="list-group-item  list-group-item-action active">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 id="nombre_departamento" class="mb-1">List group item heading</h5>
                            <small id="fecha_departamento"></small>
                        </div>

                        <p id="estatus_departamento" class="mb-1"></p>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>