<?php
include("Conexion.php");
$conn = Conexion::conectar();
$sql = "SELECT * FROM notificacion";
$stmt = $conn->query($sql);
$notificacion = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlEdit = "SELECT * FROM notificacion WHERE IdNotificacion = ?";
    $stmtEdit = $conn->prepare($sqlEdit);
    $stmtEdit->execute([$id]);
    $notificacion = $stmtEdit->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $sqlUpdate = "UPDATE notificacion SET Asunto = ?, Descripcion = ?, Tipo = ? WHERE IdNotificacion = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->execute([$asunto, $descripcion, $tipo, $id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Notificación</title>
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

        form {
            margin: 30px auto;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        input[type="text"], textarea {
            width: 95%;
            padding: 8px;
            margin: 6px 0 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #1a73e8;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0c5cd9;
        }
    </style>
</head>
<body>

    <h2>Listado de Notificaciones</h2>

    <?php if ($notificacion): ?>
        <h3>Editar Notificación</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $notificacion['IdNotificacion']; ?>">
            
            <label>Asunto:</label><br>
            <input type="text" name="asunto" value="<?php echo $notificacion['Asunto']; ?>"><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion"><?php echo $notificacion['Descripcion']; ?></textarea><br>

            <label>Tipo:</label><br>
            <input type="text" name="tipo" value="<?php echo $notificacion['Tipo']; ?>"><br>

            <button type="submit" name="actualizar">Actualizar</button>
        </form>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Asunto</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Fecha de Creación</th>
            <th>Editar</th>
        </tr>
        <?php while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $fila['IdNotificacion']; ?></td>
                <td><?php echo $fila['Asunto']; ?></td>
                <td><?php echo $fila['Descripcion']; ?></td>
                <td><?php echo $fila['Tipo']; ?></td>
                <td><?php echo $fila['Fecha_Creacion']; ?></td>
                <td>
                    <a href="?id=<?php echo $fila['IdNotificacion']; ?>">Editar</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
