<?php

require_once('../../bd/conexion.php');

// Obtener los datos del formulario
$id_usuario = $_POST['edt_id'];
$nombre = $_POST['edt_nombre'];
$ap_paterno = $_POST['edt_paterno'];
$ap_materno = $_POST['edt_materno'];
$nick = $_POST['edt_nick'];
$id_tpousuario = $_POST['tpousuario'];
$id_status = $_POST['status'];


echo "ID Usuario: " . $id_usuario . "<br>";
echo "Nombre: " . $nombre . "<br>";
echo "Apellido Paterno: " . $ap_paterno . "<br>";
echo "Apellido Materno: " . $ap_materno . "<br>";
echo "Usuario: " . $nick . "<br>";
echo "Tipo de Usuario: " . $id_tpousuario . "<br>";
echo "Status del Usuario: " . $id_status . "<br>";

try {
    // Preparar la consulta SQL
    $stm = $conexion->prepare("UPDATE tbl_usuarios SET nombre = TRIM(UPPER(:nombre)), ap_paterno = TRIM(UPPER(:ap_paterno)), ap_materno = TRIM(UPPER(:ap_materno)), nick = TRIM(:nick), id_tpousuario = :id_tpousuario, id_status = :id_status WHERE id_usuario = :id_usuario");

    // Bind de parámetros
    $stm->bindParam(":id_usuario",$id_usuario);
    $stm->bindParam(":nombre",$nombre);
    $stm->bindParam(":ap_paterno",$ap_paterno);
    $stm->bindParam(":ap_paterno",$ap_paterno);
    $stm->bindParam(":ap_materno",$ap_materno);
    $stm->bindParam(":nick",$nick);
    $stm->bindParam(":id_tpousuario",$id_tpousuario);
    $stm->bindParam(":id_status",$id_status);

    // Ejecutar la consulta
    $stm->execute();
    
    header("location:usuarios.php");    
    exit();
    
} catch (PDOException $e) {
        // Manejar excepciones relacionadas con la consulta
        echo "Error al actualizar el registro: " . $e->getMessage();
    } finally{
        // Cerrar la conexión PDO
        $conexion = null;
    }


?>
