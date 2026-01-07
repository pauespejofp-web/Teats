<?php
require_once 'models/pedido/Pedido.php';
require_once 'models/pedido/pedidoDao.php';
require_once 'models/lineapedido/LineaPedido.php';
require_once 'models/lineapedido/LineaPedidoDAO.php';

class PedidosController {
    public function crear() {
        // Recibir carrito desde POST
        $cart = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

        if (count($cart) === 0) {
            $_SESSION['error'] = "Carrito vacío";
            header("Location: index.php?controller=carrito&action=ver");
            exit;
        }

        $idUsuario = $_SESSION['user_id'] ?? 34;

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $importe = 0;
        foreach ($cart as $item) {
            $importe += $item['precio'] * $item['cantidad'];
        }

        // Crear Pedido
        $pedido = new Pedido();
        $pedido->setIdUsuario($idUsuario)
               ->setFechaPedido($fecha)
               ->setHoraPedido($hora)
               ->setImporte($importe)
               ->setEstado('pendiente');

        if (!PedidoDao::insert($pedido)) {
            $_SESSION['error'] = "Error al crear el pedido";
            header("Location: index.php?controller=carrito&action=ver");
            exit;
        }

        $idPedido = $pedido->getIdPedido();

        // Insertar líneas del pedido
        foreach ($cart as $idProducto => $item) {
            $linea = new LineaPedido();
            $linea->setIdPedido($idPedido)
                   ->setIdProducto($idProducto)
                   ->setCantidad($item['cantidad'])
                   ->setPrecioUnitario($item['precio']);

            LineaPedidoDao::insert($linea);
        }

        // Redirigir a página de confirmación
        header("Location: index.php?controller=pedidos&action=confirmacion&id=".$idPedido);
        exit;
    }

    public function confirmacion() {
        $idPedido = $_GET['id'] ?? null;
        if (!$idPedido) {
            echo "Pedido no encontrado";
            exit;
        }
        echo "<h2>✅ Pedido $idPedido creado con éxito</h2>";
        echo "<a href='index.php?controller=productos&action=inicio'>Volver a la tienda</a>";
    }
}
?>
