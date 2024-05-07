<?php
// Obtener los datos del formulario
$user = $_POST['user'];
$pwd = $_POST['pwd'];

require_once('../bd/conexion.php');

// Consulta parametrizada con marcadores de posición
$sql = $conexion->prepare("SELECT CONCAT(ap_paterno,' ',ap_materno,', ',nombre) AS nombre, desc_tpousuario  FROM tbl_usuarios INNER JOIN cg_tpousuario ON tbl_usuarios.id_tpousuario = cg_tpousuario.id_tpousuario  WHERE nick= :user AND pwd=SHA(:pwd) and id_status= '1' ");

// Bind de parámetros
$sql->bindParam(':user', $user);
$sql->bindParam(':pwd', $pwd);

// Ejecutar la consulta
$sql->execute();

// Verificar si la consulta entregó resultados
if ($sql->rowCount() > 0) {
    // Obtener el resultado de la consulta
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    // Acceder a los datos
    $nombre = $resultado['nombre'];
    $tpousuario = $resultado['desc_tpousuario'];
    
    session_start();
    $_SESSION['nombre'] = $nombre;
    echo json_encode(array("success" => true, "resultado" => $resultado));
} else{
    echo json_encode(array("success" => false, "mensaje" => "El usuario / contraseña no son validos o esta inactivo"));    
}
?>