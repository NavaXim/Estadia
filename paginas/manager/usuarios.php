<?php
require_once('../../bd/conexion.php');

$stm = $conexion->prepare("SELECT id_usuario, nombre, ap_paterno, ap_materno, nick, pwd, desc_tpousuario, desc_status FROM tbl_usuarios INNER JOIN cg_tpousuario ON tbl_usuarios.id_tpousuario =cg_tpousuario.id_tpousuario INNER JOIN cg_status ON tbl_usuarios.id_status = cg_status.id_status");
$stm->execute();
$usuario =$stm->fetchAll(PDO::FETCH_ASSOC);

$sql_tipo = $conexion->prepare("SELECT id_tpousuario, desc_tpousuario FROM cg_tpousuario");
$sql_status = $conexion->prepare("SELECT id_status,desc_status FROM cg_status");

// Ejecutar la consulta
$sql_tipo->execute();
$sql_status->execute();

// Obtener el resultado de la consulta
$resultado_tipo = $sql_tipo->fetchAll();
$resultado_status = $sql_status->fetchAll();

if(isset($_GET['id_usuario'])){
    try {
        $id_usuario = (isset($_GET['id_usuario'])?$_GET['id_usuario']:"");
        $stm = $conexion->prepare("UPDATE tbl_usuarios SET id_status ='2' WHERE id_usuario = :id_usuario");
        $stm->bindParam(":id_usuario",$id_usuario);
        $stm->execute();
    
        header("location:usuarios.php");
    } catch (PDOException $e) {
        // Manejar excepciones relacionadas con la consulta
        echo "Error al actualizar el registro: " . $e->getMessage();
    } finally{
        // Cerrar la conexión PDO
        $conexion = null;
    }
}
include "../../templates/headermanager.php";

?>

