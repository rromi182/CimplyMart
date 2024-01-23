/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 10.4.28-MariaDB : Database - sysweb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sysweb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sysweb`;

/*Table structure for table `ajuste_stock` */

DROP TABLE IF EXISTS `ajuste_stock`;

CREATE TABLE `ajuste_stock` (
  `id_ajuste_stock` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(15) NOT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id_ajuste_stock`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `ajuste_stock_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ajuste_stock` */

/*Table structure for table `ajuste_stock_det` */

DROP TABLE IF EXISTS `ajuste_stock_det`;

CREATE TABLE `ajuste_stock_det` (
  `id_ajuste_stock` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cod_deposito` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_ajuste_stock`,`cod_producto`),
  KEY `producto_ajuste_stock_asd_fk` (`cod_producto`),
  KEY `deposito_ajuste_stock_asd_fk` (`cod_deposito`),
  CONSTRAINT `ajuste_stock_asd_fk` FOREIGN KEY (`id_ajuste_stock`) REFERENCES `ajuste_stock` (`id_ajuste_stock`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `deposito_ajuste_stock_asd_fk` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `producto_ajuste_stock_asd_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ajuste_stock_det` */

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `cod_ciudad` int(11) NOT NULL,
  `descrip_ciudad` varchar(25) DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  PRIMARY KEY (`cod_ciudad`),
  KEY `id_departamento` (`id_departamento`),
  CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ciudad` */

insert  into `ciudad`(`cod_ciudad`,`descrip_ciudad`,`id_departamento`) values 
(1,'Capiatá',1),
(2,'Caacupe',2);

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `ci_ruc` varchar(10) NOT NULL,
  `cli_nombre` varchar(30) NOT NULL,
  `cli_apellido` varchar(50) NOT NULL,
  `cli_direccion` varchar(50) DEFAULT NULL,
  `cli_telefono` int(11) DEFAULT NULL,
  `cod_ciudad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `clientes_cod_ciudad_fkey` (`cod_ciudad`),
  CONSTRAINT `clientes_cod_ciudad_fkey` FOREIGN KEY (`cod_ciudad`) REFERENCES `ciudad` (`cod_ciudad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `clientes` */

insert  into `clientes`(`id_cliente`,`ci_ruc`,`cli_nombre`,`cli_apellido`,`cli_direccion`,`cli_telefono`,`cod_ciudad`) values 
(1,'111111','Cliente','1','Capiatá',985623456,1);

/*Table structure for table `compra` */

DROP TABLE IF EXISTS `compra`;

CREATE TABLE `compra` (
  `cod_compra` int(11) NOT NULL,
  `cod_proveedor` int(11) NOT NULL,
  `nro_factura` varchar(25) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(15) NOT NULL,
  `cod_deposito` int(11) NOT NULL,
  `hora` time NOT NULL,
  `total_compra` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_orden_compra` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_compra`),
  KEY `cod_deposito` (`cod_deposito`),
  KEY `cod_proveedor` (`cod_proveedor`),
  KEY `id_orden_compra_constraint_fk` (`id_orden_compra`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`cod_proveedor`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `id_orden_compra_constraint_fk` FOREIGN KEY (`id_orden_compra`) REFERENCES `orden_compra` (`id_orden_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compra` */

insert  into `compra`(`cod_compra`,`cod_proveedor`,`nro_factura`,`fecha`,`estado`,`cod_deposito`,`hora`,`total_compra`,`id_user`,`id_orden_compra`) values 
(1,1,'55424','2024-01-08','anulado',1,'08:50:33',90000,1,NULL),
(2,1,'2454','2024-01-08','activo',1,'08:50:52',70000,1,NULL),
(3,1,'80088451','2024-01-08','anulado',1,'09:58:46',120000,1,NULL),
(4,1,'516516','2024-01-08','anulado',1,'10:34:06',6000,1,NULL),
(5,1,'45234532','2024-01-08','activo',1,'10:35:31',35000,1,NULL),
(6,2,'8056516','2024-01-08','activo',1,'12:02:55',12500,1,NULL),
(7,2,'1651651','2024-01-08','activo',2,'12:39:10',25000,1,NULL),
(8,3,'3555561','2024-01-23','activo',1,'21:43:10',50000,1,NULL),
(9,3,'1651651','2024-01-23','anulado',1,'12:55:29',110000,1,NULL),
(10,3,'5651616','2024-01-23','anulado',1,'13:01:27',130000,1,NULL),
(11,3,'151651','2024-01-23','anulado',1,'13:10:47',110000,1,NULL);

/*Table structure for table `departamento` */

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `dep_descripcion` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `departamento` */

insert  into `departamento`(`id_departamento`,`dep_descripcion`) values 
(1,'Central'),
(2,'Cordillera');

/*Table structure for table `deposito` */

DROP TABLE IF EXISTS `deposito`;

CREATE TABLE `deposito` (
  `cod_deposito` int(11) NOT NULL,
  `descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_deposito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `deposito` */

insert  into `deposito`(`cod_deposito`,`descrip`) values 
(1,'Deposito 1'),
(2,'Deposito 2');

/*Table structure for table `det_venta` */

DROP TABLE IF EXISTS `det_venta`;

CREATE TABLE `det_venta` (
  `cod_producto` int(11) NOT NULL,
  `cod_venta` int(11) NOT NULL,
  `cod_deposito` int(11) NOT NULL,
  `det_precio_unit` int(11) NOT NULL,
  `det_cantidad` int(11) NOT NULL,
  PRIMARY KEY (`cod_producto`,`cod_venta`),
  KEY `deposito_det_venta_fk` (`cod_deposito`),
  KEY `venta_det_venta_fk` (`cod_venta`),
  CONSTRAINT `deposito_det_venta_fk` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`),
  CONSTRAINT `producto_det_venta_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`),
  CONSTRAINT `venta_det_venta_fk` FOREIGN KEY (`cod_venta`) REFERENCES `venta` (`cod_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `det_venta` */

/*Table structure for table `detalle_compra` */

DROP TABLE IF EXISTS `detalle_compra`;

CREATE TABLE `detalle_compra` (
  `cod_producto` int(11) NOT NULL,
  `cod_compra` int(11) NOT NULL,
  `cod_deposito` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`cod_producto`,`cod_compra`),
  KEY `compra_detalle_compra_fk` (`cod_compra`),
  KEY `deposito_detalle_compra_fk` (`cod_deposito`),
  CONSTRAINT `compra_detalle_compra_fk` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`cod_compra`),
  CONSTRAINT `deposito_detalle_compra_fk` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`),
  CONSTRAINT `producto_detalle_compra_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detalle_compra` */

insert  into `detalle_compra`(`cod_producto`,`cod_compra`,`cod_deposito`,`precio`,`cantidad`) values 
(1,4,1,6000,1),
(1,8,1,5000,10),
(1,9,1,5000,10),
(1,10,1,6000,10),
(1,11,1,5000,10),
(2,5,1,3500,10),
(3,2,1,7000,10),
(3,9,1,6000,10),
(3,10,1,7000,10),
(3,11,1,6000,10),
(4,1,1,9000,10),
(4,3,1,6000,10),
(5,3,1,6000,10),
(7,6,1,2500,5),
(7,7,2,2500,10);

/*Table structure for table `orden_compra` */

DROP TABLE IF EXISTS `orden_compra`;

CREATE TABLE `orden_compra` (
  `id_orden_compra` int(11) NOT NULL,
  `id_presupuesto_compra` int(11) NOT NULL,
  `cod_proveedor` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `estado` varchar(15) NOT NULL,
  `hora` time DEFAULT NULL,
  `total_costo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_orden_compra`),
  KEY `id_presupuesto_compra` (`id_presupuesto_compra`),
  KEY `cod_proveedor` (`cod_proveedor`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`id_presupuesto_compra`) REFERENCES `presupuesto_compra` (`id_presupuesto_compra`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `orden_compra_ibfk_2` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`cod_proveedor`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `orden_compra_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orden_compra` */

insert  into `orden_compra`(`id_orden_compra`,`id_presupuesto_compra`,`cod_proveedor`,`fecha_registro`,`id_user`,`estado`,`hora`,`total_costo`) values 
(1,1,3,'2024-01-23',1,'pendiente','12:54:57',60000),
(2,2,3,'2024-01-23',1,'aprobado','13:00:51',60000),
(3,3,3,'2024-01-23',1,'aprobado','13:07:53',60000);

/*Table structure for table `orden_compra_det` */

DROP TABLE IF EXISTS `orden_compra_det`;

CREATE TABLE `orden_compra_det` (
  `id_orden_compra` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  PRIMARY KEY (`id_orden_compra`,`cod_producto`),
  KEY `producto_orden_compra_det_fk` (`cod_producto`),
  CONSTRAINT `orden_compra_ocd_fk` FOREIGN KEY (`id_orden_compra`) REFERENCES `orden_compra` (`id_orden_compra`),
  CONSTRAINT `producto_orden_compra_det_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orden_compra_det` */

insert  into `orden_compra_det`(`id_orden_compra`,`cod_producto`,`cantidad`,`costo`) values 
(1,3,10,6000),
(2,3,10,6000),
(3,3,10,6000);

/*Table structure for table `pedido_compra` */

DROP TABLE IF EXISTS `pedido_compra`;

CREATE TABLE `pedido_compra` (
  `hora` time DEFAULT NULL,
  `id_pedido_compra` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `estado` varchar(15) NOT NULL,
  PRIMARY KEY (`id_pedido_compra`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `pedido_compra_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pedido_compra` */

insert  into `pedido_compra`(`hora`,`id_pedido_compra`,`fecha_registro`,`id_user`,`estado`) values 
('21:41:43',1,'2024-01-23',1,'procesado'),
('21:44:30',2,'2024-01-23',1,'procesado'),
('12:05:25',3,'2024-01-23',1,'procesado'),
('12:53:27',4,'2024-01-23',1,'procesado'),
('12:59:16',5,'2024-01-23',1,'procesado'),
('13:06:22',6,'2024-01-23',1,'procesado');

/*Table structure for table `pedido_compra_det` */

DROP TABLE IF EXISTS `pedido_compra_det`;

CREATE TABLE `pedido_compra_det` (
  `id_pedido_compra` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido_compra`,`cod_producto`),
  KEY `producto_pedido_compra_det_fk` (`cod_producto`),
  CONSTRAINT `pedido_compra_pcd_fk` FOREIGN KEY (`id_pedido_compra`) REFERENCES `pedido_compra` (`id_pedido_compra`),
  CONSTRAINT `producto_pedido_compra_det_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pedido_compra_det` */

insert  into `pedido_compra_det`(`id_pedido_compra`,`cod_producto`,`cantidad`) values 
(4,1,10),
(4,3,10),
(5,1,10),
(5,3,10),
(6,1,10),
(6,3,10);

/*Table structure for table `presupuesto_compra` */

DROP TABLE IF EXISTS `presupuesto_compra`;

CREATE TABLE `presupuesto_compra` (
  `id_presupuesto_compra` int(11) NOT NULL,
  `id_pedido_compra` int(11) NOT NULL,
  `cod_proveedor` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` varchar(15) NOT NULL,
  `total_costo` int(11) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id_presupuesto_compra`),
  KEY `id_pedido_compra` (`id_pedido_compra`),
  KEY `cod_proveedor` (`cod_proveedor`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `presupuesto_compra_ibfk_1` FOREIGN KEY (`id_pedido_compra`) REFERENCES `pedido_compra` (`id_pedido_compra`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `presupuesto_compra_ibfk_2` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`cod_proveedor`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `presupuesto_compra_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `presupuesto_compra` */

insert  into `presupuesto_compra`(`id_presupuesto_compra`,`id_pedido_compra`,`cod_proveedor`,`fecha_registro`,`id_user`,`fecha_vencimiento`,`estado`,`total_costo`,`hora`) values 
(1,4,3,'2024-01-23',1,'2024-01-23','procesado',60000,'12:53:46'),
(2,5,3,'2024-01-23',1,'2024-01-23','procesado',60000,'12:59:50'),
(3,6,3,'2024-01-23',1,'2024-01-23','procesado',60000,'13:06:49');

/*Table structure for table `presupuesto_compra_det` */

DROP TABLE IF EXISTS `presupuesto_compra_det`;

CREATE TABLE `presupuesto_compra_det` (
  `id_presupuesto_compra` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  PRIMARY KEY (`id_presupuesto_compra`,`cod_producto`),
  KEY `producto_presupuesto_compra_det_fk` (`cod_producto`),
  CONSTRAINT `presupuesto_compra_pcd_fk` FOREIGN KEY (`id_presupuesto_compra`) REFERENCES `presupuesto_compra` (`id_presupuesto_compra`),
  CONSTRAINT `producto_presupuesto_compra_det_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `presupuesto_compra_det` */

insert  into `presupuesto_compra_det`(`id_presupuesto_compra`,`cod_producto`,`cantidad`,`costo`) values 
(1,3,10,6000),
(2,3,10,6000),
(3,3,10,6000);

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `cod_producto` int(11) NOT NULL,
  `cod_tipo_prod` int(11) NOT NULL,
  `id_u_medida` int(11) NOT NULL,
  `p_descrip` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`cod_producto`),
  KEY `tipo_producto_producto_fk` (`cod_tipo_prod`),
  KEY `u_medida_producto_fk` (`id_u_medida`),
  CONSTRAINT `tipo_producto_producto_fk` FOREIGN KEY (`cod_tipo_prod`) REFERENCES `tipo_producto` (`cod_tipo_prod`),
  CONSTRAINT `u_medida_producto_fk` FOREIGN KEY (`id_u_medida`) REFERENCES `u_medida` (`id_u_medida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `producto` */

insert  into `producto`(`cod_producto`,`cod_tipo_prod`,`id_u_medida`,`p_descrip`,`precio`) values 
(1,1,1,'Leche Entera',6000),
(2,2,1,'Niko Cola',3500),
(3,1,1,'Yogurt',7000),
(4,2,1,'Cerveza Skol',9000),
(5,2,1,'Cerveza Ouro Fino',9000),
(6,1,2,'Yogurt',3500),
(7,3,3,'Detergente',2500),
(8,2,4,'Niko Cola',4000);

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `cod_proveedor` int(11) NOT NULL,
  `razon_social` varchar(75) NOT NULL,
  `ruc` varchar(11) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` int(11) NOT NULL,
  PRIMARY KEY (`cod_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `proveedor` */

insert  into `proveedor`(`cod_proveedor`,`razon_social`,`ruc`,`direccion`,`telefono`) values 
(1,'EMCESA','80006251-5','Avda. Manuel Ortiz Guerrero 761',21585002),
(2,'CAVALLARO HNOS. S.A.C.I','51853','Ruta 1 Km 18 - Capiatá - Paraguay',2147483647),
(3,'LACTOLANDA','80001526-2','Avda. Direccion X',21596323);

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `cod_deposito` int(11) NOT NULL,
  `cod_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`cod_deposito`,`cod_producto`),
  KEY `producto_stock_fk` (`cod_producto`),
  CONSTRAINT `deposito_stock_fk` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`),
  CONSTRAINT `producto_stock_fk` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`cod_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `stock` */

insert  into `stock`(`cod_deposito`,`cod_producto`,`cantidad`) values 
(1,1,10),
(1,2,9),
(1,3,9),
(1,4,0),
(1,5,0),
(1,7,5),
(2,7,10);

/*Table structure for table `tipo_producto` */

DROP TABLE IF EXISTS `tipo_producto`;

CREATE TABLE `tipo_producto` (
  `cod_tipo_prod` int(11) NOT NULL,
  `t_p_descrip` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_tipo_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tipo_producto` */

insert  into `tipo_producto`(`cod_tipo_prod`,`t_p_descrip`) values 
(1,'Lacteos'),
(2,'Bebidas'),
(3,'Limpieza y Desinfeccion del Hogar');

/*Table structure for table `tmp` */

DROP TABLE IF EXISTS `tmp`;

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad_tmp` int(11) DEFAULT NULL,
  `precio_tmp` int(11) DEFAULT NULL,
  `session_id` varchar(765) DEFAULT NULL,
  PRIMARY KEY (`id_tmp`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tmp` */

/*Table structure for table `u_medida` */

DROP TABLE IF EXISTS `u_medida`;

CREATE TABLE `u_medida` (
  `id_u_medida` int(11) NOT NULL,
  `u_descrip` varchar(20) NOT NULL,
  PRIMARY KEY (`id_u_medida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `u_medida` */

insert  into `u_medida`(`id_u_medida`,`u_descrip`) values 
(1,'1 Litro'),
(2,'1/2 Litro'),
(3,'900 ml'),
(4,'2 Litros');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `name_user` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(39) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL,
  `permisos_acceso` varchar(300) DEFAULT NULL,
  `status` char(27) DEFAULT NULL,
  `intentos` int(11) DEFAULT 0,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_user`,`username`,`name_user`,`password`,`email`,`telefono`,`foto`,`permisos_acceso`,`status`,`intentos`) values 
(1,'admin','Romina Almeida','c4ca4238a0b923820dcc509a6f75849b','romi123@gmail.com','0992626661','mifoto.png','Super Admin','activo',0),
(2,'compras','María Benítez','c4ca4238a0b923820dcc509a6f75849b','maria456@gmail.com','0983098626','Cat Medley_ Cuteness Galore, Funnies, Mourning And Loss.jpeg','Compras','activo',0),
(3,'ventas','Lucía Martínez','202cb962ac59075b964b07152d234b70','lucia789@gmail.com','0984156789','Top 10 Dogs with Long Lives _ Puppies Club.png','Ventas','activo',0);

/*Table structure for table `venta` */

DROP TABLE IF EXISTS `venta`;

CREATE TABLE `venta` (
  `cod_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total_venta` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `hora` time NOT NULL,
  `nro_factura` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `cod_deposito` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_venta`),
  KEY `clientes_venta_fk` (`id_cliente`),
  KEY `id_user_constraint_fk` (`id_user`),
  KEY `fk_cod_deposito` (`cod_deposito`),
  CONSTRAINT `clientes_venta_fk` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  CONSTRAINT `fk_cod_deposito` FOREIGN KEY (`cod_deposito`) REFERENCES `deposito` (`cod_deposito`),
  CONSTRAINT `id_user_constraint_fk` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `venta` */

/* Trigger structure for table `det_venta` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp_venta` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp_venta` AFTER INSERT ON `det_venta` FOR EACH ROW 
BEGIN
    DELETE FROM tmp;
END */$$


DELIMITER ;

/* Trigger structure for table `detalle_compra` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `borrar_tmp` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `borrar_tmp` AFTER INSERT ON `detalle_compra` FOR EACH ROW 
BEGIN
    DELETE FROM tmp;
END */$$


DELIMITER ;

/*Table structure for table `v_clientes` */

DROP TABLE IF EXISTS `v_clientes`;

/*!50001 DROP VIEW IF EXISTS `v_clientes` */;
/*!50001 DROP TABLE IF EXISTS `v_clientes` */;

/*!50001 CREATE TABLE  `v_clientes`(
 `id_cliente` int(11) ,
 `ci_ruc` varchar(10) ,
 `cli_nombre` varchar(30) ,
 `cli_apellido` varchar(50) ,
 `cli_direccion` varchar(50) ,
 `cli_telefono` int(11) ,
 `cod_ciudad` int(11) ,
 `descrip_ciudad` varchar(25) ,
 `id_departamento` int(11) ,
 `dep_descripcion` varchar(35) 
)*/;

/*Table structure for table `v_compras` */

DROP TABLE IF EXISTS `v_compras`;

/*!50001 DROP VIEW IF EXISTS `v_compras` */;
/*!50001 DROP TABLE IF EXISTS `v_compras` */;

/*!50001 CREATE TABLE  `v_compras`(
 `cod_compra` int(11) ,
 `cod_proveedor` int(11) ,
 `razon_social` varchar(75) ,
 `cod_deposito` int(11) ,
 `descrip` varchar(50) ,
 `nro_factura` varchar(25) ,
 `fecha` date ,
 `hora` time ,
 `total_compra` int(11) ,
 `estado` varchar(15) ,
 `id_user` int(11) ,
 `name_user` varchar(150) 
)*/;

/*Table structure for table `v_det_compra` */

DROP TABLE IF EXISTS `v_det_compra`;

/*!50001 DROP VIEW IF EXISTS `v_det_compra` */;
/*!50001 DROP TABLE IF EXISTS `v_det_compra` */;

/*!50001 CREATE TABLE  `v_det_compra`(
 `cod_compra` int(11) ,
 `cod_producto` int(11) ,
 `t_p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `p_descrip` varchar(50) ,
 `precio` int(11) ,
 `cantidad` int(11) 
)*/;

/*Table structure for table `v_det_venta` */

DROP TABLE IF EXISTS `v_det_venta`;

/*!50001 DROP VIEW IF EXISTS `v_det_venta` */;
/*!50001 DROP TABLE IF EXISTS `v_det_venta` */;

/*!50001 CREATE TABLE  `v_det_venta`(
 `cod_venta` int(11) ,
 `id_cliente` int(11) ,
 `dato_cliente` varchar(82) ,
 `ci_ruc` varchar(10) ,
 `cod_producto` int(11) ,
 `t_p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `p_descrip` varchar(50) ,
 `det_precio_unit` int(11) ,
 `det_cantidad` int(11) 
)*/;

/*Table structure for table `v_orden_compra` */

DROP TABLE IF EXISTS `v_orden_compra`;

/*!50001 DROP VIEW IF EXISTS `v_orden_compra` */;
/*!50001 DROP TABLE IF EXISTS `v_orden_compra` */;

/*!50001 CREATE TABLE  `v_orden_compra`(
 `id_orden_compra` int(11) ,
 `id_presupuesto_compra` int(11) ,
 `cod_proveedor` int(11) ,
 `proveedor` varchar(89) ,
 `id_user` int(11) ,
 `username` varchar(150) ,
 `name_user` varchar(150) ,
 `fecha_registro` date ,
 `estado` varchar(15) ,
 `hora` time ,
 `total_costo` int(11) 
)*/;

/*Table structure for table `v_orden_compra_det` */

DROP TABLE IF EXISTS `v_orden_compra_det`;

/*!50001 DROP VIEW IF EXISTS `v_orden_compra_det` */;
/*!50001 DROP TABLE IF EXISTS `v_orden_compra_det` */;

/*!50001 CREATE TABLE  `v_orden_compra_det`(
 `id_orden_compra` int(11) ,
 `cod_proveedor` int(11) ,
 `razon_social` varchar(75) ,
 `cod_producto` int(11) ,
 `p_descrip` varchar(50) ,
 `cod_tipo_prod` int(11) ,
 `t_p_descrip` varchar(50) ,
 `id_u_medida` int(11) ,
 `u_descrip` varchar(20) ,
 `cantidad` int(11) ,
 `costo` int(11) 
)*/;

/*Table structure for table `v_pedido_compra` */

DROP TABLE IF EXISTS `v_pedido_compra`;

/*!50001 DROP VIEW IF EXISTS `v_pedido_compra` */;
/*!50001 DROP TABLE IF EXISTS `v_pedido_compra` */;

/*!50001 CREATE TABLE  `v_pedido_compra`(
 `id_pedido_compra` int(11) ,
 `id_user` int(11) ,
 `username` varchar(150) ,
 `name_user` varchar(150) ,
 `fecha_registro` date ,
 `estado` varchar(15) ,
 `hora` time 
)*/;

/*Table structure for table `v_pedido_compra_det` */

DROP TABLE IF EXISTS `v_pedido_compra_det`;

/*!50001 DROP VIEW IF EXISTS `v_pedido_compra_det` */;
/*!50001 DROP TABLE IF EXISTS `v_pedido_compra_det` */;

/*!50001 CREATE TABLE  `v_pedido_compra_det`(
 `id_pedido_compra` int(11) ,
 `cod_producto` int(11) ,
 `p_descrip` varchar(50) ,
 `t_p_descrip` varchar(50) ,
 `id_u_medida` int(11) ,
 `u_descrip` varchar(20) ,
 `cantidad` int(11) 
)*/;

/*Table structure for table `v_presupuesto_compra` */

DROP TABLE IF EXISTS `v_presupuesto_compra`;

/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra` */;
/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra` */;

/*!50001 CREATE TABLE  `v_presupuesto_compra`(
 `id_presupuesto_compra` int(11) ,
 `id_pedido_compra` int(11) ,
 `cod_proveedor` int(11) ,
 `proveedor` varchar(89) ,
 `id_user` int(11) ,
 `username` varchar(150) ,
 `name_user` varchar(150) ,
 `fecha_registro` date ,
 `fecha_vencimiento` date ,
 `estado` varchar(15) ,
 `hora` time ,
 `total_costo` int(11) 
)*/;

/*Table structure for table `v_presupuesto_compra_det` */

DROP TABLE IF EXISTS `v_presupuesto_compra_det`;

/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra_det` */;
/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra_det` */;

/*!50001 CREATE TABLE  `v_presupuesto_compra_det`(
 `id_presupuesto_compra` int(11) ,
 `cod_producto` int(11) ,
 `p_descrip` varchar(50) ,
 `cod_tipo_prod` int(11) ,
 `t_p_descrip` varchar(50) ,
 `id_u_medida` int(11) ,
 `u_descrip` varchar(20) ,
 `cantidad` int(11) ,
 `costo` int(11) 
)*/;

/*Table structure for table `v_presupuesto_compra_orden` */

DROP TABLE IF EXISTS `v_presupuesto_compra_orden`;

/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra_orden` */;
/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra_orden` */;

/*!50001 CREATE TABLE  `v_presupuesto_compra_orden`(
 `id_presupuesto_compra` int(11) ,
 `cod_proveedor` int(11) ,
 `razon_social` varchar(75) ,
 `ruc` varchar(11) ,
 `cod_producto` int(11) ,
 `p_descrip` varchar(50) ,
 `cod_tipo_prod` int(11) ,
 `t_p_descrip` varchar(50) ,
 `id_u_medida` int(11) ,
 `u_descrip` varchar(20) ,
 `cantidad` int(11) ,
 `costo` int(11) 
)*/;

/*Table structure for table `v_stock` */

DROP TABLE IF EXISTS `v_stock`;

/*!50001 DROP VIEW IF EXISTS `v_stock` */;
/*!50001 DROP TABLE IF EXISTS `v_stock` */;

/*!50001 CREATE TABLE  `v_stock`(
 `cod_producto` int(11) ,
 `cod_deposito` int(11) ,
 `descrip` varchar(50) ,
 `t_p_descrip` varchar(50) ,
 `p_descrip` varchar(50) ,
 `u_descrip` varchar(20) ,
 `cantidad` int(11) 
)*/;

/*Table structure for table `v_ventas` */

DROP TABLE IF EXISTS `v_ventas`;

/*!50001 DROP VIEW IF EXISTS `v_ventas` */;
/*!50001 DROP TABLE IF EXISTS `v_ventas` */;

/*!50001 CREATE TABLE  `v_ventas`(
 `cod_venta` int(11) ,
 `id_cliente` int(11) ,
 `dato_cliente` varchar(82) ,
 `estado` varchar(15) ,
 `fecha` date ,
 `hora` time ,
 `total_venta` int(11) ,
 `nro_factura` int(11) ,
 `id_user` int(11) ,
 `username` varchar(150) ,
 `name_user` varchar(150) 
)*/;

/*View structure for view v_clientes */

/*!50001 DROP TABLE IF EXISTS `v_clientes` */;
/*!50001 DROP VIEW IF EXISTS `v_clientes` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_clientes` AS (select `cli`.`id_cliente` AS `id_cliente`,`cli`.`ci_ruc` AS `ci_ruc`,`cli`.`cli_nombre` AS `cli_nombre`,`cli`.`cli_apellido` AS `cli_apellido`,`cli`.`cli_direccion` AS `cli_direccion`,`cli`.`cli_telefono` AS `cli_telefono`,`ciu`.`cod_ciudad` AS `cod_ciudad`,`ciu`.`descrip_ciudad` AS `descrip_ciudad`,`dep`.`id_departamento` AS `id_departamento`,`dep`.`dep_descripcion` AS `dep_descripcion` from ((`clientes` `cli` join `ciudad` `ciu` on(`cli`.`cod_ciudad` = `ciu`.`cod_ciudad`)) join `departamento` `dep` on(`ciu`.`id_departamento` = `dep`.`id_departamento`))) */;

/*View structure for view v_compras */

/*!50001 DROP TABLE IF EXISTS `v_compras` */;
/*!50001 DROP VIEW IF EXISTS `v_compras` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_compras` AS (select `comp`.`cod_compra` AS `cod_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`depo`.`cod_deposito` AS `cod_deposito`,`depo`.`descrip` AS `descrip`,`comp`.`nro_factura` AS `nro_factura`,`comp`.`fecha` AS `fecha`,`comp`.`hora` AS `hora`,`comp`.`total_compra` AS `total_compra`,`comp`.`estado` AS `estado`,`usu`.`id_user` AS `id_user`,`usu`.`name_user` AS `name_user` from (((`compra` `comp` join `proveedor` `prov`) join `deposito` `depo`) join `usuarios` `usu`) where `comp`.`cod_proveedor` = `prov`.`cod_proveedor` and `comp`.`cod_deposito` = `depo`.`cod_deposito` and `comp`.`id_user` = `usu`.`id_user`) */;

/*View structure for view v_det_compra */

/*!50001 DROP TABLE IF EXISTS `v_det_compra` */;
/*!50001 DROP VIEW IF EXISTS `v_det_compra` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_det_compra` AS (select `comp`.`cod_compra` AS `cod_compra`,`pro`.`cod_producto` AS `cod_producto`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`u_descrip` AS `u_descrip`,`pro`.`p_descrip` AS `p_descrip`,`dc`.`precio` AS `precio`,`dc`.`cantidad` AS `cantidad` from ((((`detalle_compra` `dc` join `compra` `comp`) join `producto` `pro`) join `tipo_producto` `tp`) join `u_medida` `um`) where `dc`.`cod_compra` = `comp`.`cod_compra` and `dc`.`cod_producto` = `pro`.`cod_producto` and `pro`.`cod_tipo_prod` = `tp`.`cod_tipo_prod` and `pro`.`id_u_medida` = `um`.`id_u_medida`) */;

/*View structure for view v_det_venta */

/*!50001 DROP TABLE IF EXISTS `v_det_venta` */;
/*!50001 DROP VIEW IF EXISTS `v_det_venta` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_det_venta` AS (select `v`.`cod_venta` AS `cod_venta`,`cli`.`id_cliente` AS `id_cliente`,concat(`cli`.`cli_nombre`,', ',`cli`.`cli_apellido`) AS `dato_cliente`,`cli`.`ci_ruc` AS `ci_ruc`,`pro`.`cod_producto` AS `cod_producto`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`u_descrip` AS `u_descrip`,`pro`.`p_descrip` AS `p_descrip`,`dv`.`det_precio_unit` AS `det_precio_unit`,`dv`.`det_cantidad` AS `det_cantidad` from (((((`det_venta` `dv` join `venta` `v`) join `producto` `pro`) join `tipo_producto` `tp`) join `u_medida` `um`) join `clientes` `cli`) where `dv`.`cod_venta` = `v`.`cod_venta` and `dv`.`cod_producto` = `pro`.`cod_producto` and `pro`.`cod_tipo_prod` = `tp`.`cod_tipo_prod` and `pro`.`id_u_medida` = `um`.`id_u_medida` and `v`.`id_cliente` = `cli`.`id_cliente`) */;

/*View structure for view v_orden_compra */

/*!50001 DROP TABLE IF EXISTS `v_orden_compra` */;
/*!50001 DROP VIEW IF EXISTS `v_orden_compra` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orden_compra` AS (select `orden`.`id_orden_compra` AS `id_orden_compra`,`precom`.`id_presupuesto_compra` AS `id_presupuesto_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,concat(`prov`.`razon_social`,' - ',`prov`.`ruc`) AS `proveedor`,`usu`.`id_user` AS `id_user`,`usu`.`username` AS `username`,`usu`.`name_user` AS `name_user`,`orden`.`fecha_registro` AS `fecha_registro`,`orden`.`estado` AS `estado`,`orden`.`hora` AS `hora`,`orden`.`total_costo` AS `total_costo` from (((`orden_compra` `orden` join `presupuesto_compra` `precom` on(`orden`.`id_presupuesto_compra` = `precom`.`id_presupuesto_compra`)) join `proveedor` `prov` on(`precom`.`cod_proveedor` = `prov`.`cod_proveedor`)) join `usuarios` `usu` on(`precom`.`id_user` = `usu`.`id_user`))) */;

/*View structure for view v_orden_compra_det */

/*!50001 DROP TABLE IF EXISTS `v_orden_compra_det` */;
/*!50001 DROP VIEW IF EXISTS `v_orden_compra_det` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orden_compra_det` AS (select `orden`.`id_orden_compra` AS `id_orden_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`tp`.`cod_tipo_prod` AS `cod_tipo_prod`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`id_u_medida` AS `id_u_medida`,`um`.`u_descrip` AS `u_descrip`,`ocd`.`cantidad` AS `cantidad`,`ocd`.`costo` AS `costo` from (((((`orden_compra` `orden` join `proveedor` `prov` on(`orden`.`cod_proveedor` = `prov`.`cod_proveedor`)) join `orden_compra_det` `ocd` on(`orden`.`id_orden_compra` = `ocd`.`id_orden_compra`)) join `producto` `prod` on(`ocd`.`cod_producto` = `prod`.`cod_producto`)) join `tipo_producto` `tp` on(`prod`.`cod_tipo_prod` = `tp`.`cod_tipo_prod`)) join `u_medida` `um` on(`prod`.`id_u_medida` = `um`.`id_u_medida`))) */;

/*View structure for view v_pedido_compra */

/*!50001 DROP TABLE IF EXISTS `v_pedido_compra` */;
/*!50001 DROP VIEW IF EXISTS `v_pedido_compra` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pedido_compra` AS (select `pc`.`id_pedido_compra` AS `id_pedido_compra`,`usu`.`id_user` AS `id_user`,`usu`.`username` AS `username`,`usu`.`name_user` AS `name_user`,`pc`.`fecha_registro` AS `fecha_registro`,`pc`.`estado` AS `estado`,`pc`.`hora` AS `hora` from (`pedido_compra` `pc` join `usuarios` `usu` on(`pc`.`id_user` = `usu`.`id_user`))) */;

/*View structure for view v_pedido_compra_det */

/*!50001 DROP TABLE IF EXISTS `v_pedido_compra_det` */;
/*!50001 DROP VIEW IF EXISTS `v_pedido_compra_det` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pedido_compra_det` AS (select `pcd`.`id_pedido_compra` AS `id_pedido_compra`,`p`.`cod_producto` AS `cod_producto`,`p`.`p_descrip` AS `p_descrip`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`id_u_medida` AS `id_u_medida`,`um`.`u_descrip` AS `u_descrip`,`pcd`.`cantidad` AS `cantidad` from (((`pedido_compra_det` `pcd` join `producto` `p` on(`pcd`.`cod_producto` = `p`.`cod_producto`)) join `tipo_producto` `tp` on(`tp`.`cod_tipo_prod` = `p`.`cod_tipo_prod`)) join `u_medida` `um` on(`um`.`id_u_medida` = `p`.`id_u_medida`))) */;

/*View structure for view v_presupuesto_compra */

/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra` */;
/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presupuesto_compra` AS (select `precom`.`id_presupuesto_compra` AS `id_presupuesto_compra`,`pecom`.`id_pedido_compra` AS `id_pedido_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,concat(`prov`.`razon_social`,' - ',`prov`.`ruc`) AS `proveedor`,`usu`.`id_user` AS `id_user`,`usu`.`username` AS `username`,`usu`.`name_user` AS `name_user`,`precom`.`fecha_registro` AS `fecha_registro`,`precom`.`fecha_vencimiento` AS `fecha_vencimiento`,`precom`.`estado` AS `estado`,`precom`.`hora` AS `hora`,`precom`.`total_costo` AS `total_costo` from (((`presupuesto_compra` `precom` join `pedido_compra` `pecom` on(`precom`.`id_pedido_compra` = `pecom`.`id_pedido_compra`)) join `proveedor` `prov` on(`precom`.`cod_proveedor` = `prov`.`cod_proveedor`)) join `usuarios` `usu` on(`precom`.`id_user` = `usu`.`id_user`))) */;

/*View structure for view v_presupuesto_compra_det */

/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra_det` */;
/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra_det` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presupuesto_compra_det` AS (select `precom`.`id_presupuesto_compra` AS `id_presupuesto_compra`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`tp`.`cod_tipo_prod` AS `cod_tipo_prod`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`id_u_medida` AS `id_u_medida`,`um`.`u_descrip` AS `u_descrip`,`pcd`.`cantidad` AS `cantidad`,`pcd`.`costo` AS `costo` from ((((`presupuesto_compra_det` `pcd` join `presupuesto_compra` `precom` on(`pcd`.`id_presupuesto_compra` = `precom`.`id_presupuesto_compra`)) join `producto` `prod` on(`pcd`.`cod_producto` = `prod`.`cod_producto`)) join `tipo_producto` `tp` on(`prod`.`cod_tipo_prod` = `tp`.`cod_tipo_prod`)) join `u_medida` `um` on(`prod`.`id_u_medida` = `um`.`id_u_medida`))) */;

/*View structure for view v_presupuesto_compra_orden */

/*!50001 DROP TABLE IF EXISTS `v_presupuesto_compra_orden` */;
/*!50001 DROP VIEW IF EXISTS `v_presupuesto_compra_orden` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presupuesto_compra_orden` AS (select `presu`.`id_presupuesto_compra` AS `id_presupuesto_compra`,`prov`.`cod_proveedor` AS `cod_proveedor`,`prov`.`razon_social` AS `razon_social`,`prov`.`ruc` AS `ruc`,`prod`.`cod_producto` AS `cod_producto`,`prod`.`p_descrip` AS `p_descrip`,`tp`.`cod_tipo_prod` AS `cod_tipo_prod`,`tp`.`t_p_descrip` AS `t_p_descrip`,`um`.`id_u_medida` AS `id_u_medida`,`um`.`u_descrip` AS `u_descrip`,`pcd`.`cantidad` AS `cantidad`,`pcd`.`costo` AS `costo` from (((((`presupuesto_compra` `presu` join `proveedor` `prov` on(`presu`.`cod_proveedor` = `prov`.`cod_proveedor`)) join `presupuesto_compra_det` `pcd` on(`presu`.`id_presupuesto_compra` = `pcd`.`id_presupuesto_compra`)) join `producto` `prod` on(`pcd`.`cod_producto` = `prod`.`cod_producto`)) join `tipo_producto` `tp` on(`prod`.`cod_tipo_prod` = `tp`.`cod_tipo_prod`)) join `u_medida` `um` on(`prod`.`id_u_medida` = `um`.`id_u_medida`))) */;

/*View structure for view v_stock */

/*!50001 DROP TABLE IF EXISTS `v_stock` */;
/*!50001 DROP VIEW IF EXISTS `v_stock` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stock` AS (select `pro`.`cod_producto` AS `cod_producto`,`dep`.`cod_deposito` AS `cod_deposito`,`dep`.`descrip` AS `descrip`,`tp`.`t_p_descrip` AS `t_p_descrip`,`pro`.`p_descrip` AS `p_descrip`,`um`.`u_descrip` AS `u_descrip`,`st`.`cantidad` AS `cantidad` from ((((`stock` `st` join `producto` `pro`) join `tipo_producto` `tp`) join `u_medida` `um`) join `deposito` `dep`) where `st`.`cod_producto` = `pro`.`cod_producto` and `st`.`cod_deposito` = `dep`.`cod_deposito` and `pro`.`cod_tipo_prod` = `tp`.`cod_tipo_prod` and `pro`.`id_u_medida` = `um`.`id_u_medida`) */;

/*View structure for view v_ventas */

/*!50001 DROP TABLE IF EXISTS `v_ventas` */;
/*!50001 DROP VIEW IF EXISTS `v_ventas` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ventas` AS (select `v`.`cod_venta` AS `cod_venta`,`cli`.`id_cliente` AS `id_cliente`,concat(`cli`.`cli_nombre`,', ',`cli`.`cli_apellido`) AS `dato_cliente`,`v`.`estado` AS `estado`,`v`.`fecha` AS `fecha`,`v`.`hora` AS `hora`,`v`.`total_venta` AS `total_venta`,`v`.`nro_factura` AS `nro_factura`,`usu`.`id_user` AS `id_user`,`usu`.`username` AS `username`,`usu`.`name_user` AS `name_user` from ((`venta` `v` join `clientes` `cli`) join `usuarios` `usu`) where `v`.`id_cliente` = `cli`.`id_cliente` and `v`.`id_user` = `usu`.`id_user`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
