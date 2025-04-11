<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $autor = $_POST['autor'];
    $id_negocio = $_POST['id_negocio'];
    $id_categoria = $_POST['id_categoria'];

    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmt = $pdo->prepare("UPDATE publicaciones 
                               SET Titulo = ?, Descripcion = ?, FechaCreacion = ?, Autor = ?, IdNegocios = ?, IdCategorias = ?
                               WHERE IdPublicaciones = ?");
        $stmt->execute([$titulo, $descripcion, $fecha, $autor, $id_negocio, $id_categoria, $id]);

        echo "Publicación actualizada correctamente. <a href='actualizar_publicacion.php'>Volver al listado</a>";
    } catch (PDOException $e) {
        echo "Error al actualizar publicación: " . $e->getMessage();
    }
} else {
    echo "Acceso no permitido.";
}