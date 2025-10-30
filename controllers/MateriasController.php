<?php
require_once __DIR__ . '/../models/entities/Materia.php';
require_once __DIR__ . '/../models/entities/Programa.php';

class MateriasController {
    private $modelo;
    private $programaModel;

    public function __construct() {
        $this->modelo = new Materia();
        $this->programaModel = new Programa();
    }

    public function index() {
        $materias = $this->modelo->listar();
        require __DIR__ . '/../views/materias/listar.php';
    }

    public function crear() {
        $programas = $this->programaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->modelo->crear($_POST);

            if ($resultado === "duplicado") {
                echo "<script>alert('⚠️ El código de la materia ya existe. Usa uno diferente.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert('✅ Materia registrada correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=materias&action=index';</script>";
                exit;
            } else {
                echo "<script>alert('❌ Error al registrar la materia.');</script>";
            }
        }

        require __DIR__ . '/../views/materias/formulario.php';
    }

    public function editar() {
        $codigo = $_GET['codigo'];
        $materia = $this->modelo->obtener($codigo);
        $programas = $this->programaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->actualizar($codigo, $_POST);
            echo "<script>alert('✅ Materia actualizada correctamente.');</script>";
            echo "<script>window.location.href='index.php?controller=materias&action=index';</script>";
            exit;
        }

        require __DIR__ . '/../views/materias/formulario.php';
    }

    public function eliminar() {
        $codigo = $_GET['codigo'];
        $resultado = $this->modelo->eliminar($codigo);

        if ($resultado === "relaciones") {
            echo "<script>alert('⚠️ No se puede eliminar la materia porque tiene notas asociadas.');</script>";
        } elseif ($resultado === true) {
            echo "<script>alert('✅ Materia eliminada correctamente.');</script>";
        } else {
            echo "<script>alert('❌ Error al eliminar la materia.');</script>";
        }

        echo "<script>window.location.href='index.php?controller=materias&action=index';</script>";
        exit;
    }
}
?>