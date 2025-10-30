<?php
require_once __DIR__ . '/../drives/conexionDB.php';

class Nota {
    private $pdo;

    public function __construct() {
        $this->pdo = (new ConexionDB())->getConexion();
    }

    public function listar() {
        $stmt = $this->pdo->query("
            SELECT n.id, n.materia, n.estudiante, n.actividad, n.nota,
                   e.nombre AS estudiante_nombre,
                   m.nombre AS materia_nombre
            FROM notas n
            JOIN estudiantes e ON n.estudiante = e.codigo
            JOIN materias m ON n.materia = m.codigo
        ");
        return $stmt->fetchAll();
    }

    public function obtener($materia, $estudiante, $actividad) {
        $stmt = $this->pdo->prepare("SELECT * FROM notas WHERE materia = ? AND estudiante = ? AND actividad = ?");
        $stmt->execute([$materia, $estudiante, $actividad]);
        return $stmt->fetch();
    }

    public function existeRegistro($materia, $estudiante, $actividad) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notas WHERE materia = ? AND estudiante = ? AND actividad = ?");
        $stmt->execute([$materia, $estudiante, $actividad]);
        return $stmt->fetchColumn() > 0;
    }

    public function crear($data) {
        $nota = round(floatval($data['valor']), 2);

        if ($nota < 0 || $nota > 5) {
            return "fuera_rango";
        }

        if ($this->existeRegistro($data['materia'], $data['estudiante'], $data['actividad'])) {
            return "duplicado";
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO notas (materia, estudiante, actividad, nota) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['materia'], $data['estudiante'], $data['actividad'], $nota]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // New methods to work with the numeric id primary key
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM notas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function actualizarPorId($id, $notaVal) {
        $nota = round(floatval($notaVal), 2);

        if ($nota < 0 || $nota > 5) {
            return "fuera_rango";
        }

        $stmt = $this->pdo->prepare("UPDATE notas SET nota = ? WHERE id = ?");
        return $stmt->execute([$nota, $id]);
    }

    public function eliminarPorId($id) {
        $stmt = $this->pdo->prepare("DELETE FROM notas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function actualizar($materia, $estudiante, $actividad, $notaVal) {
        $nota = round(floatval($notaVal), 2);

        if ($nota <= 0 || $nota >= 5) {
            return "fuera_rango";
        }

        $stmt = $this->pdo->prepare("UPDATE notas SET nota = ? WHERE materia = ? AND estudiante = ? AND actividad = ?");
        return $stmt->execute([$nota, $materia, $estudiante, $actividad]);
    }

    public function eliminar($materia, $estudiante, $actividad) {
        $stmt = $this->pdo->prepare("DELETE FROM notas WHERE materia = ? AND estudiante = ? AND actividad = ?");
        return $stmt->execute([$materia, $estudiante, $actividad]);
    }

    public function obtenerPromedio($estudiante, $materia) {
        $stmt = $this->pdo->prepare("
            SELECT AVG(nota) as promedio 
            FROM notas 
            WHERE estudiante = ? AND materia = ?
        ");
        $stmt->execute([$estudiante, $materia]);
        $resultado = $stmt->fetch();
        return $resultado ? round($resultado['promedio'], 2) : 0;
    }

    public function materiaEnProgramaEstudiante($materia, $estudiante) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM estudiantes e
            JOIN materias m ON e.programa = m.programa
            WHERE e.codigo = ? AND m.codigo = ?
        ");
        $stmt->execute([$estudiante, $materia]);
        return $stmt->fetchColumn() > 0;
    }

    public function listarPromediosPorMateria($estudiante) {
        $stmt = $this->pdo->prepare("
            SELECT m.codigo, m.nombre, 
                   COALESCE(ROUND(AVG(n.nota), 2), 0) as promedio
            FROM materias m
            LEFT JOIN notas n ON m.codigo = n.materia AND n.estudiante = ?
            WHERE m.programa = (SELECT programa FROM estudiantes WHERE codigo = ?)
            GROUP BY m.codigo, m.nombre
        ");
        $stmt->execute([$estudiante, $estudiante]);
        return $stmt->fetchAll();
    }

    public function listarPromediosPorEstudiante($materia) {
        $stmt = $this->pdo->prepare("
            SELECT e.codigo, e.nombre, e.email,
                   COALESCE(ROUND(AVG(n.nota), 2), 0) as promedio
            FROM estudiantes e
            LEFT JOIN notas n ON e.codigo = n.estudiante AND n.materia = ?
            WHERE e.programa = (SELECT programa FROM materias WHERE codigo = ?)
            GROUP BY e.codigo, e.nombre, e.email
        ");
        $stmt->execute([$materia, $materia]);
        return $stmt->fetchAll();
    }

    public function listarPorEstudianteMateria($estudiante, $materia) {
        $stmt = $this->pdo->prepare("SELECT actividad, nota, id FROM notas WHERE estudiante = ? AND materia = ? ORDER BY actividad");
        $stmt->execute([$estudiante, $materia]);
        return $stmt->fetchAll();
    }
}
?>