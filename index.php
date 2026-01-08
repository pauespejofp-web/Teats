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
        include_once 'controllers/homeController.php';
        $controllerObj = new HomeController();

        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
            exit;
        } else {
            echo "Acción no válida";
            exit;
        }

    
    case 'productos':
        include_once 'controllers/productosController.php';
        $controllerObj = new ProductosController();

        if (method_exists($controllerObj, $action)) {
            $controllerObj->$action();
            exit;
        }

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
    case 'pedidos':
    include_once 'controllers/PedidosController.php';
    $obj = new PedidosController();
    if (method_exists($obj, $action)) {
        $obj->$action();
        exit;
    } else {
        echo "Acción de pedidos no válida";
        exit;
    }
    default:
        echo "Controlador no válido";
        exit;
}
