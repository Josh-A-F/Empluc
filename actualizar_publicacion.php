<?php
require_once 'conexion.php';
$conn = Conexion::conectar();
$sql = "SELECT * FROM publicaciones";
$stmt = $conn->query($sql);

$publicacion = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmtEdit = $conn->prepare("SELECT * FROM publicaciones WHERE IdPublicacion = ?");
    $stmtEdit->execute([$id]);
    $publicacion = $stmtEdit->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $autor = $_POST['autor'];

    $sqlUpdate = "UPDATE publicaciones SET Titulo = ?, Descripcion = ?, Autor = ? WHERE IdPublicacion = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->execute([$titulo, $descripcion, $autor, $id]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Publicación</title>
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

    <h2>Listado de Publicaciones</h2>

    <?php if ($publicacion): ?>
        <h3>Editar Publicación</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?= $publicacion['IdPublicacion'] ?>">
            
            <label>Título:</label><br>
            <input type="text" name="titulo" value="<?= htmlspecialchars($publicacion['Titulo']) ?>"><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion"><?= htmlspecialchars($publicacion['Descripcion']) ?></textarea><br>

            <label>Autor:</label><br>
            <input type="text" name="autor" value="<?= htmlspecialchars($publicacion['Autor']) ?>"><br>

            <button type="submit" name="actualizar">Actualizar</button>
        </form>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Autor</th>
            <th>Fecha</th>
            <th>Editar</th>
        </tr>
        <?php while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $fila['IdPublicacion'] ?></td>
                <td><?= htmlspecialchars($fila['Titulo']) ?></td>
                <td><?= htmlspecialchars($fila['Descripcion']) ?></td>
                <td><?= htmlspecialchars($fila['Autor']) ?></td>
                <td><?= $fila['FechaCreacion'] ?></td>
                <td>
                    <a href="?id=<?= $fila['IdPublicacion'] ?>">Editar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
