<?php

// Incluir el archivo de conexión
include '../../conexion.php';

try {
    // Realizar la consulta SQL
    $sql = $conexion->query("SELECT id_status, desc_status FROM cg_status");

    // Obtener los resultados y llenar el combobox
    while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . $fila['desc_status'] . "'>" . $fila['desc_status'] . "</option>";
    }

} catch (PDOException $e) {
    // Manejar excepciones relacionadas con la consulta
    echo "Error en la consulta: " . $e->getMessage();
} finally{
    // Cerrar la conexión si es necesario
    $conexion = null;
}

?>