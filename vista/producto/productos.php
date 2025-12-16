<?php
// Inicializaciones por defecto para evitar warnings si el controlador no pasó datos.
// Ajusta rutas si tu imagen está en otra carpeta.
if (!isset($hero1)) {
    $hero1 = 'assets/img/hero1.webp';
}
if (!isset($hero1_title)) {
    $hero1_title = 'Tesla Burger';
}
if (!isset($hero2)) {
    $hero2 = 'assets/img/hero2.webp';
}
if (!isset($hero2_title)) {
    $hero2_title = 'Calamares a la Romana';
}

// Clase mínima usada por la vista si no existe
if (!class_exists('SimpleProduct')) {
    class SimpleProduct {
        private $id, $nombre, $precio, $imagen;
        public function __construct($id, $nombre, $precio, $imagen) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->precio = $precio;
            $this->imagen = $imagen;
        }
        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
        public function getPrecio() { return $this->precio; }
        public function getImagen() { return $this->imagen; }
    }
}

// Producto nuevo con id 14 (imagen .webp)
$producto14 = new SimpleProduct(14, 'Steak Especial (ID 14)', 31.50, ' /Modelo-Vista-Controlador/assets/img/prod1.webp');

// Destacados por defecto (asegurar al menos 3)
if (!isset($destacados) || !is_array($destacados) || count($destacados) < 3) {
    $destacados = [
        new SimpleProduct(1, 'Tesla Burger', 8.50, 'assets/img/tesla_burger.webp'),
        $producto14, // reemplazado: el producto con id 14 en la posición de prod1.webp
        new SimpleProduct(3, 'Producto 2', 7.49, 'assets/img/prod2.webp'),
    ];
    // opcional: reemplazar uno por el producto 14 si quieres que aparezca entre los destacados
    // $destacados[1] = $producto14;
}

// Más vendidos por defecto; añadir el producto 14 al inicio para que se muestre
if (!isset($masVendidos) || !is_array($masVendidos) || count($masVendidos) === 0) {
    $masVendidos = [
        $producto14,
        new SimpleProduct(4, 'Filete Tomahawk', 28.00, 'assets/img/tomahawk.webp'),
        new SimpleProduct(5, 'Filete T-Bone', 24.50, 'assets/img/tbone.webp'),
        new SimpleProduct(6, 'Filete Cowboy', 26.00, 'assets/img/cowboy.webp'),
    ];
} else {
    // si ya existe lista, asegúrate de que el producto 14 esté presente (evita duplicados)
    $found = false;
    foreach ($masVendidos as $p) {
        if (method_exists($p, 'getId') && $p->getId() == 14) { $found = true; break; }
    }
    if (!$found) {
        array_unshift($masVendidos, $producto14);
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">




    <style>
        body {
            font-family: system-ui;
            background: #fff;
        }

        .topbar {
            height: 72px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .nav-link {
            color: #111;
        }

        .hero {
            height: 420px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 6px 14px rgba(0, 0, 0, 0.6);
        }

        .cards-row {
            margin-top: 34px;
            margin-bottom: 54px;
            display: flex;
            gap: 28px;
            justify-content: center;
        }

        .product-card {
            width: 280px;
            padding: 18px;
            text-align: center;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.08);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        .highlight {
            border: 4px solid #0d6efd;
        }

        .best-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <header class="topbar d-flex align-items-center px-3">
        <div class="container d-flex align-items-center">
            <strong class="me-4 fs-4">TIENDA</strong>

            <nav class="nav d-none d-lg-flex">
                <a href="#" class="nav-link">Inicio</a>
                <a href="#" class="nav-link">Productos</a>
                <a href="#" class="nav-link">Contacto</a>
            </nav>

            <div class="ms-auto">
                <i class="bi bi-search me-3"></i>
                <i class="bi bi-cart"></i>
            </div>
        </div>
    </header>

    <section class="hero" style="background-image:url('<?= $hero1 ?>');">
        <h2 class="hero-title"><?= $hero1_title ?></h2>
    </section>

    <main class="container">

        <!-- SECCIÓN DESTACADOS -->
        <div class="cards-row">

            <?php foreach ($destacados as $i => $p): ?>
                <div class="product-card <?= $i == 1 ? 'highlight' : '' ?>">
                    <img src="<?= $p->getImagen() ?>" alt="producto">
                    <div class="mt-3"><strong><?= $p->getNombre() ?></strong></div>
                    <div class="text-muted mb-2"><?= number_format($p->getPrecio(), 2) ?>€</div>

                    <a href="index.php?controller=producto&action=ver&id=<?= $p->getId() ?>"
                        class="btn btn-dark">Comprar ahora</a>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- LOS MÁS VENDIDOS -->
        <h3 class="mt-5 mb-3 fw-bold">Los más vendidos</h3>

        <div class="row gx-3">
            <?php foreach ($masVendidos as $p): ?>
                <div class="col-md-4 mb-3">
                    <div class="card best-card">
                        <img src="<?= $p->getImagen() ?>" alt="producto">
                        <div class="caption p-2">
                            <strong><?= $p->getNombre() ?></strong><br>
                            <span class="text-muted"><?= number_format($p->getPrecio(), 2) ?>€</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <!-- HERO SECUNDARIO -->
    <section class="hero" style="background-image:url('<?= $hero2 ?>'); height:350px;">
        <h2 class="hero-title"><?= $hero2_title ?></h2>
    </section>

</body>

</html>