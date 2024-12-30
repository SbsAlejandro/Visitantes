
/* Loader */
$(document).ready(function () {
    setTimeout(() => {
        document.getElementById('cont-loader').setAttribute('style', 'display:none;');
    }, "1000");
});

// function to display image before upload
$("input.image").change(function () {
    var file = this.files[0];
    var url = URL.createObjectURL(file);
    $(this).closest(".row").find(".preview_img").attr("src", url);
});


function mayus(e) {
    e.value = e.value.toUpperCase();
}







/* -------------- Modulo Usuarios ------------------ */

/*----------------- Listar Usuarios -------------*/
$(document).ready(function () {

    $('#tablaUsuario').DataTable({
        "order": [[0, 'DESC']],
        "procesing": true,
        "serverSide": true,
        "ajax": 'index.php?page=listarUsuarios',
        "pageLength": 4,
        "createdRow": function (row, data, dataIndex) {
            if (data[9] == 0) {

                $(row).addClass('table-danger');
            }
            else {
                //$(row).addClass('table-success');
            }
        },
        "columnDefs": [
            {
                "orderable": false,
                "targets": 8,
                render: function (data, type, row, meta) {

                    if (row[9] == 1) {
                        let botones = `
                    <button type="button" class="btn btn-primary btn-sm" onclick="verUsuario(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionUsuario(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-danger btn-sm" onclick="inactivarUsuario(`+ row[0] + `)"><i class="fas fa-trash"></i></button>  `;
                        return botones;
                    } else {
                        let botones = `
                <button type="button" class="btn btn-primary btn-sm" onclick="verUsuario(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionUsuario(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;

               <button type="button" class="btn btn-success btn-sm" onclick="inactivarUsuario(`+ row[0] + `)"><i class="fas fa-fas fa-retweet"></i></button>  `;
                        return botones;
                    }


                }
            }
        ],
        dom: 'Bfrtip',
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});

/* -------------- Agregar Usuarios ------------------ */

/* -------------- Agregar Usuario ------------------ */
$("#formRegistrarUsuario").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

    let cedula                      = document.getElementById('cedula').value;
    let nombre                      = document.getElementById('nombre').value;
    let apellido                    = document.getElementById('apellido').value;
    let correo                      = document.getElementById('correo').value;
    let contrasena                  = document.getElementById('contrasena').value;
    let confirmar_contrasena        = document.getElementById('confirmar_contrasena').value;
    let usuario                     = document.getElementById('usuario').value;
    let rol                         = document.getElementById('rol').value;
    let estatus                     = document.getElementById('estatus').value;

    /* comprobar campos vacios */
    if (cedula == "" || nombre == "" || apellido == "" || correo == "" || contrasena == "" || confirmar_contrasena == "" || usuario == "" || estatus == "") {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    if (contrasena != confirmar_contrasena) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Las contraseñas no coinciden.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }


    $.ajax({
        url: 'index.php?page=registrarUsuario',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                $('#tablaUsuario').DataTable().ajax.reload();

                document.getElementById("formRegistrarUsuario").reset();
                //$("#radiosfoto").click();

                $('#modalAgregarUsuario').modal('hide');


            } else {
                Swal.fire({
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });

});



/* -------------- Ver Usuario ------------------ */
function verUsuario(id) {

    let id_usuario = id;

    $.ajax({
        url: "index.php?page=verUsuario",
        type: 'post',
        dataType: 'json',
        data: {
            id_usuario: id_usuario

        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("cedula_usuario").innerHTML = "Cedula: " + response.data.cedula;
                document.getElementById("nombre_usuario").innerHTML = response.data.nombre + " " + response.data.apellido;
                document.getElementById("foto_usuario").innerHTML = "Foto: " + response.data.foto;
                document.getElementById("usuario_usuario").innerHTML = "Usuario: " + response.data.usuario;
                document.getElementById("apellido_usuario").innerHTML = "Apellido: " + response.data.apellido;
                document.getElementById("correo_usuario").innerHTML = "Correo: " + response.data.correo;

                document.getElementById("fecha_usuario").innerHTML = "Fecha: " + response.data.fecha;

                let ruta_img = "foto_usuario/" + response.data.foto;

                document.getElementById("foto_usuario").setAttribute('src', ruta_img);

                if (response.data.estatus == 1) {
                    document.getElementById("estatus_usuario").innerHTML = "Estado: <button class='btn btn-success'>Activo</button>";
                } else {
                    document.getElementById("estatus_usuario").innerHTML = "Estado: <button class='btn btn-danger'>inactivo</button>";
                }

                $("#modalVisualizarUsuario").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });
}



/*Listar datos para actualizacion de usuario*/
function listarActualizacionUsuario(id) {

    let id_usuario = id;

    let id_usuario_update = document.getElementById("id_usuario_update").value;
    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let usuario = document.getElementById("usuario_update").value;
    let contrasena = document.getElementById("contrasena_update").value;
    let correo = document.getElementById("correo_update").value;
    let estatus = document.getElementById("estatus_update").value;
    let input_id_usuario = document.getElementById("id_usuario");

    let listar = "listar";

    $.ajax({
        url: "index.php?page=verUsuario",
        type: 'post',
        dataType: 'json',
        data: {
            id_usuario: id_usuario
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("id_usuario_update").value = response.data.id;
                document.getElementById("cedula_update").value = response.data.cedula;
                document.getElementById("nombre_update").value = response.data.nombre;
                document.getElementById("apellido_update").value = response.data.apellido;
                document.getElementById("usuario_update").value = response.data.usuario;
                document.getElementById("correo_update").value = response.data.correo;
                document.getElementById("estatus_update").value = response.data.estatus;
                document.getElementById("rol_update").value = response.data.rol;
                document.getElementById("img_update_preview").setAttribute('src', 'foto_usuario/' + response.data.foto);

                $("#modalActualizarUsuarios").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });


}

$(document).ready(function () {
    $("#check_foto").change(function () {
        if ($(this).is(":checked")) {
            console.log("El checkbox ha sido seleccionado");
            document.getElementById("cont_input_file").removeAttribute('style');
            // Agrega aquí el código que deseas ejecutar cuando el checkbox es seleccionado
        } else {
            //console.log("El checkbox ha sido deseleccionado");
            document.getElementById("cont_input_file").setAttribute('style', 'display:none;')
            // Agrega aquí el código que deseas ejecutar cuando el checkbox es deseleccionado
        }
    });
});

$("#check_foto").is(":checked")
/* -------------- Modificar Usuario ------------------ */

$("#formActualizarUsuario").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

    let id_usuario_update = document.getElementById("id_usuario_update").value;
    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let usuario = document.getElementById("usuario_update").value;
    let contrasena = document.getElementById("contrasena_update").value;
    let correo = document.getElementById("correo_update").value;
    let estatus = document.getElementById("estatus_update").value;
    let rol_update = document.getElementById("rol_update").value;
    let confirmar_contrasena_update = document.getElementById("confirmar_contrasena_update").value;

    /* comprobar campos vacios */
    if (cedula == "" || nombre == "" || apellido == "" || usuario == "" || contrasena == "" || correo == "" || estatus == "" || rol_update == "") {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }


    if (contrasena != confirmar_contrasena_update) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Las constraseñas no coinciden.',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    $.ajax({
        url: 'index.php?page=modificarUsuario',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                console.log(respuesta.data); 
                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                document.getElementById("formActualizarUsuario").reset();

                $('#modalActualizarUsuarios').modal('hide');

            
                $('#tablaUsuario').DataTable().ajax.reload();


            } else {
                Swal.fire({
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });
});

/* -------------- Activar e Inactivar Usuario ------------------ */
function inactivarUsuario(id) {
    var id_usuario = id;

    Swal.fire({
        title: '¿Está seguro de moficar el estado del usuario?',
        // text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "index.php?page=inactivarUsuario",
                type: 'post',
                dataType: 'json',
                data: {
                    id_usuario: id_usuario
                }
            })
                .done(function (response) {
                    if (response.data.success == true) {
                        $('#tablaUsuario').DataTable().ajax.reload();
                    }
                    else {

                        Swal.fire({
                            icon: 'error',
                            title: response.data.message,
                            confirmButtonColor: '#0d6efd',
                            text: response.data.info
                        });
                    }
                })
                .fail(function () {
                    console.log("error");
                });
        }
    })
}






