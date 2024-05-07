<?php
require_once('../../bd/conexion.php');

$stm = $conexion->prepare("SELECT id_area, desc_area, cg_status.desc_status FROM cg_area INNER JOIN cg_status ON cg_area.id_status = cg_status.id_status ORDER BY id_area");
$stm->execute();
$area =$stm->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id_area'])){
    try {
        $id_area = (isset($_GET['id_area'])?$_GET['id_area']:"");
        $stm = $conexion->prepare("UPDATE cg_area SET id_status ='2' WHERE id_area = :id_area");
        $stm->bindParam(":id_area",$id_area);
        $stm->execute();
    
        header("location:areas.php");
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
            <div class="card-header"><i class="fa fa-building"></i>
                <strong>Catalogo de Áreas</strong>
            </div>
            <div class="card-body">
                 <!-- Button trigger modal -->
                <button type="button" class="btnAdd" data-toggle="modal" data-target="#add_area">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                </button>
                <br><br>
                <div class="table-responsive">
                    <table id="tb_area" class="table table-striped responsive display" style="width:100%">
                        <thead class= "table abs-center">
                            <tr>
                                <th scope="col" align="center">Id</th>
                                <th scope="col">Área</th>
                                
                                <!--<th scope="col">Responsable</th>-->
                                
                                <th scope="col">Status</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($area as $area) { ?>
                                <tr class="">
                                    <td scope="row"><?php echo $area['id_area']; ?></td>
                                    <td><?php echo $area['desc_area']; ?></td>
                                    
                                    <!--<td><?php echo $area['resp_area']; ?></td>-->
                                    
                                    <td><?php echo $area['desc_status']; ?></td>
                                    <td>
                                        <button class="btnUpdate edit-modal"><i class="fa fa-cog"></i> </a></button>
                                        <?php
                                        if($area['desc_status'] == 'ACTIVO'){ ?>
                                            <a class="btnDelete" href="areas.php?id_area=<?php echo $area['id_area']; ?>"><i class="fa fa-eraser"></i> </a>
                                        <?php
                                        } else if($area['desc_status'] == 'INACTIVO'){ ?>
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

<!-- Ventana Modal para Agregar un Área-->
    <div class="modal fade" id="add_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalCenterTitle">Registro de Áreas</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_area.php" method="post">
                        <label for="area">Área: </label>
                        <input type="text" id="area" name="area" required>
                        <br><br>
                        
                        <!--<label for="responsable">Responsable: </label>
                        <input type="text" id="responsable" name="responsable" required>
                        <br><br>-->
                        
                        <center>
                            <a href="areas.php" class="btnCancel"><i class="fa fa-ban"></i></a>
                            <button type="submit" class="btnSave"><i class="fa fa-database"></i></button>
                        </center>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- Ventana Modal para Editar datos de un Área-->
    <div class="modal fade" id="edit_area" tabindex="-1" role="dialog" aria-labelledby="miVentanaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Modificación de Datos del Área</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_area.php" method="post">
                        <input type="hidden" class="form-control" id="id_area" name="id_area">
                        <label for="area"><strong>Área:</strong></label>
                        <input type="text" class="form-control" id="desc_area" name="desc_area">
                        <br>
                        
                        <!--<label for="responsable"><strong>Responsable:</strong></label>
                        <input type="text" class="form-control" id="resp_area" name="resp_area">
                        <br>-->
                        
                        <label for="status"><strong>Estado:</strong></label>
                        <input type="text" class="form-control" id="status_area" name="status_area" value="ACTIVO" disabled>
                        <br>
                        <center>
                            <a href="areas.php" class="btnCancel"><i class="fa fa-ban"></i></a>
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
        $('#tb_area').DataTable({
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
    $('#tb_area').DataTable();

    // Evento delegado para abrir la ventana modal y cargar los datos
    $('#tb_area').on('click', '.edit-modal', function() {
        var fila = $(this).closest('tr');
        var clave = $(this).closest('tr').find('td:eq(0)').text();
        var area = $(this).closest('tr').find('td:eq(1)').text();
        //var resp = $(this).closest('tr').find('td:eq(2)').text();
        // Agrega más variables según tus datos

        // Mostrar los datos en la ventana modal
        var id_area = document.getElementById('id_area');
        var desc_area = document.getElementById('desc_area');
        //var resp_area = document.getElementById('resp_area');
        // Agrega más líneas para mostrar más datos en la ventana modal

        // Abrir la ventana modal
        id_area.value = clave;
        desc_area.value = area;
        //resp_area.value = resp;
        $('#edit_area').modal('show');
    });
});
</script>


<?php
include "../../templates/footernoindex.php";
?>