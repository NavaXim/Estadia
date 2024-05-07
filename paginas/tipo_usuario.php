<?php
// Obtener los datos del formulario
require_once('../bd/conexion.php');

// Consulta parametrizada con marcadores de posición
$sql = $conexion->prepare("SELECT id_tpousuario, desc_tpousuario FROM cg_tpousuario");

// Ejecutar la consulta
$sql->execute();

// Obtener el resultado de la consulta
$resultado = $sql->fetch(PDO::FETCH_ASSOC);
?>