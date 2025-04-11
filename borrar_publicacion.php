<?php
require_once 'conexion.php';

try {
    $conexion = Conexion::conectar();
    $sql = "SELECT IdPublicacion, Titulo, Autor FROM publicaciones";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener las publicaciones: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (empty($id)) {
        die("Por favor, selecciona una publicación para borrar.");
    }

    try {
        $conexion = Conexion::conectar();
        $sql = "DELETE FROM publicaciones WHERE IdPublicacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        echo "¡Publicación borrada exitosamente!";
    } catch (Exception $e) {
        echo "Error al borrar la publicación: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Publicación</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 800px;
            background-color: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: left;
        }

        th {
            background-color: #e6e6e6;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
        }

        a:hover {
            color: #1a73e8;
        }
    </style>
</head>
<body>
    <h1>Borrar Publicación</h1>
    <form method="post">
        <label for="id">Selecciona una publicación:</label>
        <select name="id" id="id" required>
            <option value="">-- Elige una publicación --</option>
            <?php if (!empty($publicaciones)) : ?>
                <?php foreach ($publicaciones as $p) : ?>
                    <option value="<?= $p['IdPublicacion']; ?>">
                        ID: <?= $p['IdPublicacion']; ?> - <?= htmlspecialchars($p['Titulo']); ?> (<?= htmlspecialchars($p['Autor']); ?>)
                    </option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">No hay publicaciones disponibles</option>
            <?php endif; ?>
        </select>
        <br><br>
        <button type="submit">Borrar Publicación</button>
    </form>
</body>
</html>