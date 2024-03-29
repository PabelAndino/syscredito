-- MySQL Script generated by MySQL Workbench
-- Sun Nov 17 20:17:39 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_credi_emp
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `db_credi_emp` ;

-- -----------------------------------------------------
-- Schema db_credi_emp
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_credi_emp` DEFAULT CHARACTER SET utf8 ;
USE `db_credi_emp` ;

-- -----------------------------------------------------
-- Table `db_credi_emp`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`categoria` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `condicion` TINYINT(4) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`articulo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`articulo` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`articulo` (
  `idarticulo` INT NOT NULL AUTO_INCREMENT,
  `idcategoria` INT NOT NULL,
  `codigo` VARCHAR(45) NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `stock` INT NOT NULL,
  `descripcion` VARCHAR(450) NULL,
  `imagen` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `condicion` TINYINT(4) NOT NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`idarticulo`),
  INDEX `fkarticuloCategoria_idx` (`idcategoria` ASC),
  CONSTRAINT `fkarticuloCategoria`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `db_credi_emp`.`categoria` (`idcategoria`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`persona`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`persona` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`persona` (
  `idpersona` INT NOT NULL AUTO_INCREMENT,
  `tipo_persona` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `genero` VARCHAR(45) NULL,
  `tipo_documento` VARCHAR(45) NOT NULL,
  `num_documento` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idpersona`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`usuario` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `tipo_documento` VARCHAR(45) NOT NULL,
  `num_documento` VARCHAR(45) NULL,
  `direccion` VARCHAR(150) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `cargo` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `imagen` VARCHAR(45) NULL,
  `condicion` TINYINT NULL,
  PRIMARY KEY (`idusuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`ingreso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`ingreso` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`ingreso` (
  `idingreso` INT NOT NULL AUTO_INCREMENT,
  `idproveedor` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(45) NOT NULL,
  `serie_comprobante` VARCHAR(45) NULL,
  `num_comprobante` VARCHAR(45) NOT NULL,
  `fecha_hora` DATETIME NOT NULL,
  `impuesto` VARCHAR(45) NULL,
  `total_compra` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`idingreso`),
  INDEX `fkingresoP_idx` (`idproveedor` ASC),
  INDEX `fkingresoU_idx` (`idusuario` ASC),
  CONSTRAINT `fkingresoP`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkingresoU`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_ingreso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_ingreso` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_ingreso` (
  `iddetalle_ingreso` INT NOT NULL AUTO_INCREMENT,
  `idingreso` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `idarticulo` INT NOT NULL,
  `costoU` DECIMAL(11,2) NOT NULL,
  `ivaU` DECIMAL(11,2) NULL,
  `ivaST` DECIMAL(11,2) NULL,
  `porcentajeVenta` DECIMAL(11,2) NULL,
  `precioVenta` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso`),
  INDEX `fkdiIngreso_idx` (`idingreso` ASC),
  INDEX `fkdiArticulo_idx` (`idarticulo` ASC),
  CONSTRAINT `fkdiIngreso`
    FOREIGN KEY (`idingreso`)
    REFERENCES `db_credi_emp`.`ingreso` (`idingreso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkdiArticulo`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `db_credi_emp`.`articulo` (`idarticulo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`venta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`venta` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`venta` (
  `idventa` INT NOT NULL AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(45) NOT NULL,
  `serie_comprobante` VARCHAR(45) NULL,
  `num_comprobante` INT NULL,
  `fecha_hora` DATETIME NULL,
  `impuesto` DECIMAL(4,2) NOT NULL,
  `total_venta` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NULL,
  `tipoVenta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idventa`),
  INDEX `fkventacliente_idx` (`idcliente` ASC),
  INDEX `fkventausuario_idx` (`idusuario` ASC),
  CONSTRAINT `fkventacliente`
    FOREIGN KEY (`idcliente`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkventausuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_venta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_venta` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_venta` (
  `iddetalle_venta` INT NOT NULL AUTO_INCREMENT,
  `idventa` INT NOT NULL,
  `idarticulo` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_compra` DECIMAL(11,2) NULL,
  `precio_venta` DECIMAL(11,2) NOT NULL,
  `descuento` DECIMAL(11,2) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iddetalle_venta`),
  INDEX `fkventa_idx` (`idventa` ASC),
  INDEX `fkventaarticulo_idx` (`idarticulo` ASC),
  CONSTRAINT `fkventa`
    FOREIGN KEY (`idventa`)
    REFERENCES `db_credi_emp`.`venta` (`idventa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkventaarticulo`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `db_credi_emp`.`articulo` (`idarticulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`permiso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`permiso` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`permiso` (
  `idpermiso` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`idpermiso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`usuario_permiso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`usuario_permiso` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`usuario_permiso` (
  `idusuario_permiso` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idpermiso` INT NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  INDEX `fkupUs_idx` (`idusuario` ASC),
  INDEX `fkupP_idx` (`idpermiso` ASC),
  CONSTRAINT `fkupUs`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkupP`
    FOREIGN KEY (`idpermiso`)
    REFERENCES `db_credi_emp`.`permiso` (`idpermiso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`pedido` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`pedido` (
  `idpedido` INT NOT NULL AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `idproveedor` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `decripcion` VARCHAR(200) NULL,
  `total` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idpedido`),
  INDEX `fkpedidocliente_idx` (`idcliente` ASC),
  INDEX `fkpedidousuario_idx` (`idusuario` ASC),
  INDEX `fkpedidoproveedor_idx` (`idproveedor` ASC),
  CONSTRAINT `fkpedidocliente`
    FOREIGN KEY (`idcliente`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkpedidousuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkpedidoproveedor`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_pedido` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_pedido` (
  `iddetalle_pedido` INT NOT NULL AUTO_INCREMENT,
  `idpedido` INT NOT NULL,
  `articulo` VARCHAR(150) NOT NULL,
  `cantidad` INT NOT NULL,
  `precioU` DECIMAL(11,2) NOT NULL,
  `precioV` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_pedido`),
  INDEX `fkpedido_idx` (`idpedido` ASC),
  CONSTRAINT `fkpedido`
    FOREIGN KEY (`idpedido`)
    REFERENCES `db_credi_emp`.`pedido` (`idpedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`abono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`abono` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`abono` (
  `idabono` INT NOT NULL AUTO_INCREMENT,
  `idventa` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(45) NULL,
  `num_comprobante` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idabono`),
  INDEX `fkventaabono_idx` (`idventa` ASC),
  INDEX `fkusuarioabono_idx` (`idusuario` ASC),
  CONSTRAINT `fkventaabono`
    FOREIGN KEY (`idventa`)
    REFERENCES `db_credi_emp`.`venta` (`idventa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkusuarioabono`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_abono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_abono` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_abono` (
  `iddetalle_abono` INT NOT NULL AUTO_INCREMENT,
  `idabono` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `cantidad` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_abono`),
  INDEX `fkdetalleabono_idx` (`idabono` ASC),
  CONSTRAINT `fkdetalleabono`
    FOREIGN KEY (`idabono`)
    REFERENCES `db_credi_emp`.`abono` (`idabono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`proforma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`proforma` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`proforma` (
  `idproforma` INT NOT NULL AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(45) NOT NULL,
  `serie_comprobante` VARCHAR(45) NULL,
  `num_comprobante` VARCHAR(45) NULL,
  `fecha_hora` DATETIME NULL,
  `impuesto` DECIMAL(4,2) NOT NULL,
  `total_venta` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NULL,
  `tipoVenta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idproforma`),
  INDEX `fkventacliente_idx` (`idcliente` ASC),
  INDEX `fkventausuario_idx` (`idusuario` ASC),
  CONSTRAINT `fkventacliente0`
    FOREIGN KEY (`idcliente`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkventausuario0`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_proforma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_proforma` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_proforma` (
  `iddetalle_proforma` INT NOT NULL AUTO_INCREMENT,
  `idproforma` INT NOT NULL,
  `idarticulo` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_venta` DECIMAL(11,2) NOT NULL,
  `descuento` DECIMAL(11,2) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`iddetalle_proforma`),
  INDEX `fkventaarticulo_idx` (`idarticulo` ASC),
  INDEX `fkproforma_idx` (`idproforma` ASC),
  CONSTRAINT `fkproformaarticulo0`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `db_credi_emp`.`articulo` (`idarticulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkproforma`
    FOREIGN KEY (`idproforma`)
    REFERENCES `db_credi_emp`.`proforma` (`idproforma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`reparacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`reparacion` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`reparacion` (
  `idreparacion` INT NOT NULL AUTO_INCREMENT,
  `idventa` INT NOT NULL,
  `detalles` VARCHAR(1000) NOT NULL,
  `equipo` VARCHAR(45) NOT NULL,
  `precio` DECIMAL(11,2) NOT NULL,
  `idarticulo` INT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idreparacion`),
  INDEX `fkidventareparacion_idx` (`idventa` ASC),
  INDEX `fkidarticuloreparacion_idx` (`idarticulo` ASC),
  CONSTRAINT `fkidventareparacion`
    FOREIGN KEY (`idventa`)
    REFERENCES `db_credi_emp`.`venta` (`idventa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkidarticuloreparacion`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `db_credi_emp`.`articulo` (`idarticulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`abono_hipoteca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`abono_hipoteca` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`abono_hipoteca` (
  `idabono` INT NOT NULL AUTO_INCREMENT,
  `idhipoteca` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `num_comprobante` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idabono`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`categoria_hipoteca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`categoria_hipoteca` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`categoria_hipoteca` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `condicion` TINYINT(4) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`cliente` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`cliente` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nombres` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(400) NOT NULL,
  `genero` VARCHAR(45) NOT NULL,
  `estado_civil` VARCHAR(45) NOT NULL,
  `tipo_documento` VARCHAR(45) NULL,
  `num_documento` VARCHAR(45) NULL,
  `igresos` VARCHAR(45) NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`garantia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`garantia` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`garantia` (
  `idgarantia` INT NOT NULL AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `condicion` VARCHAR(15) NOT NULL COMMENT 'Si ya pagaraon o no\nPendiente o Entregado',
  `categoria` VARCHAR(45) NULL COMMENT 'Si ya se asigno la garantia a un prestamo o hipoteca, cuando se hace el préstamo pas a asignado, pero cuando se crea la garantía aun no a sido asignada así que pasa a no_asignado\nAsignado o no_asignado\n',
  `estado` VARCHAR(45) NOT NULL COMMENT 'Anulado o Aceptado',
  PRIMARY KEY (`idgarantia`),
  INDEX `clientefk_idx` (`idcliente` ASC),
  CONSTRAINT `clientefk`
    FOREIGN KEY (`idcliente`)
    REFERENCES `db_credi_emp`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`articulo_hipoteca_detalle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`articulo_hipoteca_detalle` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`articulo_hipoteca_detalle` (
  `idarticulo` INT NOT NULL AUTO_INCREMENT,
  `idgarantia` INT NOT NULL,
  `idcategoria` INT NOT NULL,
  `codigo` VARCHAR(45) NULL,
  `descripcion` VARCHAR(1500) NOT NULL,
  `valor` DECIMAL(11,2) NULL,
  `moneda` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idarticulo`),
  INDEX `categoriahp_idx` (`idcategoria` ASC),
  INDEX `garantiafk_idx` (`idgarantia` ASC),
  CONSTRAINT `categoriahp`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `db_credi_emp`.`categoria_hipoteca` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `garantiafk`
    FOREIGN KEY (`idgarantia`)
    REFERENCES `db_credi_emp`.`garantia` (`idgarantia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`socios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`socios` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`socios` (
  `idsocios` INT NOT NULL AUTO_INCREMENT,
  `nombres` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(170) NOT NULL,
  `tipo_documento` VARCHAR(45) NOT NULL,
  `cedula_ruc` VARCHAR(45) NOT NULL,
  `genero` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idsocios`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`banco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`banco` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`banco` (
  `idbanco` INT NOT NULL AUTO_INCREMENT,
  `nombre_banco` VARCHAR(45) NULL,
  `descripcion` VARCHAR(200) NULL,
  `estado` VARCHAR(45) NULL COMMENT 'Puede estar anulado o aceptado',
  PRIMARY KEY (`idbanco`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`cuentas_bancos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`cuentas_bancos` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`cuentas_bancos` (
  `idcuentas_bancos` INT NOT NULL AUTO_INCREMENT,
  `socio` INT NOT NULL,
  `banco` INT NOT NULL,
  `num_cuenta` VARCHAR(45) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `moneda` VARCHAR(45) NULL,
  `monto` DECIMAL(11,2) NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcuentas_bancos`),
  INDEX `sociosfk_idx` (`socio` ASC),
  INDEX `bancosfk_idx` (`banco` ASC),
  CONSTRAINT `sociosfk`
    FOREIGN KEY (`socio`)
    REFERENCES `db_credi_emp`.`socios` (`idsocios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bancosfk`
    FOREIGN KEY (`banco`)
    REFERENCES `db_credi_emp`.`banco` (`idbanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`sector`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`sector` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`sector` (
  `idsector` INT NOT NULL AUTO_INCREMENT,
  `sector` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`idsector`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`solicitud`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`solicitud` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`solicitud` (
  `idsolicitud` INT NOT NULL AUTO_INCREMENT,
  `cliente` INT NOT NULL,
  `nombre_conyugue` VARCHAR(45) NULL,
  `tipo_local` VARCHAR(45) NULL,
  `leer_escribir` VARCHAR(45) NULL,
  `ultimo_estudio_anio` VARCHAR(45) NULL,
  `numero_dependientes` VARCHAR(45) NULL,
  `ingresos` VARCHAR(100) NULL,
  `total_ingresos` DECIMAL(11,2) NOT NULL,
  `sector` INT NOT NULL,
  `objetivo_prestamo` VARCHAR(1000) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`idsolicitud`),
  INDEX `clientefk_idx` (`cliente` ASC),
  INDEX `sector_idx` (`sector` ASC),
  CONSTRAINT `cliente_colicitudfk`
    FOREIGN KEY (`cliente`)
    REFERENCES `db_credi_emp`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sectorfk`
    FOREIGN KEY (`sector`)
    REFERENCES `db_credi_emp`.`sector` (`idsector`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`hipoteca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`hipoteca` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`hipoteca` (
  `idhipoteca` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idfiador` INT NOT NULL,
  `idarticulo_garantia` INT NOT NULL,
  `fecha_desembolso` DATETIME NOT NULL,
  `fecha_pago` DATETIME NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `monto` DECIMAL(11,2) NOT NULL,
  `interes` DECIMAL(11,2) NOT NULL,
  `plazo` INT NOT NULL,
  `interes_moratorio` DECIMAL(11,2) NULL,
  `moneda` VARCHAR(50) NOT NULL,
  `nota` VARCHAR(1500) NULL,
  `comision` DECIMAL(11,2) NOT NULL,
  `mantenimiento_valor` DECIMAL(11,2) NOT NULL,
  `cuenta_desembolso` INT NOT NULL,
  `solicitud` INT NOT NULL,
  `tipo_cambio` DECIMAL(11,2) NULL COMMENT 'Tipo de cambio del dolar',
  `condicion` VARCHAR(45) NOT NULL COMMENT 'Pendiente o pagado',
  `estado` VARCHAR(45) NOT NULL COMMENT 'Aceptado o anulado-cancelado-borrado',
  `no_credito` INT NOT NULL,
  `cantidad_debitada` DECIMAL(11,2) NOT NULL COMMENT 'La cantidad que debito del socio, puede ser dólares o cordobas',
  PRIMARY KEY (`idhipoteca`),
  INDEX `usuariofk_idx` (`idusuario` ASC),
  INDEX `fiadorfk_idx` (`idfiador` ASC),
  INDEX `garantiahpfk_idx` (`idarticulo_garantia` ASC),
  INDEX `cuenta_desembolsofk_idx` (`cuenta_desembolso` ASC),
  INDEX `solicitudfk_idx` (`solicitud` ASC),
  CONSTRAINT `usuariohpfk`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fiadorhpfk`
    FOREIGN KEY (`idfiador`)
    REFERENCES `db_credi_emp`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `garantiafks`
    FOREIGN KEY (`idarticulo_garantia`)
    REFERENCES `db_credi_emp`.`articulo_hipoteca_detalle` (`idarticulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cuenta_desembolsofk`
    FOREIGN KEY (`cuenta_desembolso`)
    REFERENCES `db_credi_emp`.`cuentas_bancos` (`idcuentas_bancos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `solicitudfk`
    FOREIGN KEY (`solicitud`)
    REFERENCES `db_credi_emp`.`solicitud` (`idsolicitud`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_abono_hipoteca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_abono_hipoteca` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_abono_hipoteca` (
  `iddetalle_abono` INT NOT NULL AUTO_INCREMENT,
  `idhipoteca` INT NOT NULL,
  `idusuario` INT NULL,
  `fecha` DATETIME NOT NULL,
  `abono_capital` DECIMAL(11,2) NULL,
  `abono_interes` DECIMAL(11,2) NULL,
  `interes_pendiente` DECIMAL(11,2) NULL,
  `abono_interes_moratorio` DECIMAL(11,2) NULL,
  `mantenimiento_valor` DECIMAL(11,2) NULL,
  `nota` VARCHAR(1000) NULL,
  `estado` VARCHAR(45) NULL COMMENT 'Saldo pendiente o Sin saldo',
  PRIMARY KEY (`iddetalle_abono`),
  INDEX `hipotecafk0_idx` (`idhipoteca` ASC),
  INDEX `usuariofk0_idx` (`idusuario` ASC),
  CONSTRAINT `hipotecafk0`
    FOREIGN KEY (`idhipoteca`)
    REFERENCES `db_credi_emp`.`hipoteca` (`idhipoteca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `usuariofk0`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`suma_capital`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`suma_capital` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`suma_capital` (
  `idsumacapital` INT NOT NULL AUTO_INCREMENT,
  `idabono_detalle` INT NOT NULL,
  `abono_capital` DECIMAL(11,2) NULL,
  PRIMARY KEY (`idsumacapital`),
  INDEX `abonofk_idx` (`idabono_detalle` ASC),
  CONSTRAINT `abonofk`
    FOREIGN KEY (`idabono_detalle`)
    REFERENCES `db_credi_emp`.`detalle_abono_hipoteca` (`iddetalle_abono`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`fiador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`fiador` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`fiador` (
  `idpersona` INT NOT NULL AUTO_INCREMENT,
  `tipo_persona` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `tipo_documento` VARCHAR(45) NOT NULL,
  `num_documento` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`idpersona`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`nuevacuenta_hipoteca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`nuevacuenta_hipoteca` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`nuevacuenta_hipoteca` (
  `idncuenta_hipoteca` INT NOT NULL AUTO_INCREMENT,
  `nidhipoteca` INT NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idncuenta_hipoteca`),
  CONSTRAINT `idhipotecafk`
    FOREIGN KEY (`nidhipoteca`)
    REFERENCES `db_credi_emp`.`hipoteca` (`idhipoteca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`ingresos_mensuales`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`ingresos_mensuales` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`ingresos_mensuales` (
  `idingresos_mensuales` INT NOT NULL AUTO_INCREMENT,
  `negocio` DECIMAL(11,2) NULL,
  `esposo` VARCHAR(45) NULL,
  `companero` VARCHAR(45) NULL,
  `otros` VARCHAR(45) NULL,
  PRIMARY KEY (`idingresos_mensuales`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_ingreso_cuenta_abono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_ingreso_cuenta_abono` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_ingreso_cuenta_abono` (
  `iddetalle_ingreso_cuenta` INT NOT NULL AUTO_INCREMENT,
  `iddetalle_ingreso_cuentas_bancos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `monto` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso_cuenta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalle_ingreso_cuenta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalle_ingreso_cuenta` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalle_ingreso_cuenta` (
  `iddetalle_ingreso_cuenta` INT NOT NULL AUTO_INCREMENT,
  `idcuentas_bancos` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `moneda` VARCHAR(45) NULL,
  `monto` DECIMAL(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso_cuenta`),
  INDEX `idcuenta_bancoFK_idx` (`idcuentas_bancos` ASC),
  CONSTRAINT `idcuenta_bancoFK`
    FOREIGN KEY (`idcuentas_bancos`)
    REFERENCES `db_credi_emp`.`cuentas_bancos` (`idcuentas_bancos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`egresos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`egresos` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`egresos` (
  `idegresos` INT NOT NULL AUTO_INCREMENT,
  `categoria_egreso` VARCHAR(200) NOT NULL COMMENT 'Puede ser luz, agua cable',
  `detalles` VARCHAR(500) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`idegresos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`detalles_egresos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`detalles_egresos` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`detalles_egresos` (
  `id_detalles_egresos` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `categoria_egreso` INT NOT NULL COMMENT 'Puede ser luz, agua , cable etc',
  `fecha` VARCHAR(45) NULL,
  `detalles` VARCHAR(100) NOT NULL,
  `monto` DECIMAL(11,2) NULL,
  `moneda` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NOT NULL COMMENT 'Puede ser aceptado o anulado\n',
  PRIMARY KEY (`id_detalles_egresos`),
  INDEX `fkegresos_idx` (`categoria_egreso` ASC),
  INDEX `fkusuarios_egresos_idx` (`idusuario` ASC),
  CONSTRAINT `fkegresos`
    FOREIGN KEY (`categoria_egreso`)
    REFERENCES `db_credi_emp`.`egresos` (`idegresos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkusuarios_egresos`
    FOREIGN KEY (`idusuario`)
    REFERENCES `db_credi_emp`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`saldo_banco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`saldo_banco` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`saldo_banco` (
  `idsaldo_banco` INT NOT NULL AUTO_INCREMENT,
  `idhipoteca` INT NOT NULL,
  `idcuentas_banco` INT NOT NULL,
  `cantidad` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(45) NOT NULL COMMENT 'Puede ser anulado o aceptado',
  PRIMARY KEY (`idsaldo_banco`),
  INDEX `sbfkidhipoteca_idx` (`idhipoteca` ASC),
  INDEX `sbfkidcuentas_bancos_idx` (`idcuentas_banco` ASC),
  CONSTRAINT `sbfkidhipoteca`
    FOREIGN KEY (`idhipoteca`)
    REFERENCES `db_credi_emp`.`hipoteca` (`idhipoteca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `sbfkidcuentas_bancos`
    FOREIGN KEY (`idcuentas_banco`)
    REFERENCES `db_credi_emp`.`cuentas_bancos` (`idcuentas_bancos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_credi_emp`.`pendiente_abono`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`pendiente_abono` ;

CREATE TABLE IF NOT EXISTS `db_credi_emp`.`pendiente_abono` (
  `idpendiente_abono` INT NOT NULL AUTO_INCREMENT,
  `idabono_detalle` INT NOT NULL,
  `monto` DECIMAL(11,2) NULL,
  `estado` VARCHAR(45) NULL COMMENT 'Puede ser Pendiente o Pagado el monto',
  PRIMARY KEY (`idpendiente_abono`),
  INDEX `idabonodetallefk_idx` (`idabono_detalle` ASC),
  CONSTRAINT `idabonodetallefk`
    FOREIGN KEY (`idabono_detalle`)
    REFERENCES `db_credi_emp`.`detalle_abono_hipoteca` (`iddetalle_abono`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `db_credi_emp` ;

-- -----------------------------------------------------
-- Placeholder table for view `db_credi_emp`.`view1`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_credi_emp`.`view1` (`id` INT);

-- -----------------------------------------------------
-- View `db_credi_emp`.`view1`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_credi_emp`.`view1`;
DROP VIEW IF EXISTS `db_credi_emp`.`view1` ;
USE `db_credi_emp`;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
