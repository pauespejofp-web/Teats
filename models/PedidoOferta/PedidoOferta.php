<?php

class PedidoOferta {

    private $id_pedido;
    private $id_oferta;

    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;
        return $this;
    }

    public function getIdOferta() {
        return $this->id_oferta;
    }

    public function setIdOferta($id_oferta) {
        $this->id_oferta = $id_oferta;
        return $this;
    }
}

?>
