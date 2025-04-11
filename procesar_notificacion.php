<?php
require_once 'conexion.php';
require_once 'notificacion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $fechaCreacion = $_POST['fecha_creacion'];

    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $noti = new Notificacion();
        $noti->setAsunto($asunto);
        $noti->setDescripcion($descripcion);
        $noti->setTipo($tipo);
        $noti->setFechaCreacion($fechaCreacion);
        $noti->setUsuarioAdministradorId(1);

        if ($noti->guardar($pdo)) {
            echo "✅ ¡Notificación registrada exitosamente!";
        } else {
            echo "❌ Error al registrar la notificación.";
        }

    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>