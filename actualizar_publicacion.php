<?php
require_once 'conexion.php';

try {
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    $stmt = $pdo->query("SELECT IdPublicacion, Titulo, Descripcion, FechaCreacion, Autor FROM publicaciones ORDER BY FechaCreacion DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Listado de Publicaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            margin-top: 40px;
        }

        h2 {
            color: #333;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px #ccc;
        }

        th, td {
            padding: 12px 20px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #eee;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Listado de Publicaciones</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha de Creación</th>
            <th>Autor</th>
            <th>Editar</th>
        </tr>
        <?php
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$fila['IdPublicacion']}</td>";
                echo "<td>{$fila['Titulo']}</td>";
                echo "<td>{$fila['Descripcion']}</td>";
                echo "<td>{$fila['FechaCreacion']}</td>";
                echo "<td>{$fila['Autor']}</td>";
                echo "<td><a href='editar_publicacion.php?id={$fila['IdPublicacion']}'>Editar</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>

<?php
} catch (PDOException $e) {
    echo "Error al cargar publicaciones: " . $e->getMessage();
}
?>