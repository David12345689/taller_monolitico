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
        $materia = $_GET['materia'];
        $estudiante = $_GET['estudiante'];
        $actividad = $_GET['actividad'];

        $nota = $this->modelo->obtener($materia, $estudiante, $actividad);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->modelo->actualizar($materia, $estudiante, $actividad, $_POST['nota']);

            if ($resultado === "fuera_rango") {
                echo "<script>alert('⚠️ La nota debe ser mayor que 0 y menor que 5.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert('✅ Nota actualizada correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=notas&action=index';</script>";
                exit;
            } else {
                echo "<script>alert('❌ Error al actualizar la nota.');</script>";
            }
        }

        require __DIR__ . '/../views/notas/formulario.php';
    }

    public function eliminar() {
        $materia = $_GET['materia'];
        $estudiante = $_GET['estudiante'];
        $actividad = $_GET['actividad'];

        $resultado = $this->modelo->eliminar($materia, $estudiante, $actividad);

        if ($resultado === true) {
            echo "<script>alert('✅ Nota eliminada correctamente.');</script>";
        } else {
            echo "<script>alert('❌ Error al eliminar la nota.');</script>";
        }

        echo "<script>window.location.href='index.php?controller=notas&action=index';</script>";
        exit;
    }
}
?>