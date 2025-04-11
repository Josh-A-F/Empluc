<?php
require_once 'conexion.php';

try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    if (isset($_POST['id'], $_POST['titulo'], $_POST['descripcion'], $_POST['autor'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $autor = $_POST['autor'];

        $stmt = $pdo->prepare("UPDATE publicaciones SET Titulo = ?, Descripcion = ?, Autor = ? WHERE IdPublicaciones = ?");
        $stmt->execute([$titulo, $descripcion, $autor, $id]);

        echo "<h3>✅ Datos actualizados correctamente.</h3>";
        echo "<a href='actualizar_publicacion.php'>Volver al listado</a>";
    } else {
        echo "<p>❌ Faltan datos del formulario.</p>";
    }
} catch (PDOException $e) {
    echo "Error en la actualización: " . $e->getMessage();
}
?>