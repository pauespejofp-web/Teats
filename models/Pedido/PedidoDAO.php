<?php
include_once __DIR__ . '/../models/Pedido.php';
include_once __DIR__ . '/../database/database.php';

class PedidoDao {

    public static function getById($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Pedido WHERE id_pedido = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_object('Pedido');
        $con->close();
        return $pedido;
    }

    public static function getAll() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM Pedido");
        $stmt->execute();
        $result = $stmt->get_result();
        $lista = [];
        while ($p = $result->fetch_object('Pedido')) {
            $lista[] = $p;
        }
        $con->close();
        return $lista;
    }

    public static function insert(Pedido $p) {
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "INSERT INTO Pedido(id_usuario, fecha_pedido, hora_pedido, importe, estado)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "issds",
            $p->getIdUsuario(),
            $p->getFechaPedido(),
            $p->getHoraPedido(),
            $p->getImporte(),
            $p->getEstado()
        );
        $stmt->execute();
        $con->close();
    }
}
?>
