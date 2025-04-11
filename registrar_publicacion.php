<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $nombreNegocio = trim($_POST['nombre_negocio'] ?? '');
    $id_categoria = $_POST['id_categoria'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $fechaCreacion = date('Y-m-d');

    $fotoTmp = $_FILES['fotos']['tmp_name'];
    $contenidoImagen = file_get_contents($fotoTmp);

    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $stmtBuscar = $pdo->prepare("SELECT IdNegocios FROM negocios WHERE Nombre = ?");
        $stmtBuscar->execute([$nombreNegocio]);
        $negocio = $stmtBuscar->fetch(PDO::FETCH_ASSOC);

        if ($negocio) {
            $id_negocio = $negocio['IdNegocios'];
        } else {
            $direccionPorDefecto = 'Dirección no proporcionada';
            $stmtInsertar = $pdo->prepare("INSERT INTO negocios (Nombre, Direccion) VALUES (?, ?)");
            $stmtInsertar->execute([$nombreNegocio, $direccionPorDefecto]);
            $id_negocio = $pdo->lastInsertId();
        }
        
        $sql = "INSERT INTO publicaciones (FechaCreacion, Titulo, Descripcion, Fotos, IdNegocios, IdCategorias, Autor)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $fechaCreacion);
        $stmt->bindParam(2, $titulo);
        $stmt->bindParam(3, $descripcion);
        $stmt->bindParam(4, $contenidoImagen, PDO::PARAM_LOB);
        $stmt->bindParam(5, $id_negocio);
        $stmt->bindParam(6, $id_categoria);
        $stmt->bindParam(7, $autor);
        $stmt->execute();

        echo "✅ ¡Publicación registrada exitosamente!";
    } catch (Exception $e) {
        echo "❌ Error al registrar publicación: " . $e->getMessage();
    }
}
?>