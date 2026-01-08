<?php
require_once 'models/Pedido/Pedido.php';
require_once 'models/Pedido/PedidoDAO.php';
require_once 'models/LineaPedido/LineaPedido.php';
require_once 'models/LineaPedido/LineaPedidoDAO.php';

class PedidosController {
    public function crear() {
        $cart = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

        if (count($cart) === 0) {
            $_SESSION['error'] = "Carrito vacío";
            header("Location: index.php?controller=carrito&action=ver");
            exit;
        }

        $idUsuario = $_SESSION['user_id'] ?? null;

        if (!$idUsuario) {
            header("Location: index.php?controller=usuario&action=loginForm");
            exit;
        }

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $importe = 0;
        foreach ($cart as $item) {
            $importe += $item['precio'] * $item['cantidad'];
        }
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
        foreach ($cart as $idProducto => $item) {
            $linea = new LineaPedido();
            $linea->setIdPedido($idPedido)
                   ->setIdProducto($idProducto)
                   ->setCantidad($item['cantidad'])
                   ->setPrecioUnitario($item['precio']);

            LineaPedidoDao::insert($linea);
        }

        header("Location: index.php?controller=pedidos&action=confirmacion&id=".$idPedido);
        exit;
    }

public function confirmacion() {
    $idPedido = $_GET['id'] ?? null;

    if (!$idPedido) {
        echo "Pedido no encontrado";
        exit;
    }
    ?>
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Pedido creado</title>
        <style>
            body {
                font-family: system-ui;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .box {
                text-align: center;
            }
            h1 {
                font-weight: 600;
                margin-bottom: 10px;
            }
            p {
                color: #666;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 18px;
                border: 1px solid #000;
                text-decoration: none;
                color: #000;
            }
            a:hover {
                background: #000;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="box">
            <h1>Pedido creado correctamente</h1>
            <p>ID del pedido: <strong>#<?= $idPedido ?></strong></p>
            <a href="index.php?controller=productos&action=inicio">Volver al inicio</a>
        </div>
    </body>
    </html>
    <?php
}

}
?>
