<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tesla Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* layout and visual polish to match reference */
        body { background:#f4f6f8; color:#0f1724; font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
        .hero-wrap { display:flex; gap:1rem; align-items:stretch; }
        .hero-card { flex:1; border-radius:12px; overflow:hidden; background:#fff; box-shadow:0 12px 40px rgba(2,6,23,.08); position:relative; min-height:220px; display:flex; }
        .hero-media { flex:1 1 60%; min-height:260px; background-size:cover; background-position:center; }
        .hero-body { flex:1 1 40%; padding:1.6rem; display:flex; flex-direction:column; justify-content:center; }
        .hero-body h3{ font-size:1.45rem; margin-bottom:.25rem; color:#061025; font-weight:800;}
        .hero-body p{ margin-bottom:.85rem; color:#6b7280; }
        .hero-actions .btn{ margin-right:.5rem; }
        .small-card { background:#fff; border-radius:12px; padding:1.15rem; box-shadow:0 8px 24px rgba(2,6,23,.04); display:flex; align-items:center; gap:1rem; }
        .small-card .media { width:86px; height:86px; border-radius:8px; background-size:cover; background-position:center; flex-shrink:0; box-shadow:inset 0 1px 0 rgba(255,255,255,.4); }
        .small-card h5{ margin:0; font-weight:700; }
        .small-card p{ margin:0; color:#6b7280; font-size:.9rem; }
        .map-block { border-radius:12px; overflow:hidden; box-shadow:0 12px 40px rgba(2,6,23,.06); background:#fff; position:relative; }
        .map-img{ width:100%; height:340px; object-fit:cover; display:block; filter:grayscale(.02); }
        .map-overlay { position:absolute; left:28px; bottom:28px; z-index:3; background:rgba(255,255,255,0.9); padding:1rem 1.25rem; border-radius:10px; box-shadow:0 8px 20px rgba(2,6,23,.06); }
        .map-stats { display:flex; gap:1.5rem; align-items:center; margin-left:1rem; }
        .stat { display:flex; gap:.5rem; align-items:center; }
        .stat strong{ font-size:1.25rem; color:#0b5ed7; }
        @media (max-width:991px){
            .hero-wrap { flex-direction:column; }
            .hero-media{ min-height:180px; }
            .hero-body{ padding:1rem; }
            .map-overlay{ left:16px; right:16px; bottom:16px; }
        }
    </style>
</head>

<body>

    <?php include "assets/navbar.php"; ?>

    <div class="home-background">
        <div class="container text-center">
            <h1 class="text-center">Bienvenido a Tesla Restaurant</h1>
            <p class="text-center text-muted">Innovación y gastronomía eléctrica</p>
        </div>
    </div>

    <?php
    include_once __DIR__ . '/../../../models/Producto/ProductoDAO.php';

    $productos = ProductoDAO::getAll() ?: [];
    $destacados = !empty($productos) ? array_slice($productos, 0, 3) : [];
    $masVendidos = !empty($productos) ? array_slice($productos, 3, 6) : [];

    function resolve_image($obj_img) {
        if (!$obj_img) return 'https://via.placeholder.com/1200x800?text=No+Image';
        $img = is_string($obj_img) ? $obj_img : (is_object($obj_img) ? (property_exists($obj_img,'imagen_url') ? $obj_img->imagen_url : (method_exists($obj_img,'getImagenUrl') ? $obj_img->getImagenUrl() : null)) : null);
        if (!$img) return 'https://via.placeholder.com/1200x800?text=No+Image';
        if (preg_match('#^(https?:)?//#', $img) || strpos($img, 'data:') === 0) return $img;
        $candidates = [
            __DIR__ . '/' . ltrim($img, '/'),
            realpath(__DIR__ . '/../../../../') . '/' . ltrim($img, '/'),
            $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($img, '/'),
        ];
        foreach ($candidates as $path) {
            if ($path && file_exists($path)) {
                $real = realpath($path);
                $docroot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
                if ($docroot && strpos($real, $docroot) === 0) {
                    return '/' . ltrim(str_replace('\\', '/', substr($real, strlen($docroot))), '/');
                }
                return $img;
            }
        }
        return $img;
    }
    ?>

    <main class="container py-4">

        <section class="mb-4">
            <?php if (!empty($destacados)): ?>
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($destacados as $i => $d):
                            $img = resolve_image(method_exists($d,'getImagenUrl') ? $d->getImagenUrl() : (method_exists($d,'getImagen') ? $d->getImagen() : null));
                            $name = htmlspecialchars(method_exists($d,'getNombre') ? $d->getNombre() : ($d->nombre ?? 'Producto'));
                            $desc = htmlspecialchars(method_exists($d,'getDescripcion') ? $d->getDescripcion() : ($d->descripcion ?? 'Delicioso'));
                            $price = number_format(method_exists($d,'getPrecio') ? $d->getPrecio() : ($d->precio ?? 0), 2) . '€';
                        ?>
                            <div class="carousel-item <?= $i===0 ? 'active' : '' ?>">
                                <div class="hero-wrap">
                                    <div class="hero-card">
                                        <div class="hero-media" style="background-image:url('<?= $img ?>')"></div>
                                        <div class="hero-body">
                                            <h3><?= $name ?></h3>
                                            <p class="mb-2"><?= $desc ?></p>
                                            <div class="mb-3 fw-semibold"><?= $price ?></div>
                                            <div class="hero-actions">
                                                <a href="#" class="btn btn-primary btn-sm">Pedir ahora</a>
                                                <button class="btn btn-outline-primary btn-sm add-to-cart"
                                                        data-id="<?= method_exists($d,'getId') ? $d->getId() : ($d->id ?? 0) ?>"
                                                        data-name="<?= $name ?>"
                                                        data-price="<?= (method_exists($d,'getPrecio') ? $d->getPrecio() : ($d->precio ?? 0)) ?>"
                                                        data-img="<?= $img ?>">Añadir al carrito</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-4">No hay artículos destacados.</div>
            <?php endif; ?>
        </section>

        <!-- DOS TARJETAS HORIZONTALES (estilo referencia) -->
        <section class="mb-4">
            <div class="row g-4">
                <?php
                // Show two items (if available) in the special small-card layout
                $two = array_slice($productos, 0, 2);
                foreach ($two as $item):
                    $img = resolve_image(method_exists($item,'getImagenUrl') ? $item->getImagenUrl() : (method_exists($item,'getImagen') ? $item->getImagen() : null));
                    $name = htmlspecialchars(method_exists($item,'getNombre') ? $item->getNombre() : ($item->nombre ?? 'Producto'));
                    $desc = htmlspecialchars(method_exists($item,'getDescripcion') ? $item->getDescripcion() : ($item->descripcion ?? 'Pequeña descripción.'));
                ?>
                    <div class="col-12 col-md-6">
                        <div class="small-card">
                            <div>
                                <h5><?= $name ?></h5>
                                <p class="mb-3"><?= $desc ?></p>
                                <button class="btn btn-outline-primary btn-sm">Añadir al carrito</button>
                            </div>
                            <div class="ms-auto media" style="background-image:url('<?= $img ?>')"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- MAPA ESTÁTICO CON OVERLAY -->
        <section class="mb-5">
            <div class="map-block">
                <img src="<?= resolve_image('assets/img/map_placeholder.png') ?>" alt="Mapa" class="map-img">
                <div class="map-overlay d-flex align-items-center">
                    <div>
                        <h5 class="mb-1">Find Your Restaurant</h5>
                        <small class="text-muted">View the network of Tesla Superchargers and Destination Chargers available near you.</small>
                        <div class="mt-3 d-flex gap-2">
                            <a href="#" class="btn btn-dark btn-sm">Find Restaurant</a>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Learn More</a>
                        </div>
                    </div>
                    <div class="ms-4 map-stats">
                        <div class="stat">
                            <strong>130</strong>
                            <div class="text-muted small">Locales</div>
                        </div>
                        <div class="stat">
                            <strong>40</strong>
                            <div class="text-muted small">Cargadores</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    // ...existing cart JS kept (minimal)...
    ?>
    <script>
    // carrito simple en localStorage (compatibilidad con botones añadidos)
    const CART_KEY = 'cart_home_v1';
    function getCart(){ return JSON.parse(localStorage.getItem(CART_KEY)) || {}; }
    function saveCart(c){ localStorage.setItem(CART_KEY, JSON.stringify(c)); updateBadge(); }
    function updateBadge(){
        const cart = getCart(); let total=0;
        for (let k in cart) total += cart[k].cantidad || 0;
        const badge = document.getElementById('cart-count');
        if (!badge) return;
        if (total>0){ badge.style.display='inline-block'; badge.textContent = total; } else badge.style.display='none';
    }
    function addToCart(id,nombre,precio,imagen){
        const cart = getCart();
        if (cart[id]) cart[id].cantidad++;
        else cart[id] = { id, nombre, precio, imagen, cantidad:1 };
        saveCart(cart);
    }
    document.addEventListener('click', function(e){
        const t = e.target;
        if (t && t.classList.contains('add-to-cart')){
            addToCart(t.dataset.id, t.dataset.name, Number(t.dataset.price), t.dataset.img);
            t.classList.add('btn-success');
            setTimeout(()=>t.classList.remove('btn-success'), 300);
        }
    });
    updateBadge();
    </script>

</body>

</html>