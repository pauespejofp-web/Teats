# TEATS - Web MVC (PHP)

Resumen breve
- Aplicación web PHP con arquitectura MVC ligera, APIs y panel administrativo.
- Archivos principales: [index.php](index.php), controladores en [controllers/](controllers/), modelos en [models/](models/) y vistas en [vista/](vista/).

Requisitos
- PHP 7.4+ con ext-mysqli
- Servidor local (XAMPP, MAMP)
- Base de datos MySQL (configurar en [database/database.php](database/database.php))

Instalación rápida
1. Clona o copia el proyecto en tu servidor local (htdocs/www).
2. Crea la base de datos y tablas (usa los SQL de [database/inserts_productos.sql](database/inserts_productos.sql) si procede).
3. Ajusta credenciales en [database/database.php](database/database.php).
4. Accede a: http://localhost/Modelo-Vista-Controlador/index.php

Estructura principal (resumen)
- Punto de entrada: [index.php](index.php)
- Controladores: [controllers/usuarioController.php](controllers/usuarioController.php), [controllers/productosController.php](controllers/productosController.php), [controllers/pedidosController.php](controllers/pedidosController.php), [controllers/ofertaController.php](controllers/ofertaController.php), [controllers/carritoController.php](controllers/carritoController.php)
- Modelos: [models/Usuario/Usuario.php](models/Usuario/Usuario.php) (ver [`Usuario::setcontraseña`](models/Usuario/Usuario.php), [`Usuario::getcontraseña`](models/Usuario/Usuario.php)), [models/Usuario/UsuarioDAO.php](models/Usuario/UsuarioDAO.php), [models/Producto/Producto.php](models/Producto/Producto.php), [models/Producto/ProductoDAO.php](models/Producto/ProductoDAO.php), [models/Oferta/OfertaDAO.php](models/Oferta/OfertaDAO.php)
- Vistas: [vista/usuario/registrar.php](vista/usuario/registrar.php), [vista/usuario/login.php](vista/usuario/login.php), [vista/admin/Panel_administracion/panel_administracion.php](vista/admin/Panel_administracion/panel_administracion.php), páginas de producto en [vista/producto/](vista/producto/)
- APIs públicas: [api/api.php](api/api.php), [api/apiProductos.php](api/apiProductos.php), [api/apiPedidos.php](api/apiPedidos.php)
- Cliente API (panel): [api/public/api.html](api/public/apihtml.html) y script [api/public/api.js](api/public/api.js)

Rutas y comportamiento básico
- Front: index.php enruta por query params ?controller=...&action=...
- Registro/login de usuarios: formularios en [vista/usuario/registrar.php](vista/usuario/registrar.php) y [vista/usuario/login.php](vista/usuario/login.php) → controlados por [`UsuarioController`](controllers/usuarioController.php)
- Gestión productos/ofertas/pedidos: controladores y DAOs correspondientes (`ProductosController`, `OfertaController`, `PedidoDAO`)

API y panel administrativo
- API REST básico: [api/api.php](api/api.php) (usuarios), [api/apiProductos.php](api/apiProductos.php) (productos), [api/apiPedidos.php](api/apiPedidos.php)
- Panel cliente para administrar vía API: [api/public/apihtml.html](api/public/apihtml.html) + [api/public/api.js](api/public/api.js)

Puntos de atención / notas rápidas
- Verifica nombres de campos en formularios vs. controladores (p. ej. `name="contraseña"` en [vista/usuario/registrar.php](vista/usuario/registrar.php) y controladores/DAO que usan `contraseña`).
- Conexión DB en [database/database.php](database/database.php) — ajustar usuario/contraseña/db.
- Uso de password_hash / password_verify en [`Usuario::setcontraseña`](models/Usuario/Usuario.php) y en login en [controllers/usuarioController.php](controllers/usuarioController.php).
- Para cargar imágenes relativas desde panel API se usa ruta en [api/public/api.js](api/public/api.js) al mostrar `imagen_url`.

Cómo desarrollar / probar
- Arranca servidor (XAMPP) y abre [index.php](index.php).
- Panel admin/API accesible si usuario con rol admin inicia sesión y pulsa "Admin API" (navbar en [assets/navbar.php](assets/navbar.php)).
- Para depuración activa display_errors en [vista/usuario/registrar.php](vista/usuario/registrar.php) u otros scripts según necesites.

Archivos relevantes (apertura rápida)
- [index.php](index.php)
- [`UsuarioController`](controllers/usuarioController.php)
- [controllers/productosController.php](controllers/productosController.php)
- [controllers/pedidosController.php](controllers/pedidosController.php)
- [controllers/ofertaController.php](controllers/ofertaController.php)
- [models/Usuario/Usuario.php](models/Usuario/Usuario.php)
- [models/Usuario/UsuarioDAO.php](models/Usuario/UsuarioDAO.php)
- [models/Producto/Producto.php](models/Producto/Producto.php)
- [models/Producto/ProductoDAO.php](models/Producto/ProductoDAO.php)
- [api/api.php](api/api.php)
- [api/apiProductos.php](api/apiProductos.php)
- [api/apiPedidos.php](api/apiPedidos.php)
- [api/public/apihtml.html](api/public/apihtml.html)
- [api/public/api.js](api/public/api.js)
- [database/database.php](database/database.php)

Contacto rápido
- Revisa primero los controladores y formularios si falta algún campo o hay nombres distintos (ej. `password` vs `contraseña`).
