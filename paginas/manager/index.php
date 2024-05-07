<?php
include "../../templates/headermanager.php";
?>
        <div class="bg-light rounded-3">
            <div class="container-fluid py-3">
                <div class="card w-60">
                    <div class="card-header"><i class="fas fa-table me-1"></i>
                        <strong>Inventario de la Escuela Superior de Tepeji del Río de Ocampo</strong>
                    </div>
                    <div class="card-body">
                    <br>
                    <div class="table-responsive">
                        <table id="tb_index" class="table table-striped responsive" style="width:100%">
                            <thead class="table">
                                <tr>
                                    <th>No. Inventario</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Área</th>
                                    <th>Oficina</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No. Inventario</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Área</th>
                                    <th>Oficina</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="application/javascript">
    $(document).ready(function() {
        $('#tb_index').DataTable({
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
            ajax: '../get_data.php',
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 20]
        })
    });
</script>

<?php
include "../../templates/footernoindex.php";
?>