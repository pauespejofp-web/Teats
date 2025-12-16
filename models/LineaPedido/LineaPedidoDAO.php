<?php
include_once __DIR__ . '/../models/LineaPedido.php';
include_once __DIR__ . '/../database/database.php';

class LineaPedidoDao {

    public static function getByPedido($id_pedido) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Linea_Pedido WHERE id_pedido = ?");
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($l = $result->fetch_object('LineaPedido')) {
            $lista[] = $l;
        }
        $con->close();
        return $lista;
    }

    public static function insert(LineaPedido $lp) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Linea_Pedido(id_pedido, id_producto, cantidad, precio_unitario)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "iiid",
            $lp->getIdPedido(),
            $lp->getIdProducto(),
            $lp->getCantidad(),
            $lp->getPrecioUnitario()
        );
        $stmt->execute();
        $con->close();
    }
}
?>
