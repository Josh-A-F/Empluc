<?php
require_once 'conexion.php';

class Notificacion {
    private $asunto;
    private $descripcion;
    private $tipo;
    private $fechaCreacion;
    private $usuarioAdministradorId;

    public function setAsunto($asunto) {
        $this->asunto = $asunto;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setUsuarioAdministradorId($usuarioAdministradorId) {
        $this->usuarioAdministradorId = $usuarioAdministradorId;
    }

    public function getAsunto() {
        return $this->asunto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getUsuarioAdministradorId() {
        return $this->usuarioAdministradorId;
    }

    public function guardar($conexion) {
        $sql = "INSERT INTO notificacion (Asunto, Descripcion, Tipo, Fecha_Creacion, usuarioAdministrador)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        return $stmt->execute([
            $this->asunto,
            $this->descripcion,
            $this->tipo,
            $this->fechaCreacion,
            $this->usuarioAdministradorId
        ]);
    }
}
?>


