<?php
// Obtener los datos del formulario
require_once('../bd/conexion.php');

// Consulta parametrizada con marcadores de posición
$sql_tipo = $conexion->prepare("SELECT id_tpousuario, desc_tpousuario FROM cg_tpousuario");
$sql_status = $conexion->prepare("SELECT id_status,desc_status FROM cg_status");

// Ejecutar la consulta
$sql_tipo->execute();
$sql_status->execute();

// Obtener el resultado de la consulta
$resultado_tipo = $sql_tipo->fetchAll();
$resultado_status = $sql_status->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja de Lista desde MySQL</title>
</head>
<body>
    <h2>Selecciona un elemento:</h2>
    <select name="tipo" id="tipo">
        <?php
        foreach ($resultado_tipo as $tipo) {
            echo "<option value='" . $tipo['id_tpousuario'] . "'>" . $tipo['desc_tpousuario'] . "</option>";
        }
        ?>
    </select>
    <label for="tpousuario"></label>
    <input type="text" id="tpousuario" readonly>
    <br>
    <select name="status" id="status">
        <?php
        foreach ($resultado_status as $status) {
            echo "<option value='" . $status['id_status'] . "'>" . $status['desc_status'] . "</option>";
        }
        ?>
    </select>
    <label for="texto"></label>
    <input type="text" id="texto" readonly>
    
</body>

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
        document.getElementById('texto').value = selectedOption.value;
    });
</script>
</html>
