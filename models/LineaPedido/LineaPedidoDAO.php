<?php
include_once __DIR__ . '/LineaPedido.php';
include_once __DIR__ . '/../../database/database.php';

class LineaPedidoDao {

    public static function insert(LineaPedido $linea) {
        $con = DataBase::connect();

        $stmt = $con->prepare(
            "INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?)"
        );
        $idPedido  = $linea->getIdPedido();
        $idProducto = $linea->getIdProducto();
        $cantidad  = $linea->getCantidad();
        $precio    = $linea->getPrecioUnitario();

        $stmt->bind_param("iiid", $idPedido, $idProducto, $cantidad, $precio);

        $stmt->execute();
        $inserted = $stmt->affected_rows > 0;

        $stmt->close();
        $con->close();

        return $inserted;
    }
}
?>