/* -------------- Modulo Departamentos ------------------ */
/*-----------------Listar Departamentos-------------*/
$(document).ready(function () {

    $('#tablaDepartamentos').DataTable({
        "order": [[0, 'DESC']],
        "procesing": true,
        "serverSide": true,
        "ajax": 'index.php?page=listarDepartamentos',
        "pageLength": 10,
        "createdRow": function (row, data, dataIndex) {
            if (data[4] == 0) {

                $(row).addClass('table-danger');
            }
            else {
                //$(row).addClass('table-success');
            }
        },
        "columnDefs": [
            {
                "orderable": false,
                "targets": 3,
                render: function (data, type, row, meta) {

                    if (row[4] == 1) {
                        let botones = `
                      <button type="button" class="btn btn-primary btn-sm" onclick="verDepartamento(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionDepartamento(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-danger btn-sm" onclick="inactivarDepartamento(`+ row[0] + `)"><i class="fas fa-trash"></i></button>  `;
                        return botones;
                    } else {
                        let botones = `
                  <button type="button" class="btn btn-primary btn-sm" onclick="VerDepartamento(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionDepartamento(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-success btn-sm" onclick="inactivarDepartamento(`+ row[0] + `)"><i class="fas fa-fas fa-retweet"></i></button>  `;
                        return botones;
                    }


                }
            }
        ],
        dom: 'Bfrtip',
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});
/* -------------- Agregar Departamentos ------------------ */
var agregar_departamento;
if (agregar_departamento = document.getElementById("agregar_departamentos")) {

    agregar_departamento.addEventListener("click", agregarDepartamento, false);


    function agregarDepartamento() {
        
        
        let nombre = document.getElementById("nombre").value;
        
        let estatus = document.getElementById("estatus").value;
  /* comprobar campos vacios */
  if ( nombre == ""|| estatus == "") {
    Swal.fire({
        icon: 'error',
        title: 'Campos vacíos',
        text: 'Todos los campos son obligatorios',
        confirmButtonColor: '#3085d6',
    });
    return;
}
        $.ajax({
            url: "index.php?page=registrarDepartamentos",
            type: 'post',
            dataType: 'json',
            data: {
             
                nombre: nombre,
             
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formRegistrarDepartamento").reset();

                    $('#modalAgregarDepartamentos').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaDepartamentos').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }
}
$("#formRegistrarDepartamento").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

   
    let nombre                      = document.getElementById('nombre').value;
    let estatus                     = document.getElementById('estatus').value;

    /* comprobar campos vacios */
    if ( nombre == "" || estatus == "") {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }


    $.ajax({
        url: 'index.php?page=registrarDepartamento',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                $('#tablaDepartamentos').DataTable().ajax.reload();

                document.getElementById("formRegistrarDepartamento").reset();
                //$("#radiosfoto").click();

                $('#modalAgregarDepartamentos').modal('hide');


            } else {
                Swal.fire({
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });

});

/* -------------- Ver departamento ------------------ */

function verDepartamento(id) {

    let id_departamento = id;

    $.ajax({
        url: "index.php?page=verDepartamentos",
        type: 'post',
        dataType: 'json',
        data: {
            id_departamento: id_departamento
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("nombre_departamento").innerHTML = "Nombre: " + response.data.nombre;
                document.getElementById("fecha_departamento").innerHTML = "Fecha: " + response.data.fecha;

                if (response.data.estatus == 1) {
                    document.getElementById("estatus_departamento").innerHTML = "Estado: <button class='btn btn-success'>Activo</button>";
                } else {
                    document.getElementById("estatus_departamento").innerHTML = "Estado: <button class='btn btn-danger'>inactivo</button>";
                }

                $("#modalVisualizarDepartamento").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });
}



function listarActualizacionDepartamento(id) {

    let id_departamento = id;

    let id_departamento_update = document.getElementById("id_departamento_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let estatus = document.getElementById("estatus_update").value;
    

    let listar = "listar";

    $.ajax({
        url: "index.php?page=verDepartamentos",
        type: 'post',
        dataType: 'json',
        data: {
            id_departamento: id_departamento
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("id_departamento_update").value = response.data.id;
                document.getElementById("nombre_update").value = response.data.nombre;
                document.getElementById("estatus_update").value = response.data.estatus;
                
                

                $("#modalActualizarDepartamento").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });


}

var modificar_departamentos;
if (modificar_departamentos = document.getElementById("modificar_departamentos")) {
    modificar_departamentos.addEventListener("click", modificarDepartamentos, false);
    function modificarDepartamentos() {
        

        let id_departamento = document.getElementById("id_departamento_update").value;
        let nombre = document.getElementById("nombre_update").value;
        let estatus = document.getElementById("estatus_update").value;
        if ( nombre == "" || estatus == "" ) {
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                text: 'Todos los campos son obligatorios',
                confirmButtonColor: '#3085d6',
            });
            return;
        }
        $.ajax({
            url: "index.php?page=modificarDepartamentos",
            type: 'post',
            dataType: 'json',
            data: {
                id_departamento: id_departamento,
                nombre: nombre,
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formActualizarDepartamento").reset();

                    $('#modalActualizarDepartamento').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaDepartamentos').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }
}
$("#formActualizarDepartamento").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

    let id_departamento_update = document.getElementById("id_departamento_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let estatus = document.getElementById("estatus_update").value;
    

    /* comprobar campos vacios */
    if ( nombre == "" || estatus == "" ) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }
    $.ajax({
        url: 'index.php?page=modificarDepartamentos',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                console.log(respuesta.data); 
                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                document.getElementById("formActualizarDepartamento").reset();

                $('#formActualizarDepartamento').modal('hide');

            
                $('#tablaDepartamentos').DataTable().ajax.reload();


            } else {
                Swal.fire({
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });
});




/* -------------- Activar e Inactivar Departamento ------------------ */
function inactivarDepartamento(id) {
    var id_departamento = id;

    Swal.fire({
        title: '¿Está seguro de moficar el estado del el departamento?',
        //text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "index.php?page=inactivarDepartamento",
                type: 'post',
                dataType: 'json',
                data: {
                    id_departamento: id_departamento
                }
            })
                .done(function (response) {
                    if (response.data.success == true) {
                        $('#tablaDepartamentos').DataTable().ajax.reload();
                    }
                    else {

                        Swal.fire({
                            icon: 'error',
                            title: response.data.message,
                            confirmButtonColor: '#0d6efd',
                            text: response.data.info
                        });
                    }
                })
                .fail(function () {
                    console.log("error");
                });
        }
    })
}



/* -------------- Modulo visitante------------------ */

/*----------------- Listar Visitantes -------------*/
$(document).ready(function () {

    $('#tablaVisitante').DataTable({
        "order": [[0, 'DESC']],
        "procesing": true,
        "serverSide": true,
        "ajax": 'index.php?page=listarVisitantes',
        "pageLength": 5,
        "createdRow": function (row, data, dataIndex) {
            if (data[11] == 0) {

                $(row).addClass('table-danger');
            }
            else {
                //$(row).addClass('table-success');
            }
        },
        "columnDefs": [
            {
                "orderable": true,
                "targets": 10,
                render: function (data, type, row, meta) {

                    if (row[11] == 1) {
                        let botones = `
                    <button type="button" class="btn btn-primary btn-sm" onclick="verVisitantes(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
    
                   <button  type="button" class="btn btn-warning btn-sm btn_update"  onclick="listarActualizacionVisitante(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
    
                   <button title="Dar salida al visitante" type="button" class="btn btn-danger btn-sm" onclick="inactivarVisitante(`+ row[0] + `)"><i class="fas fa-door-closed"></i></button>  `;
                        return botones;
                    } else {
                        let botones = `
                <button type="button" class="btn btn-primary btn-sm" onclick="verVisitantes(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm btn_update"  onclick="listarActualizacionVisitante(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;

                `;
                        return botones;
                    }


                }
            }
        ],
        dom: 'Bfrtip',
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});
/* -------------- Agregar Visitantes ------------------ */
$("#formRegistrarVisitante").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

    let cedula = document.getElementById("cedula").value;
    let nombre = document.getElementById("nombre").value;
    let empresa = document.getElementById("empresa").value;
    let telefono = document.getElementById("telefono").value;
    let codigo_carnet	 = document.getElementById("codigo_carnet").value;
    let autorizador = document.getElementById("autorizador").value;
    let piso = document.getElementById("piso").value;
    let asunto = document.getElementById("asunto").value;
    let apellido = document.getElementById("apellido").value;
    let foto = document.getElementById("subirfoto").value;
    let estatus = document.getElementById("estatus").value;
    let departamento = document.getElementById("departamento").value;
    let radio = $("input[name='radio_select']:checked").val();

    /* comprobar campos vacios */
    if (cedula == "" || nombre == "" || empresa == "" || autorizador == "" || piso == "" || asunto == "" || apellido == "" || estatus == "" || departamento == "" || codigo_carnet== "" || telefono== "") {
        Swal.fire({
            icon: 'error',
            title: 'Campos vacíos',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    if (radio == 0) {

        cxt.drawImage(video, 0, 0, 300, 150);
        var data = canvas.toDataURL("image/jpeg");
        var info = data.split(",", 2);
        $.ajax({
            type: "POST",
            url: "index.php?page=registrarVisitanteConFoto",
            data: {
                foto: info[1],
                cedula: cedula,
                nombre: nombre,
                empresa: empresa,
                telefono: telefono,
                codigo_carnet:codigo_carnet,
                autorizador: autorizador,
                piso: piso,
                asunto: asunto,
                apellido: apellido,
                departamento: departamento,
                estatus: estatus

            },
            dataType: 'json',
            beforeSend: function () {
                //btnSaveLoad();
            },
            success: function (response) {
                //btnSave();
                if (response.data.success == true) {

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    document.getElementById('formRegistrarVisitante').setAttribute('style', 'display:none;');


                    $('#tablaVisitante').DataTable().ajax.reload();

                    document.getElementById("formRegistrarVisitante").reset();
                    $('#modalAgregarVisitante').modal('hide');
                    //$("#radiosfoto").click();
                } else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            }
        });

    } else if (radio == 1) {

        $.ajax({
            url: 'index.php?page=registrarVisitante',
            type: 'POST',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                //btnSaveLoad();
            },
            success: function (response) {

                var respuesta = JSON.parse(response);

                if (respuesta.data.success == true) {

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: respuesta.data.message,
                        text: respuesta.data.info
                    });

                    $('#tablaVisitante').DataTable().ajax.reload();

                    document.getElementById('formRegistrarVisitante').setAttribute('style', 'display:none;');


                    document.getElementById("formRegistrarVisitante").reset();
                    //$("#radiosfoto").click();

                    $('#modalAgregarVisitante').modal('hide');


                } else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: respuesta.data.message,
                        text: respuesta.data.info
                    });
                }
            }
        });

    }

});
/* -------------- Ver Visitantes------------------ */
function verVisitantes(id) {

    let id_visitante = id;

    $.ajax({
        url: "index.php?page=verVisitante",
        type: 'post',
        dataType: 'json',
        data: {
            id_visitante: id_visitante
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                
                document.getElementById("foto_visitante").innerHTML = "Foto: " + response.data.foto;                
                document.getElementById("consultarVisitanteCedula").innerHTML = "Cedula: " + response.data.cedula;
                document.getElementById("nombre_visitante").innerHTML = "Nombre: " + response.data.nombre;
                document.getElementById("apellido_visitante").innerHTML = "Apellido: " + response.data.apellido;
                document.getElementById("empresa_visitante").innerHTML = "Empresa: " + response.data.empresa;
                document.getElementById("telefono_visitante").innerHTML = "Telefono: " + response.data.telefono;	
                document.getElementById("codigo_carnet_visitante").innerHTML = "Codigo del carnet: " + response.data.codigo_carnet;
                document.getElementById("autorizador_visitante").innerHTML = "Autorizador: " + response.data.autorizador;
                document.getElementById("departamento_visitante").innerHTML = "Departamentos: " + response.data.departamento;
                document.getElementById("asunto_visitante").innerHTML = "Asunto: " + response.data.asunto;
                document.getElementById("piso_visitante").innerHTML = "Piso: " + response.data.piso;
                document.getElementById("fecha_visitante").innerHTML = "Fecha: " + response.data.fecha;
                

                let ruta_img = "foto/" + response.data.foto;

                document.getElementById("foto_visitante").setAttribute('src', ruta_img);

                if (response.data.estatus == 1) {
                    document.getElementById("estatus_visitante").innerHTML = "Estado: <button class='btn btn-success'>Activo</button>";
                } else {
                    document.getElementById("estatus_visitante").innerHTML = "Estado: <button class='btn btn-danger'>inactivo</button>";
                }

                $("#modalVisualizarVisitante").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });
}


/*Listar datos para actualizacion de Visitantes*/
function listarActualizacionVisitante(id) {

    let id_visitante = id;
    let id_visitante_update = document.getElementById("id_visitante_update").value;
    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let empresa = document.getElementById("empresa_update").value;
    let telefono = document.getElementById("telefono_update").value;
    let codigo_carnet_update = document.getElementById("codigo_carnet_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let autorizador = document.getElementById("autorizador_update").value;
    let asunto = document.getElementById("asunto_update").value;
    let piso = document.getElementById("piso_update").value;
    let estatus = document.getElementById("estatus_update").value;


    let listar = "listar";

    $.ajax({
        url: "index.php?page=verVisitante",
        type: 'post',
        dataType: 'json',
        data: {
            id_visitante: id_visitante
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                console.log(response.data);
                document.getElementById("id_visitante_update").value = response.data.id;
                document.getElementById("cedula_update").value = response.data.cedula;
                document.getElementById("nombre_update").value = response.data.nombre;
                document.getElementById("empresa_update").value = response.data.empresa;
                document.getElementById("telefono_update").value = response.data.telefono;
                document.getElementById("codigo_carnet_update").value = response.data.codigo_carnet;
                document.getElementById("apellido_update").value = response.data.apellido;
                document.getElementById("autorizador_update").value = response.data.autorizador;
                document.getElementById("asunto_update").value = response.data.asunto;
                document.getElementById("piso_update").value = response.data.piso;
                document.getElementById("departamento_update").value = response.data.id_departamento;
                document.getElementById("estatus_update").value = response.data.estatus;

                let ruta_img = "foto/" + response.data.foto;

                document.getElementById("foto_view_update").setAttribute('src', ruta_img);


                $("#modalActualizarVisitante").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });


}
/* -------------- Modificar Visitantes ------------------ */
$("#formModificarVisitante").unbind('submit').bind('submit', function (e) {

    e.preventDefault();


    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let empresa = document.getElementById("empresa_update").value;
    let telefono = document.getElementById("telefono_update").value;
    let codigo_carnet = document.getElementById("codigo_carnet_update").value;
    let autorizador = document.getElementById("autorizador_update").value;
    let piso = document.getElementById("piso_update").value;
    let asunto = document.getElementById("asunto_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let foto = document.getElementById("subirfotoUpdate").value;
    let estatus = document.getElementById("estatus_update").value;
    let departamento = document.getElementById("departamento_update").value;
    let id_visitante_update = document.getElementById("id_visitante_update").value;
    let radio = $("input[name='radio_select_update']:checked").val();

    /* comprobar campos vacios */
    if (cedula == "" || nombre == "" || empresa == "" || autorizador == "" || piso == "" || asunto == "" || apellido == "" || estatus == "" || departamento == ""|| telefono == ""|| codigo_carnet_update == "") {
        Swal.fire({
            icon: 'error',
            title: 'Campos vacíos',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    if (radio == 0) {

        cxt.drawImage(video, 0, 0, 300, 150);
        var data = canvas.toDataURL("image/jpeg");
        var info = data.split(",", 2);
        $.ajax({
            type: "POST",
            url: "index.php?page=modificarVisitanteConFoto",
            data: {
                foto: info[1],
                cedula: cedula,
                nombre: nombre,
                empresa: empresa,
                telefono: telefono,
                codigo_carnet:codigo_carnet,
                autorizador: autorizador,
                piso: piso,
                asunto: asunto,
                apellido: apellido,
                departamento: departamento,
                id_visitante_update: id_visitante_update,
                estatus: estatus

            },
            dataType: 'json',
            beforeSend: function () {
                //btnSaveLoad();
            },
            success: function (response) {
                //btnSave();
                if (response.data.success == true) {

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaVisitante').DataTable().ajax.reload();

                    document.getElementById("formModificarVisitante").reset();
                    $('#modalActualizarVisitante').modal('hide');
                    document.getElementById("foto_view_update").setAttribute('src', response.data.route_photo);

                    document.getElementById("video_update").setAttribute('style', 'display:none; width:100%;');
                } else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            }
        });

    } else if (radio == 1) {

        $.ajax({
            url: 'index.php?page=modificarVisitante',
            type: 'POST',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                //btnSaveLoad();
            },
            success: function (response) {

                var respuesta = JSON.parse(response);

                if (respuesta.data.success == true) {

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: respuesta.data.message,
                        text: respuesta.data.info
                    });

                    $('#tablaVisitante').DataTable().ajax.reload();

                    document.getElementById("formModificarVisitante").reset();
                    $('#modalActualizarVisitante').modal('hide');
                    document.getElementById("foto_view_update").setAttribute('src', response.data.route_photo);

                    document.getElementById("video_update").setAttribute('style', 'display:none; width:100%;');

                } else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: respuesta.data.message,
                        text: respuesta.data.info
                    });
                }
            }
        });

    }

});
/* -------------- Activar e Inactivar Visitantes ------------------ */
function inactivarVisitante(id) {
    var id_visitante = id;

    Swal.fire({
        title: '¿Desea darle salida al visitante?',
        //  text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "index.php?page=inactivarVisitante",
                type: 'post',
                dataType: 'json',
                data: {
                    id_visitante: id_visitante
                }
            })
                .done(function (response) {
                    if (response.data.success == true) {

                        Swal.fire({
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            title: response.data.message,
                            text: response.data.info
                        });

                        $('#tablaVisitante').DataTable().ajax.reload();
                    }
                    else {

                        Swal.fire({
                            icon: 'error',
                            title: response.data.message,
                            confirmButtonColor: '#0d6efd',
                            text: response.data.info
                        });
                    }
                })
                .fail(function () {
                    console.log("error");
                });
        }
    })
}

/* -------------- Consultar visitante por cédula ------------------ */
var buscar_cedula_visitante;
if (buscar_cedula_visitante = document.getElementById("buscar_cedula_visitante")) {

    buscar_cedula_visitante.addEventListener("click", consultarVisitanteCedula, false);

    function consultarVisitanteCedula() {

        let cedula_visitante = document.getElementById("cedula_visitante").value;

        $.ajax({
            url: "index.php?page=consultarVisitanteCedula",
            type: 'post',
            dataType: 'json',
            data: {
                cedula_visitante: cedula_visitante
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById('formRegistrarVisitante').removeAttribute('style');

                    document.getElementById("cedula").value = response.data.cedula;
                    document.getElementById("nombre").value = response.data.nombre;
                    document.getElementById("apellido").value = response.data.apellido;

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });


                }
                else if(response.data.error == "validacion")
                {
                    Swal.fire({
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
                else {

                    document.getElementById('formRegistrarVisitante').removeAttribute('style');

                    document.getElementById("cedula").value = "";
                    document.getElementById("nombre").value = "";
                    document.getElementById("apellido").value = "";

                    Swal.fire({
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }
}



/* -------------- Modulo Personal no deseado------------------ */

/*----------------- Listar Personal -------------*/
$(document).ready(function () {

    $('#tablaPersonal').DataTable({
        "order": [[0, 'DESC']],
        "procesing": true,
        "serverSide": true,
        "ajax": 'index.php?page=listarPersonal',
        "pageLength": 5,
        "createdRow": function (row, data, dataIndex) {
            if (data[6] == 0) {

                $(row).addClass('table-danger');
            }
            else {
                //$(row).addClass('table-success');
            }
        },
        "columnDefs": [
            {
                "orderable": true,
                "targets": 5,
                render: function (data, type, row, meta) {

                    if (row[6] == 1) {
                        let botones = `
                    <button type="button" class="btn btn-primary btn-sm" onclick="verPersonal(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionPersonal(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
    
                   <button type="button" class="btn btn-danger btn-sm" onclick="inactivarPersonal(`+ row[0] + `)"><i class="fas fa-trash"></i></button>  `;
                        return botones;
                    } else {
                        let botones = `
                <button type="button" class="btn btn-primary btn-sm" onclick="verPersonal(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;

               <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionPersonal(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;

               <button type="button" class="btn btn-success btn-sm" onclick="inactivarPersonal(`+ row[0] + `)"><i class="fas fa-fas fa-retweet"></i></button>  `;
                        return botones;
                    }


                }
            }
        ],
        dom: 'Bfrtip',
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});


/* -------------- Agregar Personal ------------------ */
var agregar_personal;
if (agregar_personal = document.getElementById("agregar_personal")) {

    agregar_personal.addEventListener("click", agregarPersonal, false);


    function agregarPersonal() {

        let cedula = document.getElementById("cedula").value;
        let nombre = document.getElementById("nombre").value;
        let apellido = document.getElementById("apellido").value;
        let estatus = document.getElementById("estatus").value;
  /* comprobar campos vacios */
  if (cedula == "" || nombre == "" || apellido == ""   || estatus == "") {
    Swal.fire({
        icon: 'error',
        title: 'Campos vacíos',
        text: 'Todos los campos son obligatorios',
        confirmButtonColor: '#3085d6',
    });
    return;
}


        $.ajax({
            url: "index.php?page=registrarPersonal",
            type: 'post',
            dataType: 'json',
            data: {
                cedula: cedula,
                nombre: nombre,
                apellido: apellido,
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formRegistrarPersonal").reset();

                    $('#modalAgregarPersonal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaPersonal').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }
}

/* -------------- Ver Personal------------------ */
function verPersonal(id) {

    let id_personal = id;

    $.ajax({
        url: "index.php?page=verPersonal",
        type: 'post',
        dataType: 'json',
        data: {
            id_personal: id_personal
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("cedula_personal").innerHTML = "Cedula: " + response.data.cedula;
                document.getElementById("nombre_personal").innerHTML = "Nombre: " + response.data.nombre;
                document.getElementById("apellido_personal").innerHTML = "Apellido: " + response.data.apellido;
                document.getElementById("fecha_personal").innerHTML = "Fecha: " + response.data.fecha;
                if (response.data.estatus == 1) {
                    document.getElementById("estatus_personal").innerHTML = "Estado: <button class='btn btn-success'>Activo</button>";
                } else {
                    document.getElementById("estatus_personal").innerHTML = "Estado: <button class='btn btn-danger'>inactivo</button>";
                }

                $("#modalVisualizarPersonal").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });
}
/*Listar datos para actualizacion de Personal*/
function listarActualizacionPersonal(id) {

    let id_personal = id;

    let id_personal_update = document.getElementById("id_personal_update").value;
    let cedula = document.getElementById("cedula_update").value;
    let nombre = document.getElementById("nombre_update").value;
    let apellido = document.getElementById("apellido_update").value;
    let estatus = document.getElementById("estatus_update").value;


    let listar = "listar";

    $.ajax({
        url: "index.php?page=verPersonal",
        type: 'post',
        dataType: 'json',
        data: {
            id_personal: id_personal
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                document.getElementById("id_personal_update").value = response.data.id;
                document.getElementById("cedula_update").value = response.data.cedula;
                document.getElementById("nombre_update").value = response.data.nombre;
                document.getElementById("apellido_update").value = response.data.apellido;
                document.getElementById("estatus_update").value = response.data.estatus;


                $("#modalActualizarPersonal").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });


}

/* -------------- Modificar Personal ------------------ */
var modificar_personal;
if (modificar_personal = document.getElementById("modificar_personal")) {

    modificar_personal.addEventListener("click", modificarPersonal, false);

    function modificarPersonal() {

        let id_personal = document.getElementById("id_personal_update").value;
        let cedula = document.getElementById("cedula_update").value;
        let nombre = document.getElementById("nombre_update").value;
        let apellido = document.getElementById("apellido_update").value;
        let estatus = document.getElementById("estatus_update").value;
 /* comprobar campos vacios */
  if (cedula == "" || nombre == "" || apellido == ""   || estatus == "") {
    Swal.fire({
        icon: 'error',
        title: 'Campos vacíos',
        text: 'Todos los campos son obligatorios',
        confirmButtonColor: '#3085d6',
    });
    return;
}
        $.ajax({
            url: "index.php?page=modificarPersonal",
            type: 'post',
            dataType: 'json',
            data: {
                id_personal: id_personal,
                cedula: cedula,
                nombre: nombre,
                apellido: apellido,
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formActualizarPersonal").reset();

                    $('#modalActualizarPersonal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaPersonal').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }

}

/* -------------- Activar e Inactivar Personal ------------------ */
function inactivarPersonal(id) {
    var id_personal = id;

    Swal.fire({
        title: '¿Está seguro de moficar el estado del personal?',
        //  text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "index.php?page=inactivarPersonal",
                type: 'post',
                dataType: 'json',
                data: {
                    id_personal: id_personal
                }
            })
                .done(function (response) {
                    if (response.data.success == true) {
                        $('#tablaPersonal').DataTable().ajax.reload();
                    }
                    else {

                        Swal.fire({
                            icon: 'error',
                            title: response.data.message,
                            confirmButtonColor: '#0d6efd',
                            text: response.data.info
                        });
                    }
                })
                .fail(function () {
                    console.log("error");
                });
        }
    })
}






/*-----------------Listar Roles-------------*/
$(document).ready(function () {

    $('#tablaRoles').DataTable({
        "order": [[0, 'DESC']],
        "procesing": true,
        "serverSide": true,
        "ajax": 'index.php?page=listarRoles',
        "pageLength": 4,
        "createdRow": function (row, data, dataIndex) {
            if (data[4] == 0) {

                $(row).addClass('table-danger');
            }
            else {
                //$(row).addClass('table-success');
            }
        },
        "columnDefs": [
            {
                "orderable": false,
                "targets": 3,
                render: function (data, type, row, meta) {

                    if (row[4] == 1) {
                        let botones = `
                      <button type="button" class="btn btn-primary btn-sm" onclick="verRoles(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionRoles(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
     
                     <button type="button" class="btn btn-danger btn-sm" onclick="inactivarRoles(`+ row[0] + `)"><i class="fas fa-trash"></i></button>  `;
                        return botones;
                    } else {
                        let botones = `
                  <button type="button" class="btn btn-primary btn-sm" onclick="VerRoles(`+ row[0] + `)"><i class="fas fa-eye"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-warning btn-sm"  onclick="listarActualizacionRoles(`+ row[0] + `)"><i class="fas fa-edit"></i></button>&nbsp;
 
                 <button type="button" class="btn btn-success btn-sm" onclick="inactivarRoles(`+ row[0] + `)"><i class="fas fa-fas fa-retweet"></i></button>  `;
                        return botones;
                    }


                }
            }
        ],
        dom: 'Bfrtip',
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});

/* -------------- Agregar Roles------------------ */
// var agregar_roles;
var agregar_roles;
if (agregar_roles = document.getElementById("agregar_roles")) {

    agregar_roles.addEventListener("click", agregarRoles, false);


    function agregarRoles() {
        
        
        let rol = document.getElementById("rol").value;
        
        let estatus = document.getElementById("estatus").value;
  /* comprobar campos vacios */
  if ( rol == ""|| estatus == "") {
    Swal.fire({
        icon: 'error',
        title: 'Campos vacíos',
        text: 'Todos los campos son obligatorios',
        confirmButtonColor: '#3085d6',
    });
    return;
}


        $.ajax({
            url: "index.php?page=registrarRoles",
            type: 'post',
            dataType: 'json',
            data: {
             
                rol: rol,
             
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formRegistrarRoles").reset();

                    $('#modalAgregarRoles').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaRoles').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }
}
$("#formRegistrarRoles").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

   
    let rol                      = document.getElementById('rol').value;
    let estatus                     = document.getElementById('estatus').value;

    /* comprobar campos vacios */
    if ( rol == "" || estatus == "") {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }


    $.ajax({
        url: 'index.php?page=registrarRoles',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                $('#tablaRoles').DataTable().ajax.reload();

                document.getElementById("formRegistrarRoles").reset();
                //$("#radiosfoto").click();

                $('#modalAgregarRoles').modal('hide');


            } else {
                Swal.fire({
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });

});

/* -------------- Ver roles ------------------ */
function verRoles(id) {

    let id_roles = id;

    $.ajax({
        url: "index.php?page=verRoles",
        type: 'post',
        dataType: 'json',
        data: {
            id_roles: id_roles
        }
    })
        .done(function (response) {
            if (response.data.success == true) {
                
                document.getElementById("rol_roles").innerHTML = "Nombre: " + response.data.rol;
                
                

                document.getElementById("fecha_roles").innerHTML = "Fecha: " + response.data.fecha;


                if (response.data.estatus == 1) {
                    document.getElementById("estatus_roles").innerHTML = "Estado: <button class='btn btn-success'>Activo</button>";
                } else {
                    document.getElementById("estatus_roles").innerHTML = "Estado: <button class='btn btn-danger'>inactivo</button>";
                }

                $("#modalVisualizarRoles").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });
}


/*Listar datos para actualizacion de Roles*/

/* -------------- Modificar Roles ------------------ */

var modificar_roles;
if (modificar_roles = document.getElementById("modificar_roles")) {

    modificar_roles.addEventListener("click", modificarRoles, false);

    function modificarRoles() {

        let id_roles = document.getElementById("id_roles_update").value;
        
        let rol = document.getElementById("rol_update").value;
        
        let estatus = document.getElementById("estatus_update").value;
/* comprobar campos vacios */
if ( rol == "" ||  estatus == "" ) {
    Swal.fire({
        icon: 'error',
        title: 'Campos vacíos',
        text: 'Todos los campos son obligatorios',
        confirmButtonColor: '#3085d6',
    });
    return;
}
        $.ajax({
            url: "index.php?page=modificarRoles",
            type: 'post',
            dataType: 'json',
            data: {
                id_roles: id_roles,
                
                rol:  rol,
                
                estatus: estatus
            }
        })
            .done(function (response) {
                if (response.data.success == true) {

                    document.getElementById("formActualizarRoles").reset();

                    $('#modalActualizarRoles').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });

                    $('#tablaRoles').DataTable().ajax.reload();

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        title: response.data.message,
                        text: response.data.info
                    });
                }
            })
            .fail(function () {
                console.log("error");
            });
    }

}
$("#formActualizarRoles").unbind('submit').bind('submit', function (e) {

    e.preventDefault();

    let id_roles_update = document.getElementById("id_roles_update").value;
    
    let rol = document.getElementById("rol_update").value;
    
    let estatus = document.getElementById("estatus_update").value;
    

    /* comprobar campos vacios */
    if ( rol == "" || estatus == "" ) {
        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Todos los campos son obligatorios',
            confirmButtonColor: '#3085d6',
        });
        return;
    }
    $.ajax({
        url: 'index.php?page=modificarRoles',
        type: 'POST',
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            //btnSaveLoad();
        },
        success: function (response) {

            var respuesta = JSON.parse(response);

            if (respuesta.data.success == true) {

                console.log(respuesta.data); 
                Swal.fire({
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });

                document.getElementById("formActualizarRoles").reset();

                $('#formActualizarRoles').modal('hide');

            
                $('#tablaRoles').DataTable().ajax.reload();


            } else {
                Swal.fire({
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    title: respuesta.data.message,
                    text: respuesta.data.info
                });
            }
        }
    });
});
/* --------------listarActualizacionRoles ------------------ */
function listarActualizacionRoles(id) {

    let id_roles = id;
    let id_roles_update = document.getElementById("id_roles_update").value;
    let rol = document.getElementById("rol_update").value;
    let estatus = document.getElementById("estatus_update").value;


    let listar = "listar";

    $.ajax({
        url: "index.php?page=verRoles",
        type: 'post',
        dataType: 'json',
        data: {
            id_roles: id_roles
        }
    })
    .done(function (response) {
        if (response.data.success == true) {
            document.getElementById("id_roles_update").value = response.data.id;
            document.getElementById("rol_update").value = response.data.rol;
            document.getElementById("estatus_update").value = response.data.estatus;


                $("#modalActualizarRoles").modal("show");
            }
            else {

            }
        })
        .fail(function () {
            console.log("error");
        });


}


/* -------------- Activar e Inactivar Roles ------------------ */
function inactivarRoles(id) {
    var id_roles = id;

    Swal.fire({
        title: '¿Está seguro de moficar el estado del rol?',
        //  text: "El paciente sera dado de alta y el registro quedara guardado en la traza.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "index.php?page=inactivarRoles",
                type: 'post',
                dataType: 'json',
                data: {
                    id_roles: id_roles
                }
            })
                .done(function (response) {
                    if (response.data.success == true) {
                        $('#tablaRoles').DataTable().ajax.reload();
                    }
                    else {

                        Swal.fire({
                            icon: 'error',
                            title: response.data.message,
                            confirmButtonColor: '#0d6efd',
                            text: response.data.info
                        });
                    }
                })
                .fail(function () {
                    console.log("error");
                });
        }
    })
}
















