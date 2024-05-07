<?php

include '../../bd/conexion.php';

// Obtener los datos del formulario
$area = $_POST['area'];
$responsable = $_POST['responsable'];

try {
    // Preparar la consulta SQL
    $sql = "INSERT INTO cg_area(desc_area) VALUES(TRIM(UPPER(:area)))";
    $stmt = $conexion->prepare($sql);

    // Bind de parámetros
    $stmt->bindParam(':area', $area);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    header("Location: areas.php");
    exit();

} catch (PDOException $e) {
    // Manejar excepciones relacionadas con la consulta
    echo "Error al guardar el registro: " . $e->getMessage();
} finally {
    // Cerrar la conexión PDO
    $conexion = null;
}

?>