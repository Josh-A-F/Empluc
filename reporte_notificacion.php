<?php 
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';

    if (empty($tipo)) {
        header("Location: filtro_notificacion.html");
        exit;
    }

    try {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $sql = "SELECT IdNotificacion, asunto, descripcion, tipo, fecha_creacion 
                FROM notificacion 
                WHERE tipo = :tipo 
                ORDER BY fecha_creacion DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':tipo', $tipo);
        $stmt->execute();

        echo "
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
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
                background-color: white;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 10px;
            }
            th {
                background-color: #eee;
                font-weight: bold;
            }
        </style>
        ";

        echo "<h2>Listado de Notificaciones de tipo: <em>$tipo</em></h2>";
        echo "<a href='filtro_notificacion.php'>⟵ Volver al filtro</a><br><br>";

        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Asunto</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Fecha de Creación</th>
              </tr>";

        $hayResultados = false;
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $hayResultados = true;
            echo "<tr>";
            echo "<td>{$fila['IdNotificacion']}</td>";
            echo "<td>{$fila['asunto']}</td>";
            echo "<td>{$fila['descripcion']}</td>";
            echo "<td>{$fila['tipo']}</td>";
            echo "<td>{$fila['fecha_creacion']}</td>";
            echo "</tr>";
        }

        if (!$hayResultados) {
            echo "<tr><td colspan='5'>No se encontraron notificaciones de tipo $tipo.</td></tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: filtro_notificacion.html");
    exit;
}
?>