<?php
require_once 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['Correo'];
    $contraseña = $_POST['Password'];
    $id_rol = $_POST['id_rol']; 

    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ? AND id_rol = ?");
    $stmt->execute([$correo, $id_rol]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contraseña, $usuario['Contraseña'])) {
        
        $_SESSION['usuario'] = $usuario['Nombre']; 
        $_SESSION['id_usuario'] = $usuario['IdUsuario'];
        $_SESSION['id_rol'] = $usuario['id_rol'];

        echo "✅ Bienvenido, " . $usuario['Nombre'];
    } else {
        echo "❌ Correo, contraseña o rol incorrecto.";
    }
}
?>
