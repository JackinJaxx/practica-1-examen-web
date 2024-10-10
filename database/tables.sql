-- --------------------------------------------------------
-- Tabla: `productos`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `productos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `precio` DECIMAL(10, 2) NOT NULL, -- Usamos DECIMAL para manejar dinero de forma precisa
  `stock` INT(11) NOT NULL, -- Cambiamos `Ext` a `stock` para ser más semántico
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabla: `usuarios`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(50) NOT NULL, -- Ampliamos el tamaño y usamos un nombre más claro,
    `nombre_completo` VARCHAR(100) NOT NULL, -- Agregamos un campo para el nombre completo
  `password` VARCHAR(255) NOT NULL, -- Aumentamos el tamaño de la contraseña para futuras hash (bcrypt)
  `nivel_usuario` TINYINT(1) NOT NULL, -- Usamos TINYINT para representar el nivel de usuario
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;