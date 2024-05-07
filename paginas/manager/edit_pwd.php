<?php

require_once('../../bd/conexion.php');

// Obtener los datos del formulario
$id_usuario = $_POST['edtpwd_id'];
$nick = $_POST['edtpwd_nick'];
$pwd = $_POST['edtpwd_pwd'];


echo "ID Usuario: " . $id_usuario . "<br>";
echo "Usuario: " . $nick . "<br>";
echo "Contraseña: " . $pwd . "<br>";

try {
    // Preparar la consulta SQL
    $stm = $conexion->prepare("UPDATE tbl_usuarios SET pwd = TRIM(SHA(:pwd)) WHERE id_usuario = :id_usuario");

    // Bind de parámetros
    $stm->bindParam(":id_usuario",$id_usuario);
    $stm->bindParam(":pwd",$pwd);

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
