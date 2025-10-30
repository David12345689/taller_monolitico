<?php
require_once __DIR__ . '/../models/entities/Estudiante.php';
require_once __DIR__ . '/../models/entities/Programa.php';

class EstudiantesController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Estudiante();
    }

    public function index() {
        $estudiantes = $this->modelo->listar();
        require __DIR__ . '/../views/estudiantes/listar.php';
    }

    public function crear() {
        $programaModel = new Programa();
        $programas = $programaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->modelo->crear($_POST);

            if ($resultado === "duplicado") {
                echo "<script>alert(' El código del estudiante ya existe.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert(' Estudiante registrado correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=estudiantes&action=index';</script>";
                exit;
            } else {
                echo "<script>alert(' Error al registrar el estudiante.');</script>";
            }
        }

        require __DIR__ . '/../views/estudiantes/formulario.php';
    }

    public function editar() {
        $codigo = $_GET['codigo'];
        $estudiante = $this->modelo->obtener($codigo);
        $programaModel = new Programa();
        $programas = $programaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->actualizar($codigo, $_POST);
            echo "<script>alert('Estudiante actualizado correctamente.');</script>";
            echo "<script>window.location.href='index.php?controller=estudiantes&action=index';</script>";
            exit;
        }

        require __DIR__ . '/../views/estudiantes/formulario.php';
    }

    public function eliminar() {
        $codigo = $_GET['codigo'];
        $resultado = $this->modelo->eliminar($codigo);

        if ($resultado === "relaciones") {
            echo "<script>alert(' No se puede eliminar el estudiante porque tiene notas registradas.');</script>";
        } elseif ($resultado === true) {
            echo "<script>alert(' Estudiante eliminado correctamente.');</script>";
        } else {
            echo "<script>alert(' Error al eliminar el estudiante.');</script>";
        }

        echo "<script>window.location.href='index.php?controller=estudiantes&action=index';</script>";
        exit;
    }
}
?>