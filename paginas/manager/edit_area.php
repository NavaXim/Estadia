<?php

require_once('../../bd/conexion.php');

// Obtener los datos del formulario
$id_area = $_POST['id_area'];
$desc_area = $_POST['desc_area'];

try {
    // Preparar la consulta SQL
    $stm = $conexion->prepare("UPDATE cg_area SET desc_area = TRIM(UPPER(:desc_area)), id_status ='1' WHERE id_area = :id_area");

    // Bind de parámetros
    $stm->bindParam(":id_area",$id_area);
    $stm->bindParam(":desc_area",$desc_area);

    // Ejecutar la consulta
    $stm->execute();
    
    header("location:areas.php");    
    exit();
    
} catch (PDOException $e) {
        // Manejar excepciones relacionadas con la consulta
        echo "Error al actualizar el registro: " . $e->getMessage();
    } finally{
        // Cerrar la conexión PDO
        $conexion = null;
    }

?>