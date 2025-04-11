<<?php
require_once 'conexion.php';

$conexion = new Conexion();
$pdo = $conexion->conectar();

// Obtener categorías
$stmtCategorias = $pdo->query("SELECT IdCategoria, Nombre FROM categoria");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Publicación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
            text-align: center;
        }

        form {
            display: inline-block;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        input, select, textarea {
            width: 250px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #34495e;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Registrar Publicación</h2>
    <form action="registrar_publicacion.php" method="POST" enctype="multipart/form-data">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required></textarea><br>

        <label>Foto:</label><br>
        <input type="file" name="fotos" accept="image/*" required><br>

        <label>Nombre del Negocio:</label><br>
        <input type="text" name="nombre_negocio" required><br>

        <label>Categoría:</label><br>
        <select name="id_categoria" required>
            <option value="">-- Selecciona una categoría --</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['IdCategoria'] ?>"><?= htmlspecialchars($categoria['Nombre']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required><br>

        <input type="submit" value="Registrar Publicación">
    </form>
</body>
</html>