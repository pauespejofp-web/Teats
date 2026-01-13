<?php
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrito - Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: system-ui;
            background: #fff;
            color: #111;
        }

        .topbar {
            height: 72px;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
        }

        .cart-item {
            padding: 18px 0;
            border-bottom: 1px solid rgba(0, 0, 0, .04);
        }

        .cart-item img {
            width: 180px;
            height: 110px;
            object-fit: cover;
            border-radius: 6px;
        }

        .item-title {
            font-weight: 600;
            font-size: 1.05rem;
        }

        .item-meta {
            font-size: 0.9rem;
            color: #666;
            margin-top: 6px;
        }

        .qty-controls {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-top: .5rem;
        }

        .qty-controls button {
            width: 34px;
            height: 34px;
            padding: 0;
            border-radius: 6px;
        }

        .remove-link {
            font-size: 0.9rem;
            color: #333;
            text-decoration: underline;
            cursor: pointer;
            margin-left: .5rem;
        }

        .summary-box {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            padding: 18px;
            border-radius: 6px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 24px;
        }

        .summary-box h5 {
            font-weight: 700;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            align-items: center;
        }

        .checkout-btn {
            background: #3e6ae1;
            border: none;
            color: #fff;
            width: 100%;
            padding: 10px 16px;
            border-radius: 6px;
        }
        .checkout-btn:hover {
            background: #3457b1;
            border: none;
            color: #fff;
            width: 100%;
            padding: 10px 16px;
            border-radius: 6px;
        }

        @media (max-width: 991px) {
            .summary-box {
                position: static;
                margin-top: 18px;
            }

            .cart-item img {
                width: 140px;
                height: 90px;
            }
        }
    </style>
</head>

<body>

    <header class="topbar d-flex align-items-center px-3">
        <div class="container d-flex align-items-center">
            <strong class="me-4 fs-4">TIENDA</strong>
            <nav class="nav d-none d-lg-flex">
                <a href="index.php?controller=productos&action=inicio" class="nav-link">Inicio</a>
                <a href="index.php?controller=productos&action=inicio" class="nav-link">Productos</a>
            </nav>
            <div class="ms-auto">
                <a href="index.php?controller=productos&action=inicio" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Volver</a>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row gx-5">
            <div class="col-lg-8">
                <h3 class="mb-4">Carrito</h3>

                <div id="cart-list">
                </div>

                <div id="empty-msg" style="display:none;">
                    <p class="text-muted">Tu carrito está vacío. Añade productos desde la tienda.</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-box">
                    <h5>Resumen del pedido</h5>
                    <div class="summary-row">
                        <div>Envío</div>
                        <div id="shipping">Gratis</div>
                    </div>
                    <div class="summary-row"><strong>Subtotal</strong><strong id="subtotal">0.00€</strong></div>
                    <div class="summary-row"><small class="text-muted">Iva Incluido</small></div>
                    <div style="height:12px"></div>
                    <div class="mb-3">
                        <label for="codigo-descuento" class="form-label">Código de descuento</label>
                        <div class="input-group">
                            <input type="text" id="codigo-descuento" class="form-control" placeholder="Introduce tu código">
                            <button type="button" id="aplicar-descuento" class="btn btn-outline-primary">Aplicar</button>
                        </div>
                        <div id="mensaje-descuento" class="small mt-1 text-success"></div>
                    </div>

                    <form id="checkout-form" action="index.php?controller=pedidos&action=crear" method="POST">
                        <input type="hidden" name="cart_data" id="cart_data">
                        <button id="checkout" class="checkout-btn" type="button">Caja</button>
                    </form>
                    <script>
                        document.getElementById("checkout").addEventListener("click", () => {
                            const cart = JSON.parse(localStorage.getItem("cart")) || {};

                            if (Object.keys(cart).length === 0) {
                                alert("Carrito vacío");
                                return;
                            }

                            // Pasamos el carrito al form
                            document.getElementById("cart_data").value = JSON.stringify(cart);

                            // Enviamos al controller (crear pedido)
                            document.getElementById("checkout-form").submit();
                        });
                    </script>

                </div>
            </div>
        </div>
    </main>

    <script>
        const CART_KEY = "cart";


        function getCart() {
            return JSON.parse(localStorage.getItem(CART_KEY)) || {};
        }

        function saveCart(cart) {
            localStorage.setItem(CART_KEY, JSON.stringify(cart));
            renderCart();
        }

        function renderCart() {
            const cart = getCart();
            const container = document.getElementById("cart-list");
            const empty = document.getElementById("empty-msg");
            const subtotalEl = document.getElementById("subtotal");

            container.innerHTML = "";
            let subtotal = 0;
            const ids = Object.keys(cart);

            if (ids.length === 0) {
                empty.style.display = "block";
                subtotalEl.textContent = "0.00€";
                return;
            }

            empty.style.display = "none";

            ids.forEach(id => {
                const item = cart[id];
                subtotal += item.precio * item.cantidad;

                container.innerHTML += `
            <div class="cart-item row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="${item.imagen}">
                </div>

                <div class="col-md-5">
                    <strong>${item.nombre}</strong>
                    <div class="qty-controls">
                        <button onclick="changeQty(${id}, -1)">-</button>
                        <span>${item.cantidad}</span>
                        <button onclick="changeQty(${id}, 1)">+</button>
                        <a class="remove-link" onclick="removeItem(${id})">Quitar</a>
                    </div>
                </div>

                <div class="col-md-3 text-end">
                    <strong>${item.precio.toFixed(2)} €</strong>
                </div>
            </div>
        `;
            });

            subtotalEl.textContent = subtotal.toFixed(2) + "€";
        }

        function changeQty(id, change) {
            const cart = getCart();
            cart[id].cantidad += change;
            if (cart[id].cantidad < 1) cart[id].cantidad = 1;
            saveCart(cart);
        }

        function removeItem(id) {
            const cart = getCart();
            delete cart[id];
            saveCart(cart);
        }

        document.getElementById("checkout").addEventListener("click", () => {
            const cart = getCart();
            if (Object.keys(cart).length === 0) {
                alert("Carrito vacío");
                return;
            }

            document.getElementById("cart_data").value = JSON.stringify(cart);

            document.getElementById("checkout-form").submit();

            localStorage.removeItem(CART_KEY);
        });

        renderCart();
    </script>

</body>

</html>