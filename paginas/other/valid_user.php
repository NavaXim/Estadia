<?php
include('../templates/header.php');

require_once('../bd/conexion.php');

// Obtener los datos del formulario
$usuario = $_POST['usuario'];
$pwd = $_POST['contrasena'];


// Ahora puedes utilizar la variable $conexion en este script
try {
    // Consulta parametrizada con marcadores de posición
    $sql = $conexion->prepare("SELECT CONCAT(ap_paterno,' ',ap_materno,', ',nombre) AS nombre FROM tbl_usuarios WHERE nick= :usuario AND pwd=SHA(:pwd)");

    // Bind de parámetros
    $sql->bindParam(':usuario', $usuario);
    $sql->bindParam(':pwd', $pwd);

    // Ejecutar la consulta
    $sql->execute();

    // Verificar si la consulta entregó resultados
    if ($sql->rowCount() > 0) {
        // Obtener el resultado de la consulta
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);
        // Acceder a los datos
        $nombre = $resultado['nombre'];

        session_start();
        $_SESSION['nombre'] = $nombre;
        header("Location: ../paginas/");
        exit();
    } else {
        // La consulta no devolvió resultados
        echo '<script type="text/javascript">
                alert("Usuario o contraseña no validos");
                window.location.href="..";
            </script>';
    }
} catch (PDOException $e) {
    // Manejar excepciones relacionadas con la consulta
    echo "Error en la consulta: " . $e->getMessage();
} finally{
    // Cerrar la conexión PDO
    $conexion = null;
}

include('../templates/footer.php');
?>