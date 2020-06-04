<?php

class FrontController {

    static function main() {
        require_once 'libs/View.php';
        require_once 'libs/configuration.php';

        if (!empty($_GET['controlador'])) {
            $controllerName = $_GET['controlador'] . 'Controller';
        } else {
            $controllerName = 'DefaultController';
        }

        if (!empty($_GET['accion'])) {
            $nombreAccion = $_GET['accion'];
        } else {
            $nombreAccion = 'accionDefault';
        }
        $rutaController = $config->get('controllerFolder') . $controllerName . '.php';

        if (is_file($rutaController)) {
            require_once $rutaController;
        } else {
            die('Controlador no encontrado - 404 not found');
        }

        if (!is_callable(array($controllerName, $nombreAccion))) {
            trigger_error($controllerName . '->' . $nombreAccion . ' no existe', E_USER_NOTICE);
            return FALSE;
        }

        $controller = new $controllerName;
        $controller->$nombreAccion();
    }

}
