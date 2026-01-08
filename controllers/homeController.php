<?php


require_once 'models/Producto/ProductoDAO.php';

class HomeController
{
    public function inicio()
    {
        $productos = ProductoDAO::getAll();
        $masVendidos = array_slice($productos, 0, 2);
        $platosPequenos = array_slice($productos, 2, 2);

        require_once 'vista/usuario/home/home.php';
    }
}






?>