-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2022 a las 21:08:45
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `compras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idPo` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idSupplier` int(11) NOT NULL,
  `divisa` varchar(4) DEFAULT NULL,
  `IVA` varchar(2) DEFAULT NULL,
  `fechaPo` date DEFAULT NULL,
  `cotización` varchar(100) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `motivo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idInvoice` int(11) NOT NULL,
  `factura` varchar(100) DEFAULT NULL,
  `fechaFacturación` date DEFAULT NULL,
  `xml` varchar(100) DEFAULT NULL,
  `idPO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPago` int(11) NOT NULL,
  `idFactura` int(11) DEFAULT NULL,
  `comprobante` varchar(100) DEFAULT NULL,
  `idPO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idPro` int(11) NOT NULL,
  `idPO` int(11) DEFAULT NULL,
  `itemNumber` varchar(20) DEFAULT NULL,
  `description1` varchar(50) DEFAULT NULL,
  `description2` varchar(50) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `UOM` varchar(2) DEFAULT NULL,
  `unitCost` decimal(9,4) DEFAULT NULL,
  `extendedPrice` decimal(9,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productostotal`
--

CREATE TABLE `productostotal` (
  `idPt` int(11) NOT NULL,
  `idPo` int(11) DEFAULT NULL,
  `total` decimal(9,4) DEFAULT NULL,
  `otherComments` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idSupplier` int(11) NOT NULL,
  `nombreFiscal` varchar(20) DEFAULT NULL,
  `nombreComercial` varchar(20) DEFAULT NULL,
  `negocio` varchar(20) DEFAULT NULL,
  `numeroCliente` varchar(20) DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `correo` varchar(20) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `codigoPostal` varchar(10) DEFAULT NULL,
  `numeroTel` varchar(20) DEFAULT NULL,
  `tipoCompañia` varchar(20) DEFAULT NULL,
  `terminoPago` int(11) DEFAULT NULL,
  `tipotrans` varchar(10) DEFAULT NULL,
  `provfijo` varchar(2) DEFAULT NULL,
  `rfcFile` varchar(100) DEFAULT NULL,
  `comprobanteFile` varchar(100) DEFAULT NULL,
  `ecuenta` varchar(100) DEFAULT NULL,
  `opinionPositiva` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `userName` varchar(20) DEFAULT NULL,
  `passw` varchar(20) DEFAULT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `rol` varchar(10) DEFAULT NULL,
  `puesto` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idPo`),
  ADD KEY `compras_usuario` (`idUsuario`),
  ADD KEY `compras_proveedor` (`idSupplier`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idInvoice`),
  ADD UNIQUE KEY `idPO` (`idPO`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `pago_compras` (`idPO`),
  ADD KEY `pago_facturas` (`idFactura`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idPro`),
  ADD KEY `productos_ibfk_1` (`idPO`);

--
-- Indices de la tabla `productostotal`
--
ALTER TABLE `productostotal`
  ADD PRIMARY KEY (`idPt`),
  ADD KEY `productostotal_ibfk_1` (`idPo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idSupplier`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idPo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `idInvoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idPro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productostotal`
--
ALTER TABLE `productostotal`
  MODIFY `idPt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idSupplier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_proveedor` FOREIGN KEY (`idSupplier`) REFERENCES `proveedor` (`idSupplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `idPO` FOREIGN KEY (`idPO`) REFERENCES `compras` (`idPo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_compras` FOREIGN KEY (`idPO`) REFERENCES `compras` (`idPo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pago_facturas` FOREIGN KEY (`idFactura`) REFERENCES `facturas` (`idInvoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idPO`) REFERENCES `compras` (`idPo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productostotal`
--
ALTER TABLE `productostotal`
  ADD CONSTRAINT `productostotal_ibfk_1` FOREIGN KEY (`idPo`) REFERENCES `compras` (`idPo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
