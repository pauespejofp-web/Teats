<?php

class Producto {

    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoria_id;
    private $imagen_url;
    private $disponible;

    /**
     * Get the value of id_producto
     */ 
    public function getIdProducto() {
        return $this->id_producto;
    }

    /**
     * Set the value of id_producto
     *
     * @return  self
     */ 
    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio) {
        $this->precio = $precio;
        return $this;
    }

    /**
     * Get the value of categoria_id
     */ 
    public function getCategoriaId() {
        return $this->categoria_id;
    }

    /**
     * Set the value of categoria_id
     *
     * @return  self
     */ 
    public function setCategoriaId($categoria_id) {
        $this->categoria_id = $categoria_id;
        return $this;
    }

    /**
     * Get the value of imagen_url
     */ 
    public function getImagenUrl() {
        return $this->imagen_url;
    }

    /**
     * Set the value of imagen_url
     *
     * @return  self
     */ 
    public function setImagenUrl($imagen_url) {
        $this->imagen_url = $imagen_url;
        return $this;
    }

    /**
     * Get the value of disponible
     */ 
    public function getDisponible() {
        return $this->disponible;
    }

    /**
     * Set the value of disponible
     *
     * @return  self
     */ 
    public function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }
}

?>
