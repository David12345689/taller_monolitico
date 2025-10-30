<?php
require_once __DIR__ . '/../models/entities/Nota.php';
require_once __DIR__ . '/../models/entities/Estudiante.php';
require_once __DIR__ . '/../models/entities/Materia.php';

class NotasController {
    private $modelo;
    private $estModel;
    private $matModel;

    public function __construct() {
        $this->modelo = new Nota();
        $this->estModel = new Estudiante();
        $this->matModel = new Materia();
    }

    public function index() {
        $notas = $this->modelo->listar();
        $estudiantes = $this->estModel->listar();
        $materias = $this->matModel->listar();
        require __DIR__ . '/../views/notas/listar.php';
    }

    public function crear() {
        $estudiantes = $this->estModel->listar();
        $materias = $this->matModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que la materia pertenezca al programa del estudiante
            if (!$this->modelo->materiaEnProgramaEstudiante($_POST['materia'], $_POST['estudiante'])) {
                echo "<script>alert('⚠️ La materia no pertenece al programa del estudiante.');</script>";
                require __DIR__ . '/../views/notas/formulario.php';
                return;
            }

            $resultado = $this->modelo->crear($_POST);

            if ($resultado === "fuera_rango") {
                echo "<script>alert(' La nota debe ser mayor que 0 y menor que 5.');</script>";
            } elseif ($resultado === "duplicado") {
                echo "<script>alert(' Ya existe una nota para ese estudiante, materia y actividad.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert('Nota registrada correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=notas&action=index';</script>";
                exit;
            } else {
                echo "<script>alert('Error al registrar la nota.');</script>";
            }
        }

        require __DIR__ . '/../views/notas/formulario.php';
    }

    public function editar() {
        // Use numeric id (primary key) for editar
        $id = $_GET['id'];

        $nota = $this->modelo->obtenerPorId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->modelo->actualizarPorId($id, $_POST['valor']);

            if ($resultado === "fuera_rango") {
                echo "<script>alert(' La nota debe ser mayor o igual a 0 y menor o igual a 5.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert(' Nota actualizada correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=notas&action=index';</script>";
                exit;
            } else {
                echo "<script>alert(' Error al actualizar la nota.');</script>";
            }
        }

        require __DIR__ . '/../views/notas/formulario.php';
    }

    public function eliminar() {
        // Use numeric id (primary key) for eliminar
        $id = $_GET['id'];

        $resultado = $this->modelo->eliminarPorId($id);

        if ($resultado === true) {
            echo "<script>alert(' Nota eliminada correctamente.');</script>";
        } else {
            echo "<script>alert(' Error al eliminar la nota.');</script>";
        }

        echo "<script>window.location.href='index.php?controller=notas&action=index';</script>";
        exit;
    }

    public function verPromedios() {
        // Mostrar promedios por materia para un estudiante
        $estudianteId = $_GET['estudiante'] ?? null;
        if (!$estudianteId) {
            echo "<script>alert('Estudiante no especificado'); window.history.back();</script>";
            exit;
        }

        $estudiante = $this->estModel->obtener($estudianteId);
        $promedios = $this->modelo->listarPromediosPorMateria($estudianteId);

        require __DIR__ . '/../views/notas/promedios_materia.php';
    }

    public function verPromediosPorMateria() {
        // Mostrar promedios por estudiante para una materia
        $materiaId = $_GET['materia'] ?? null;
        if (!$materiaId) {
            echo "<script>alert('Materia no especificada'); window.history.back();</script>";
            exit;
        }

        $materia = $this->matModel->obtener($materiaId);
        $promedios = $this->modelo->listarPromediosPorEstudiante($materiaId);

        require __DIR__ . '/../views/notas/promedios_estudiante.php';
    }

    public function verDetalleNotas() {
        // Mostrar detalle de notas para un estudiante y una materia
        $estudianteId = $_GET['estudiante'] ?? null;
        $materiaId = $_GET['materia'] ?? null;

        if (!$estudianteId || !$materiaId) {
            echo "<script>alert('Parámetros insuficientes'); window.history.back();</script>";
            exit;
        }

        $estudiante = $this->estModel->obtener($estudianteId);
        $materia = $this->matModel->obtener($materiaId);
        $notas = $this->modelo->listarPorEstudianteMateria($estudianteId, $materiaId);
        $promedio = $this->modelo->obtenerPromedio($estudianteId, $materiaId);

        require __DIR__ . '/../views/notas/detalle_notas.php';
    }
}
?>