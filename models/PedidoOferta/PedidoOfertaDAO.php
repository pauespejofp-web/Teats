<?php
include_once __DIR__ . '/../models/PedidoOferta.php';
include_once __DIR__ . '/../database/database.php';

class PedidoOfertaDao {

    public static function getByPedido($id_pedido) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Pedido_Oferta WHERE id_pedido = ?");
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($po = $result->fetch_object('PedidoOferta')) {
            $lista[] = $po;
        }
        $con->close();
        return $lista;
    }

    public static function insert(PedidoOferta $po) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Pedido_Oferta(id_pedido, id_oferta)
             VALUES (?, ?)"
        );
        $stmt->bind_param(
            "ii",
            $po->getIdPedido(),
            $po->getIdOferta()
        );
        $stmt->execute();
        $con->close();
    }
}
?>
