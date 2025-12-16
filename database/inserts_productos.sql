-- Ajusta la lista de columnas según la estructura real de tu tabla 'producto'.
-- Aquí se asumen columnas: nombre, precio, descripcion, imagen
INSERT INTO producto (nombre, descripcion, precio, categoria_id, imagen_url, disponible) VALUES
('Tesla Burger', 'Hamburguesa clásica con salsa especial Tesla', 8.50, 1, 'assets/img/tesla_burger.webp', 1),
('Producto 1', 'Descripción breve del producto 1', 5.99, NULL, 'assets/img/prod1.webp', 1),
('Producto 2', 'Descripción breve del producto 2', 7.49, NULL, 'assets/img/prod2.webp', 1),
('Producto 3', 'Descripción breve del producto 3', 6.25, NULL, 'assets/img/prod3.webp', 1),
('Filete de carne Tomahawk', 'Filete Tomahawk de 500g, a la parrilla', 28.00, 2, 'assets/img/tomahawk.webp', 1),
('Filete de carne T-Bone', 'T-Bone jugoso, recomendado', 24.50, 2, 'assets/img/tbone.webp', 1),
('Filete de carne Cowboy', 'Corte Cowboy con sabor intenso', 26.00, 2, 'assets/img/cowboy.webp', 1),
('Calamares a la Romana', 'Calamares crujientes, acompañados de limón', 12.00, 3, 'assets/img/calamares.webp', 1),
('Ensalada César', 'Lechuga, pollo, croutons y salsa césar', 7.00, 4, 'assets/img/ensalada_cesar.webp', 1),
('Papas Fritas', 'Papas crujientes con sal', 3.50, 3, 'assets/img/papas.webp', 1),
('Sándwich Veggie', 'Sándwich con vegetales frescos y hummus', 6.75, 4, 'assets/img/veggie.webp', 1),
('Bebida Refrescante', 'Refresco frío 330ml', 2.50, 5, 'assets/img/bebida.webp', 1);