<div class="d-flex bg-light rounded-3 justify-content-center">
    <div class="container-fluid py-3">
        <!--<div class="card w-75">-->
        <div class="card">
            <div class="card-header"><i class="fa fa-users"></i>
                <!--<i class="fas fa-table me-1"></i>-->
                <strong>Registro de Usuarios</strong>
            </div>
            <div class="card-body">
                 <!-- Button trigger modal -->
                <button type="button" class="btnAdd" data-toggle="modal" data-target="#add_user">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                </button>
                <br><br>
                <div class="table-responsive">
                    <table id="tb_usuario" class="table table-striped responsive display" style="width:100%">
                        <thead class= "table abs-center">
                            <tr>
                                <th scope="col" align="center">Id</th>
                                <th scope="col">Nombre(s)</th>
                                <th scope="col">Apellido Paterno</th>
                                <th scope="col">Apellido Materno</th>
                                <th scope="col">User Name</th>
                                
                                <!--<th scope="col">Contraseña</th>-->
                                
                                <th scope="col">Tipo de Usuario</th>
                                <th scope="col">Status</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($usuario as $usuario) { ?>
                                <tr class="">
                                    <td scope="row"><?php echo $usuario['id_usuario']; ?></td>
                                    <td><?php echo $usuario['nombre']; ?></td>
                                    <td><?php echo $usuario['ap_paterno']; ?></td>
                                    <td><?php echo $usuario['ap_materno']; ?></td>
                                    <td><?php echo $usuario['nick']; ?></td>
                                    
                                    <!--<td><?php echo $usuario['pwd']; ?></td>-->
                                    
                                    <td><?php echo $usuario['desc_tpousuario']; ?></td>
                                    <td>
                                        
                                        <?php 
                                            if($usuario['desc_status'] == 'ACTIVO'){ ?>
                                                <!--<button class="btnUpdate edit-modal"><i class="fa fa fa-check"></i></button>-->
                                            <?php 
                                            } else { ?>
                                                <!--<button class="btnUpdate edit-modal"><i class="fa fa-times"></i></button>-->
                                            <?php
                                            }
                                            echo $usuario['desc_status']; 
                                        ?>

                                    </td>
                                    <td>
                                        <button class="btnUpdate edituser-modal"><i class="fa fa-id-card"></i></button>
                                        <button class="btnUpdate editkey-modal"><i class="fa fa-key"></i></button>
                                        <?php
                                        if($usuario['desc_status'] == 'ACTIVO'){ ?>
                                            <a class="btnDelete" href="usuarios.php?id_usuario=<?php echo $usuario['id_usuario']; ?>"><i class="fa fa-eraser"></i> </a>
                                        <?php
                                        } else if($usuario['desc_status'] == 'INACTIVO'){ ?>
                                            <button class="btnDelete disabled" ><i class="fa fa-eraser"></i> </a></button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ventana Modal para Agregar un Usuario-->
    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalCenterTitle">Registro de Usuarios</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_users.php" method="post">
                        <label for="nombre"><strong>Nombre(s): </strong></label>
                        <input type="text" id="nombre" name="nombre" size="30" required placeholder="Tu Nombre">
                        <br><br>
                        <label for="ap_paterno"><strong>Apellido Paterno: </strong></label>
                        <input type="text" id="ap_paterno" name="ap_paterno" size="25" required placeholder="Tu Apellido Paterno">
                        <br><br>
                        <label for="ap_materno"><strong>Apellido Materno: </strong></label>
                        <input type="text" id="ap_materno" name="ap_materno" size="25" required placeholder="Tu Apellido Materno">
                        <br><br>
                        <label for="nick"><strong>Usuario: </strong></label>
                        <input type="text" id="nick" name="nick" required size="15" placeholder="Tu Username">
                        <br><br>
                        <label for="pwd"><strong>Contraseña: </strong></label>
                        <input type="password" id="pwd" name="pwd" size="10" required placeholder="Tu Password">
                        <br><br>
                        <center>
                            <a href="usuarios.php" class="btnCancel"><i class="fa fa-ban"></i></a>
                            <button type="submit" class="btnSave"><i class="fa fa-database"></i></button>
                        </center>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- Ventana Modal para Editar datos de un Usuario-->   
    <div class="modal fade" id="edit_usuario" tabindex="-1" role="dialog" aria-labelledby="miVentanaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Actualizar Datos de Usuario</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_usuario.php" method="post">
                        <input type="hidden" class="form-control" id="edt_id" name="edt_id">
                        <label for="nombres"><strong>Nombre(s): </strong></label>
                        <input type="text" class="form-control" id="edt_nombre" name="edt_nombre">
                        <br>
                        <label for="paterno"><strong>Apellido Paterno: </strong></label>
                        <input type="text" class="form-control" id="edt_paterno" name="edt_paterno">
                        <br>
                        <label for="materno"><strong>Apellido Materno: </strong></label>
                        <input type="text" class="form-control" id="edt_materno" name="edt_materno">
                        <br>
                        <label for="user_name"><strong>Usuario: </strong></label>
                        <input type="text" class="form-control" id="edt_nick" name="edt_nick">
                        <br>
                        <label for="tpousuario"><strong>Tipo de Usuario: </strong></label>
                        <select name="tipo" id="tipo">
                        <?php
                           foreach ($resultado_tipo as $tipo) {
                                echo "<option value='" . $tipo['id_tpousuario'] . "'>" . $tipo['desc_tpousuario'] . "</option>";
                            }
                        ?>
                        </select>
                        <input type="text" id="tpousuario" readonly size="2" name="tpousuario">
                        <br>
                        <label for="texto"><strong>Status del Usuario: </strong></label>
                        <select name="status" id="status">
                        <?php
                            foreach ($resultado_status as $status) {
                                echo "<option value='" . $status['id_status'] . "'>" . $status['desc_status'] . "</option>";
                            }
                        ?>
                        </select>
                        <input type="text" id="statususuario" readonly size="2" name="statususuario">

                        <center>
                            <a href="usuarios.php" class="btnCancel"><i class="fa fa-ban"></i></a>
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

<!-- Ventana Modal para Editar Contraseña de un Usuario-->   
    <div class="modal fade" id="edit_usuariopwd" tabindex="-1" role="dialog" aria-labelledby="miVentanaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Actualizar Contraseña de Usuario</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_pwd.php" method="post">
                        <input type="hidden" class="form-control" id="edtpwd_id" name="edtpwd_id">
                        <label for="nick"><strong>Usuario: </strong></label>
                        <input type="text" id="edtpwd_nick" name="edtpwd_nick" required size="15">
                        <br><br>
                        <label for="pwd"><strong>Contraseña: </strong></label>
                        <input type="password" id="edtpwd_pwd" name="edtpwd_pwd" size="15" required placeholder="Nuevo Password">
                        <br><br>
                        <center>
                            <a href="usuarios.php" class="btnCancel"><i class="fa fa-ban"></i></a>
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

<script type="application/javascript">
    $(document).ready(function() {
        $('#tb_usuario').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró nada - lo siento",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            responsive: true,
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 20]
        })
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script>
    $(document).ready(function() {
    // Inicializar DataTable
    $('#tb_usuario').DataTable();

    // Evento delegado para abrir la ventana modal y cargar los datos
    $('#tb_usuario').on('click', '.edituser-modal', function() {
        var fila = $(this).closest('tr');
        var id_usuario = fila.find('td:eq(0)').text();
        var nombre = fila.find('td:eq(1)').text();
        var ap_paterno = fila.find('td:eq(2)').text();
        var ap_materno = fila.find('td:eq(3)').text();
        var nick = fila.find('td:eq(4)').text()
        
        // Mostrar los datos en la ventana modal
        $('#edt_id').val(id_usuario);
        $('#edt_nombre').val(nombre);
        $('#edt_paterno').val(ap_paterno);
        $('#edt_materno').val(ap_materno);
        $('#edt_nick').val(nick);
    
        // Abrir la ventana modal
       $('#edit_usuario').modal('show');
    });
});
</script>

<script>
    $(document).ready(function() {
    // Inicializar DataTable
    $('#tb_usuario').DataTable();

    // Evento delegado para abrir la ventana modal y cargar los datos
    $('#tb_usuario').on('click', '.editkey-modal', function() {
        var fila = $(this).closest('tr');
        var id_usuario = fila.find('td:eq(0)').text();
        var nick = fila.find('td:eq(4)').text();
        
        // Mostrar los datos en la ventana modal
        $('#edtpwd_id').val(id_usuario);
        $('#edtpwd_nick').val(nick);
    
        // Abrir la ventana modal
       $('#edit_usuariopwd').modal('show');
    });
});
</script>

<script>
    document.getElementById('tipo').addEventListener('change', function() {
        var select = document.getElementById('tipo');
        var selectedOption = select.options[select.selectedIndex];
        
        // Actualizar el valor de la caja de texto
        document.getElementById('tpousuario').value = selectedOption.value;
    });
    
    document.getElementById('status').addEventListener('change', function() {
        var select = document.getElementById('status');
        var selectedOption = select.options[select.selectedIndex];
        
        // Actualizar el valor de la caja de texto
        document.getElementById('statususuario').value = selectedOption.value;
    });
</script>


<?php
include "../../templates/footernoindex.php";
?>