<?php
    include "templates/header.php";
     // Iniciar la sesión
    session_start();
    // Limpiar la variable de la sesión si es necesario
    unset($_SESSION['nombre']);
?>

<main class="container">
    <br>
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Iniciar Sesión</h1>
            <br>
            <center>
                <label for="usuario"><strong>Usuario:</strong></label>
                <input type="text" id="user" name="user" size="15" required placeholder="Tu Username">
                <br>
                <label for="contrasena"><strong>Contraseña:</strong></label>
                <input type="password" id="pwd" name="pwd" size="10" required placeholder="Tu Password">
                <br>
                <div class="enviar">
                    <button class="btnLogin" onclick="realizarConsulta()"><strong>Iniciar Sesión</strong></button>
                </div>
                <br>
                <div class="register-link">
                    ¿No tienes una cuenta?
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#miVentanaModal">
                        Registrate
                    </button>
                </div>
            </center>
            
            <!-- Ventana Modal Registrar Usuario-->
            <div class="modal fade" id="miVentanaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="exampleModalCenterTitle">Registro de Usuarios</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="paginas/add_users.php" method="post">
                                <label for="nombre"><strong>Nombre(s): </strong></label>
                                <input type="text" id="nombre" name="nombre" size="30" required placeholder="Tu Nombre">
                                <br><br>
                                <label for="nombre"><strong>Apellido Paterno: </strong></label>
                                <input type="text" id="ap_paterno" name="ap_paterno" size="25" required placeholder="Tu Apellido Paterno">
                                <br><br>
                                <label for="nombre"><strong>Apellido Materno: </strong></label>
                                <input type="text" id="ap_materno" name="ap_materno" size="25" required placeholder="Tu Apellido Materno">
                                <br><br>
                                <label for="nombre"><strong>Usuario: </strong></label>
                                <input type="text" id="nick" name="nick" required size="15" placeholder="Tu Username">
                                <br><br>
                                <label for="nombre"><strong>Contraseña: </strong></label>
                                <input type="password" id="pwd" name="pwd" size="10" required placeholder="Tu Password">
                                <br><br>
                                <center>
                                    <a href="." class="btnCancel"><i class="fa fa-ban"></i></a>
                                    <button type="submit" class="btnSave"><i class="fa fa-database"></i></button>

                                </center>
                            </form>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Ventana Modal -->
        </div>
    </div>
</main>

<script>
    function realizarConsulta() {
        // Obtener los valores de los inputs
        var user = $('#user').val();
        var pwd = $('#pwd').val();

        // Datos a enviar en la solicitud AJAX
        var datos = {
            user: user,
            pwd: pwd
        };

        // Realizar la solicitud AJAX
        $.ajax({
            url: 'paginas/validate_user.php', // Archivo PHP que realiza la consulta
            type: 'POST', // Utilizar método POST
            data: datos, // Enviar datos
            dataType: 'json',
            success: function(response) {
               if (response.success) {
                    // La consulta fue exitosa
                    var tpouser = response.resultado['desc_tpousuario'];
                    // Hacer algo con los resultados
                    if(tpouser == "ADMINISTRADOR"){
                        window.location.href = 'paginas/manager/index.php';
                    } else if(tpouser == "EDITOR") {
                        window.location.href = 'paginas/publisher/index.php';
                    } else {
                        window.location.href = 'paginas/guest/index.php';
                    }
                } else {
                    // La consulta no fue exitosa, mostrar un mensaje de error con SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.mensaje,
                        confirmButtonText: 'Ok',
                        customClass:{
                            confirmButton: 'mi-clase-boton'
                        }
                    });
                    $('#user').val('');
                    $('#pwd').val('');
                }
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud AJAX
                console.error(xhr.responseText);
            }
        });
    }
</script>

<?php
    include "templates/footer.php";
?>