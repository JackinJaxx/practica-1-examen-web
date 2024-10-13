
INSERT INTO `productos` (`id`, `nombre`, `precio`, `stock`) VALUES
(1, 'TV UltraHD 52 pulgadas', 12500.00, 4),
(2, 'Impresora Láser Color', 5200.00, 3);

-- --------------------------------------------------------
-- Inserciones para la tabla `usuarios`
-- --------------------------------------------------------

-- Se recomienda almacenar las contraseñas encriptadas (usaremos bcrypt más adelante)
INSERT INTO `usuarios` (`id`, `nombre_usuario`,`nombre_completo`, `password`, `nivel_usuario`) VALUES
(1, 'jefeventas', 'Juan Perez', '123456', 1),
(2, 'vendedor1', 'Maria Lopez', '123456', 2),
(3, 'vendedor2', 'Pedro Ramirez','123456', 2);