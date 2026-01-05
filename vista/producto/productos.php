<?php
$hero1 = $hero1 ?? 'assets/img/prod1.webp';
$hero1_title = $hero1_title ?? 'Productos Teats';

$hero2 = $hero2 ?? 'assets/img/tesla_burger.webp';
$hero2_title = $hero2_title ?? 'Calamares a la Romana';

if (!class_exists('SimpleProduct')) {
    class SimpleProduct {
        private $id;
        private $nombre;
        private $precio;
        private $imagen;

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

$productos = [
    new SimpleProduct(1, 'Tesla Burgerr', 13.00, 'assets/img/tesla_burger.webp'),
    new SimpleProduct(2, 'Carne de la casa', 5.99, 'assets/img/carne_de_la_casa.webp'),
    new SimpleProduct(3, 'Producto 2', 7.49, 'assets/img/prod2.webp'),
    new SimpleProduct(4, 'Pescado veggie', 6.25, 'assets/img/pescado_veggie.webp'),
    new SimpleProduct(5, 'Filete de carne Tomahawk', 28.00, 'assets/img/tomahawk.webp'),
    new SimpleProduct(6, 'Filete de carne T-Bone', 24.50, 'assets/img/tbone.webp'),
    new SimpleProduct(7, 'Filete de carne Cowboy', 26.00, 'assets/img/cowboy.webp'),
    new SimpleProduct(8, 'Calamares a la Romana', 12.00, 'assets/img/calamares.webp'),
    new SimpleProduct(10, 'Poke Teats', 12.50, 'assets/img/poke.webp'),
];

$destacados = [
    $productos[8],
    $productos[3],
    $productos[8],


];

$masVendidos = [
    $productos[4],
    $productos[0],
    $productos[7],

];
?>

<?php

function resolve_image($img) {

    if (!$img) return 'https://via.placeholder.com/400x300?text=No+Image';
    if (preg_match('#^(https?:)?//#', $img) || strpos($img, 'data:') === 0) {
        return $img;
    }

    $candidates = [
        __DIR__ . '/' . ltrim($img, '/'),
        realpath(__DIR__ . '/../../') . '/' . ltrim($img, '/'),
        $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($img, '/'),
    ];

    foreach ($candidates as $path) {
        if ($path && file_exists($path)) {
            $real = realpath($path);
            $docroot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
            if ($docroot && strpos($real, $docroot) === 0) {
                $web = '/' . ltrim(str_replace('\\', '/', substr($real, strlen($docroot))), '/');
                return $web;
            }
            return $img;
        }
    }

    // fallback externo
    return 'https://via.placeholder.com/400x300?text=No+Image';
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
        body { font-family: system-ui; background: #fff; }
        .topbar { height: 72px; border-bottom: 1px solid rgba(0,0,0,.06); }
        .nav-link { color: #111; }
        .hero {
            height: 870px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 6px 14px rgba(0,0,0,.6);
        }
        .cards-row {
            margin: 34px 0 54px;
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
            box-shadow: 0 8px 26px rgba(0,0,0,.08);
        }
        .product-card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 4px;
            
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

<section class="hero" style="background-image:url('<?= resolve_image($hero1) ?>');">
    <h2 class="hero-title"><?= $hero1_title ?></h2>
</section>

<main class="container-fluid px-5">


    <!-- DESTACADOS -->
    

    <h3 class="mt-5 mb-3 fw-bold">Los más vendidos</h3>
    <div class="row gx-3">
    <?php foreach ($masVendidos as $p): ?>
        <div class="col-6 col-md-3 mb-3">
            <div class="card best-card h-100">
                <img src="<?= resolve_image($p->getImagen()) ?>"    
                     class="img-fluid" 
                     alt="<?= $p->getNombre() ?>">
                <div class="caption p-2 text-center">
                    <strong><?= $p->getNombre() ?></strong><br>
                    <span class="text-muted">
                        <?= number_format($p->getPrecio(), 2) ?>€
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>




    <h3 class="mt-5 mb-3 fw-bold">Todos los productos</h3>
    <div class="row gx-4">
        <?php foreach ($productos as $p): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="<?= resolve_image($p->getImagen()) ?>" class="card-img-top" alt="<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-1"><?= htmlspecialchars($p->getNombre()) ?></h6>
                        <p class="text-muted mb-2"><?= number_format($p->getPrecio(), 2) ?>€</p>
                        <a href="#" class="btn btn-sm btn-primary mt-auto">Ver / Comprar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="cards-row">
        <?php foreach ($destacados as $i => $p): ?>
            <div class="product-card <?= $i === 1 ? 'highlight' : '' ?>">
                <img src="<?= resolve_image($p->getImagen()) ?>" alt="<?= $p->getNombre() ?>">
                <div class="mt-3"><strong><?= $p->getNombre() ?></strong></div>
                <div class="text-muted mb-2"><?= number_format($p->getPrecio(), 2) ?>€</div>
                <a href="#" class="btn btn-dark">Comprar ahora</a>
            </div>
        <?php endforeach; ?>
    </div>

</main>


</body>
</html>
