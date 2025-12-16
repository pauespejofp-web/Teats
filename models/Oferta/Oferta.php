<?php

class Oferta {

    private $id_oferta;
    private $nombre;
    private $descripcion;
    private $descuento_porcentaje;
    private $fecha_inicio;
    private $fecha_fin;
    private $activo;

    public function getIdOferta() {
        return $this->id_oferta;
    }

    public function setIdOferta($id_oferta) {
        $this->id_oferta = $id_oferta;
        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getDescuentoPorcentaje() {
        return $this->descuento_porcentaje;
    }

    public function setDescuentoPorcentaje($descuento_porcentaje) {
        $this->descuento_porcentaje = $descuento_porcentaje;
        return $this;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
        return $this;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
        return $this;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
        return $this;
    }
}

?>
