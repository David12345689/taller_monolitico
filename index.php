<?php
// Enrutador simple
$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? '';

if ($controller && $action) {
    $controllerFile = "controllers/" . ucfirst($controller) . "Controller.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerName = ucfirst($controller) . "Controller";
        $objController = new $controllerName();
        if (method_exists($objController, $action)) {
            $objController->$action();
        } else {
            echo "Acción no encontrada.";
        }
    } else {
        echo "Controlador no encontrado.";
    }
} else {
    
    require_once "views/menu.php";
}
?>