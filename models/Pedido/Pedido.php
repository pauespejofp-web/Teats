<?php

class Pedido {

    private $id_pedido;
    private $id_usuario;
    private $fecha_pedido;
    private $hora_pedido;
    private $importe;
    private $estado;

    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;
        return $this;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
        return $this;
    }

    public function getFechaPedido() {
        return $this->fecha_pedido;
    }

    public function setFechaPedido($fecha_pedido) {
        $this->fecha_pedido = $fecha_pedido;
        return $this;
    }

    public function getHoraPedido() {
        return $this->hora_pedido;
    }

    public function setHoraPedido($hora_pedido) {
        $this->hora_pedido = $hora_pedido;
        return $this;
    }

    public function getImporte() {
        return $this->importe;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
        return $this;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }
}

?>
