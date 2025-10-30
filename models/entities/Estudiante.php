<?php
require_once __DIR__ . '/../drives/conexionDB.php';

class Estudiante {
    private $pdo;

    public function __construct() {
        $this->pdo = (new ConexionDB())->getConexion();
    }

    public function listar() {
        $stmt = $this->pdo->query("Select estudiantes.*  , programas.nombre AS nombrePrograma from estudiantes inner join programas on estudiantes.programa = programas.codigo");
        return $stmt->fetchAll();
    }

    public function obtener($codigo) {
        $stmt = $this->pdo->prepare("SELECT * FROM estudiantes WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch();
    }

    public function existeCodigo($codigo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM estudiantes WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetchColumn() > 0;
    }

    public function tieneNotas($codigo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notas WHERE estudiante = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($data) {
        if ($this->existeCodigo($data['codigo'])) {
            return "duplicado";
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['codigo'], $data['nombre'], $data['email'], $data['programa']]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($codigo, $data) {
        $stmt = $this->pdo->prepare("UPDATE estudiantes SET nombre = ?, email = ?, programa = ? WHERE codigo = ?");
        return $stmt->execute([$data['nombre'], $data['email'], $data['programa'], $codigo]);
    }

    public function eliminar($codigo) {
        if ($this->tieneNotas($codigo)) {
            return "relaciones";
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM estudiantes WHERE codigo = ?");
            $stmt->execute([$codigo]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>