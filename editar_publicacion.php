<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE IdPublicacion = ?");
    $stmt->execute([$id]);
    $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($publicacion):
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Publicación</title>
</head>
<body>
    <h2>Editar Publicación</h2>
    <form action="procesar_actualizacion.php" method="POST">
        <input type="hidden" name="id" value="<?= $publicacion['IdPublicacion'] ?>">

        <label>Título:</label><br>
        <input type="text" name="titulo" value="<?= $publicacion['Titulo'] ?>"><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= $publicacion['Descripcion'] ?></textarea><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" value="<?= $publicacion['Autor'] ?>"><br><br>

        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>

<?php
    else:
        echo "Publicación no encontrada.";
    endif;
} else {
    echo "ID no proporcionado.";
}
?>