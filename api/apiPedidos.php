<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../models/Pedido/Pedido.php';
include_once __DIR__ . '/../models/Pedido/PedidoDAO.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        if (isset($_GET['id'])) {
            $pedido = PedidoDao::getById(intval($_GET['id']));
            if ($pedido) {
                $data = [
                    'id_pedido' => $pedido->getIdPedido(),
                    'id_usuario' => $pedido->getIdUsuario(),
                    'fecha_pedido' => $pedido->getFechaPedido(),
                    'hora_pedido' => $pedido->getHoraPedido(),
                    'importe' => $pedido->getImporte(),
                    'estado' => $pedido->getEstado()
                ];
                echo json_encode(['estado' => 'Exito', 'data' => $data]);
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Pedido no encontrado']);
            }
        } else {
            $pedidos = PedidoDao::getAll();
            $lista = [];
            foreach ($pedidos as $p) {
                $lista[] = [
                    'id_pedido' => $p->getIdPedido(),
                    'id_usuario' => $p->getIdUsuario(),
                    'fecha_pedido' => $p->getFechaPedido(),
                    'hora_pedido' => $p->getHoraPedido(),
                    'importe' => $p->getImporte(),
                    'estado' => $p->getEstado()
                ];
            }
            echo json_encode(['estado' => 'Exito', 'data' => $lista]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id_usuario'], $data['fecha_pedido'], $data['hora_pedido'], $data['importe'], $data['estado'])) {
            $pedido = new Pedido();
            $pedido->setIdUsuario(intval($data['id_usuario']));
            $pedido->setFechaPedido($data['fecha_pedido']);
            $pedido->setHoraPedido($data['hora_pedido']);
            $pedido->setImporte(floatval($data['importe']));
            $pedido->setEstado($data['estado']);

            $resultado = PedidoDao::insert($pedido);

            if ($resultado) {
                echo json_encode(['estado' => 'Exito']);
            } else {
                echo json_encode(['estado' => 'Fallido']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id_pedido'], $data['id_usuario'], $data['fecha_pedido'], $data['hora_pedido'], $data['importe'], $data['estado'])) {
            $pedido = PedidoDao::getById(intval($data['id_pedido']));
            if ($pedido) {
                $pedido->setIdUsuario(intval($data['id_usuario']));
                $pedido->setFechaPedido($data['fecha_pedido']);
                $pedido->setHoraPedido($data['hora_pedido']);
                $pedido->setImporte(floatval($data['importe']));
                $pedido->setEstado($data['estado']);

                $resultado = PedidoDao::editarPedido($pedido);
                if ($resultado) {
                    echo json_encode(['estado' => 'Exito']);
                } else {
                    echo json_encode(['estado' => 'Fallido']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Pedido no encontrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Faltan datos']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id_pedido'])) {
            $pedido = PedidoDao::getById(intval($data['id_pedido']));
            if ($pedido) {
                $resultado = PedidoDao::eliminarPedido($pedido);
                if ($resultado) {
                    echo json_encode(['estado' => 'Exito']);
                } else {
                    echo json_encode(['estado' => 'Fallido']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['estado' => 'Fallido', 'data' => 'Pedido no encontrado']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['estado' => 'Fallido', 'data' => 'Falta id_pedido']);
        }
        break;
}
?>
