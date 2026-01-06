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
        } else {
            echo "Acción no válida";
        }
        break;

    case 'productos':
        include_once 'controllers/ProductosController.php';
        $obj = new ProductosController();

        if (method_exists($obj, $action)) {
            $obj->$action();
        } else {
            echo "Acción no válida";
        }
        break;
        
    case 'carrito':
        include_once 'controllers/CarritoController.php';
        $obj = new CarritoController();
        if (method_exists($obj, $action)) {
            $obj->$action();
            exit;
        } else {
            echo "Acción de carrito no válida";
            exit;
        }

    case 'home':
        include_once "vista/usuario/home/home.php";
        break;
    


    default:
        echo "Controlador no válido";
        break;
}
