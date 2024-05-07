<?php
// Datos de conexión
$servername = 'localhost';
$username = 'u815293024_estr';
$password = 'C3c@t3p3x1';
$dbname = 'u815293024_sistema';

try {
    // Crear una instancia de la conexión PDO
    $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configurar el modo de manejo de errores para lanzar excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejar la excepción en caso de error de conexión
    echo "Error de conexión: " . $e->getMessage();
}

?>