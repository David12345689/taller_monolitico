<?php
require_once __DIR__ . '/../models/entities/Programa.php';

class ProgramasController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Programa();
    }

    public function index() {
        $programas = $this->modelo->listar();
        require __DIR__ . '/../views/programas/listar.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->modelo->crear($_POST);

            if ($resultado === "duplicado") {
                echo "<script>alert('⚠️ El código del programa ya existe. Usa uno diferente.');</script>";
            } elseif ($resultado === true) {
                echo "<script>alert('✅ Programa registrado correctamente.');</script>";
                echo "<script>window.location.href='index.php?controller=programas&action=index';</script>";
                exit;
            } else {
                echo "<script>alert('❌ Error al registrar el programa.');</script>";
            }
        }

        require __DIR__ . '/../views/programas/formulario.php';
    }

    public function editar() {
        $codigo = $_GET['codigo'];
        $programa = $this->modelo->obtener($codigo);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->actualizar($codigo, $_POST);
            echo "<script>alert('✅ Programa actualizado correctamente.');</script>";
            echo "<script>window.location.href='index.php?controller=programas&action=index';</script>";
            exit;
        }

        require __DIR__ . '/../views/programas/formulario.php';
    }

    public function eliminar() {
        $codigo = $_GET['codigo'];
        $resultado = $this->modelo->eliminar($codigo);

        if ($resultado === "relaciones") {
            echo "<script>alert('⚠️ No se puede eliminar el programa porque tiene estudiantes o materias asociadas.');</script>";
        } elseif ($resultado === true) {
            echo "<script>alert('✅ Programa eliminado correctamente.');</script>";
        } else {
            echo "<script>alert('❌ Error al eliminar el programa.');</script>";
        }

        echo "<script>window.location.href='index.php?controller=programas&action=index';</script>";
        exit;
    }
}
?>