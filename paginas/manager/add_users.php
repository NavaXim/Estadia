<?php

require_once('../../bd/conexion.php');

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$nick = $_POST['nick'];
$pwd = $_POST['pwd'];

try {
    // Preparar la consulta SQL
    $sql = "INSERT INTO tbl_usuarios(nombre, ap_paterno, ap_materno, nick, pwd) VALUES(TRIM(UPPER(:nombre)), TRIM(UPPER(:ap_paterno)), TRIM(UPPER(:ap_materno)), TRIM(:nick), TRIM(SHA(:pwd)))";
    $stmt = $conexion->prepare($sql);

    // Bind de parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ap_paterno', $ap_paterno);
    $stmt->bindParam(':ap_materno', $ap_materno);
    $stmt->bindParam(':nick', $nick);
    $stmt->bindParam(':pwd', $pwd);

    // Ejecutar la consulta
    $stmt->execute();
    
    header("Location: usuarios.php");
    exit();

} catch (PDOException $e) {
    // Manejar excepciones relacionadas con la consulta
    echo "Error al guardar el registro: " . $e->getMessage();
} finally {
    // Cerrar la conexión PDO
    $conexion = null;
}

?>
