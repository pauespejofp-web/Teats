<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; }
        .topbar { height: 72px; border-bottom: 1px solid rgba(0,0,0,.06); }
        .hero { height: 870px; background-size: cover; background-position: center; display:flex; align-items:center; justify-content:center; }
        .hero-title { font-size:2.2rem; font-weight:800; color:#fff; text-shadow:0 6px 14px rgba(0,0,0,.6); }
        .best-image { width:100%; height:260px; object-fit:cover; }
        .card-product img { height:180px; object-fit:cover; }
    </style>
</head>
<body>

<header class="topbar d-flex align-items-center">
    <div class="container d-flex align-items-center">
        <strong class="fs-4 me-4">TIENDA</strong>

        <nav class="nav d-none d-lg-flex">
            <a href="index.php" class="nav-link">Inicio</a>
            <a href="index.php?controller=productos&action=inicio" class="nav-link">Productos</a>
        </nav>

        <div class="ms-auto">
<a href="index.php?controller=carrito&action=ver" class="position-relative">
    <img src="/Modelo-Vista-Controlador/assets/sga/carrito.svg" width="36" alt="Carrito">
    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none">0</span>
</a>
</div>
    </div>
</header>

<section class="hero" style="background-image:url('/Modelo-Vista-Controlador/assets/img/prod1.webp')">
    <h1 class="hero-title">Productos Teats</h1>
</section>

<main class="container py-5">

    <h3 class="fw-bold mb-4">Productos más vendidos</h3>
    <div class="row g-4">
        <?php foreach ($masVendidos as $p): ?>
            <div class="col-12 col-md-4">
                <div class="card h-100">
                    <img src="/Modelo-Vista-Controlador/<?= $p->getImagenUrl() ?>" class="best-image" alt="<?= htmlspecialchars($p->getNombre()) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5><?= htmlspecialchars($p->getNombre()) ?></h5>
                        <p class="fw-semibold text-muted"><?= number_format($p->getPrecio(), 2) ?> €</p>
                        <p class="small text-muted"><?= htmlspecialchars($p->getDescripcion()) ?></p>

                        <button class="btn btn-dark mt-auto add-to-cart"
                                data-id="<?= $p->getIdProducto() ?>"
                                data-name="<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>"
                                data-price="<?= $p->getPrecio() ?>"
                                data-img="/Modelo-Vista-Controlador/<?= $p->getImagenUrl() ?>">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3 class="fw-bold mt-5 mb-4">Todos los productos</h3>
    <div class="row g-4">
        <?php foreach ($productos as $p): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-product h-100">
                    <img src="/Modelo-Vista-Controlador/<?= $p->getImagenUrl() ?>" alt="<?= htmlspecialchars($p->getNombre()) ?>">
                    <div class="card-body d-flex flex-column">
                        <h6><?= htmlspecialchars($p->getNombre()) ?></h6>
                        <p class="fw-semibold text-muted"><?= number_format($p->getPrecio(), 2) ?> €</p>

                        <button class="btn btn-primary mt-auto add-to-cart"
                                data-id="<?= $p->getIdProducto() ?>"
                                data-name="<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>"
                                data-price="<?= $p->getPrecio() ?>"
                                data-img="/Modelo-Vista-Controlador/<?= $p->getImagenUrl() ?>">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<script>
const CART_KEY = "cart";

function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || {};
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateBadge();
}

function updateBadge() {
    const cart = getCart();
    let total = Object.values(cart).reduce((s, p) => s + p.cantidad, 0);
    const badge = document.getElementById("cart-count");
    badge.style.display = total > 0 ? "inline-block" : "none";
    badge.textContent = total;
}

document.querySelectorAll(".add-to-cart").forEach(btn => {
    btn.addEventListener("click", () => {
        const cart = getCart();
        const id = btn.dataset.id;

        cart[id] ??= {
            id,
            nombre: btn.dataset.name,
            precio: Number(btn.dataset.price),
            imagen: btn.dataset.img,
            cantidad: 0
        };
        cart[id].cantidad++;

        saveCart(cart);
    });
});

updateBadge();
</script>

</body>
</html>
