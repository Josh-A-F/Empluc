<?php
require_once 'conexion.php';

$conexion = Conexion::conectar();

$sql = "SELECT * FROM publicaciones";
$stmt = $conexion->query($sql);
$publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($publicaciones as &$pub) {

    $stmtNeg = $conexion->prepare("SELECT Nombre FROM negocios WHERE IdNegocios = ?");
    $stmtNeg->execute([$pub['IdNegocios']]);
    $pub['NombreNegocio'] = $stmtNeg->fetchColumn();

    $stmtCat = $conexion->prepare("SELECT Nombre FROM categoria WHERE IdCategoria = ?");
    $stmtCat->execute([$pub['IdCategorias']]);
    $pub['NombreCategoria'] = $stmtCat->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Publicaciones</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Reporte de Publicaciones</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Negocio</th>
                <th>Categoría</th>
                <th>Autor</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($publicaciones as $pub): ?>
                <tr>
                    <td><?= $pub['IdPublicacion'] ?></td>
                    <td><?= $pub['FechaCreacion'] ?></td>
                    <td><?= htmlspecialchars($pub['Titulo']) ?></td>
                    <td><?= htmlspecialchars($pub['Descripcion']) ?></td>
                    <td><?= htmlspecialchars($pub['NombreNegocio']) ?></td>
                    <td><?= htmlspecialchars($pub['NombreCategoria']) ?></td>
                    <td><?= htmlspecialchars($pub['Autor']) ?></td>
                    <td>
                        <?php if (!empty($pub['Fotos'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($pub['Fotos']) ?>" alt="Foto" style="max-width: 100px;">
                        <?php else: ?>
                            Sin imagen
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>