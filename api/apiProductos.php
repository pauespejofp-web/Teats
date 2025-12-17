<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../models/Producto/Producto.php';
include_once __DIR__ . '/../models/Producto/ProductoDAO.php';





$metodo = $_SERVER['REQUEST_METHOD'];





switch ($metodo) {



    //GET:

    case 'GET':
        if (isset($_GET['id'])) {
            $producto = ProductoDAO::getById(intval($_GET['id']));
            if ($producto) {
                $data = [
                    'id_producto' => $producto->getIdProducto(),
                    'nombre' => $producto->getNombre(),
                    'descripcion' => $producto->getDescripcion(),
                    'precio' => $producto->getPrecio(),
                    'categoria' => $producto->getCategoriaId(),
                    'imagen_url' => $producto->getImagenUrl()
                ];
                echo json_encode(['estado' => 'Exito', 'data' => $data]);
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Producto no encontrado']);
            }
        } else {
            $productos = ProductoDAO::getAll();

            if (!$productos) {
                echo json_encode(['estado' => 'Fallido', 'data' => 'Error al obtener productos']);
                break;
            }else{

            $productos = ProductoDAO::getAll();
            $lista = [];
            foreach ($productos as $p) {
                $lista[] = [
                    'id_producto' => $p->getIdProducto(),
                    'nombre' => $p->getNombre(),
                    'descripcion' => $p->getDescripcion(),
                    'precio' => $p->getPrecio(),
                    'categoria' => $p->getCategoriaId(),
                    'imagen_url' => $p->getImagenUrl()
                ];
            }
            echo json_encode(['estado' => 'Exito', 'data' => $lista]);
        }
        }
        break;

    }


    //POST:



    // case 'POST':
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     if (isset($data['nombre'], $data['email'], $data['password'])) {
    //         $usuario = new Usuario();
    //         $usuario->setnombre($data['nombre']);
    //         $usuario->setEmail($data['email']);
    //         $usuario->setContraseña(password_hash($data['password'], PASSWORD_BCRYPT));

    //         $resultado = UsuarioDao::insert($usuario);

    //         if ($resultado) {

    //             echo json_encode(['estado' => 'Exito']);
    //         } else {

    //             echo json_encode(['estado' => 'Fallido']);
    //         }
    //     } else {
    //         http_response_code(400);
    //         echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
    //     }
    //     break;




    //PUT:



    // case 'PUT':
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     if (isset($data['id_usuario'], $data['nombre'], $data['email'])) {
    //         $usuario = UsuarioDao::getById(intval($data['id_usuario']));
    //         if ($usuario) {
    //             $usuario->setNombre($data['nombre']);
    //             $usuario->setEmail($data['email']);
    //             if (!empty($data['password'])) {
    //                 $usuario->setContraseña(password_hash($data['password'], PASSWORD_BCRYPT));
    //             }
    //             $resultado = UsuarioDao::editar($usuario);
    //             if ($resultado) {
    //                 echo json_encode(['estado' => 'Exito']);
    //             } else {
    //                 echo json_encode(['estado' => 'Fallido']);
    //             }
    //         } else {
    //             http_response_code(404);
    //             echo json_encode(['estado' => 'Fallido', 'data' => 'Usuario no encontrado']);
    //         }
    //     } else {
    //         http_response_code(400);
    //         echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
    //     }
    //     break;










    //DELETE:


    // case 'DELETE':
    //     $data = json_decode(file_get_contents("php://input"), true);

    //     if (isset($data['id_usuario'])) {
    //         $usuario = UsuarioDao::getById(intval($data['id_usuario']));

    //         if ($usuario) {
    //             $resultado = UsuarioDao::eliminar($usuario);

    //             if ($resultado) {
    //                 echo json_encode(['estado' => 'Exito']);
    //             } else {
    //                 echo json_encode(['estado' => 'Fallido']);
    //             }
    //         } else {
    //             http_response_code(404);
    //             echo json_encode(['estado' => 'Fallido', 'data' => 'Usuario no encontrado']);
    //         }
    //     } else {
    //         http_response_code(400);
    //         echo json_encode(['estado' => 'Fallido', 'data' => 'Falta id_usuario']);
    //     }
    //     break;

?>














