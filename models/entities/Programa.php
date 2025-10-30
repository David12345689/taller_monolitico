<?php
require_once __DIR__ . '/../drives/conexionDB.php';

class Programa {
    private $pdo;

    public function __construct() {
        $this->pdo = (new ConexionDB())->getConexion();
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM programas");
        return $stmt->fetchAll();
    }

    public function obtener($codigo) {
        $stmt = $this->pdo->prepare("SELECT * FROM programas WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch();
    }

    public function existeCodigo($codigo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM programas WHERE codigo = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($data) {
        if ($this->existeCodigo($data['codigo'])) {
            return "duplicado";
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO programas (codigo, nombre) VALUES (?, ?)");
            $stmt->execute([$data['codigo'], $data['nombre']]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($codigo, $data) {
        $stmt = $this->pdo->prepare("UPDATE programas SET nombre = ? WHERE codigo = ?");
        return $stmt->execute([$data['nombre'], $codigo]);
    }

    public function eliminar($codigo) {
        $check1 = $this->pdo->prepare("SELECT COUNT(*) FROM estudiantes WHERE programa = ?");
        $check1->execute([$codigo]);
        $check2 = $this->pdo->prepare("SELECT COUNT(*) FROM materias WHERE programa = ?");
        $check2->execute([$codigo]);

        if ($check1->fetchColumn() > 0 || $check2->fetchColumn() > 0) {
            return "relaciones";
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM programas WHERE codigo = ?");
            $stmt->execute([$codigo]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>