<?php
require_once 'conexion.php';

try {
    $conexion = Conexion::conectar(); 
    $sql = "SELECT IdNotificacion, Asunto FROM notificacion";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener las notificaciones: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (empty($id)) {
        die("Por favor, selecciona una notificación para borrar.");
    }

    try {
        $conexion = Conexion::conectar();
        $sql = "DELETE FROM notificacion WHERE IdNotificacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        echo "¡Notificación borrada exitosamente!";
    } catch (Exception $e) {
        echo "Error al borrar la notificación: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrar Notificación</title>
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
    <h1>Borrar Notificación</h1>
    <form method="post">
        <label for="id">Selecciona una notificación:</label>
        <select name="id" id="id" required>
            <option value="">-- Elige una notificación --</option>
            <?php if (!empty($notificaciones)) : ?>
                <?php foreach ($notificaciones as $n) : ?>
                    <option value="<?= $n['IdNotificacion']; ?>">
                        ID: <?= $n['IdNotificacion']; ?> - <?= $n['Asunto']; ?>
                    </option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">No hay notificaciones disponibles</option>
            <?php endif; ?>
        </select>
        <br><br>
        <button type="submit">Borrar Notificación</button>
    </form>
</body>
</html>