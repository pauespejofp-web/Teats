<?php
include_once "models/Usuario/Usuario.php";
session_start();

$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action'] ?? 'inicio';


switch ($controller) {

    case 'usuario':
        include_once 'controllers/UsuarioController.php';
        $obj = new UsuarioController();

        if (method_exists($obj, $action)) {
            $obj->$action();
            exit;
        } else {
            echo "Acción no válida";
        }
        break;

    case 'home':
        include_once "vista/usuario/home/home.php";
        exit;

    default:
        echo "Controlador no válido";
        exit;
    case 'productos':
        include_once 'controllers/ProductosController.php';
        $controllerObj = new ProductosController();

        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
            exit;
        }
}
