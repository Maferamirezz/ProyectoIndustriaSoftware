-- MySQL Script generated by MySQL Workbench
-- 05/12/20 23:19:25
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema GAMA
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema GAMA
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `GAMA` DEFAULT CHARACTER SET utf8 ;
USE `GAMA` ;

-- -----------------------------------------------------
-- Table `GAMA`.`TipoProveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`TipoProveedor` (
  `idTipoProveedor` INT NOT NULL,
  `tipoProveedor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoProveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Proveedor` (
  `rtnProveedor` VARCHAR(14) NOT NULL,
  `nombreProveedor` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(45) NULL,
  `telefono` INT NOT NULL,
  `email` VARCHAR(45) NULL,
  `estado` INT NOT NULL,
  `TipoProveedor_idTipoProveedor` INT NOT NULL,
  PRIMARY KEY (`rtnProveedor`),
  INDEX `fk_Proveedor_TipoProveedor_idx` (`TipoProveedor_idTipoProveedor` ASC),
  CONSTRAINT `fk_Proveedor_TipoProveedor`
    FOREIGN KEY (`TipoProveedor_idTipoProveedor`)
    REFERENCES `GAMA`.`TipoProveedor` (`idTipoProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`TipoInsumo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`TipoInsumo` (
  `idTipoInsumo` INT NOT NULL,
  `tipoInsumo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoInsumo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Genero` (
  `idGenero` INT NOT NULL,
  `genero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGenero`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Persona` (
  `idPersona` VARCHAR(13) NOT NULL,
  `pNombre` VARCHAR(45) NOT NULL,
  `sNombre` VARCHAR(45) NOT NULL,
  `pApellido` VARCHAR(45) NOT NULL,
  `sApellido` VARCHAR(45) NOT NULL,
  `telefono` INT NOT NULL,
  `direccion` VARCHAR(200) NULL,
  `Genero_idGenero` INT NOT NULL,
  PRIMARY KEY (`idPersona`),
  INDEX `fk_Persona_Genero1_idx` (`Genero_idGenero` ASC),
  CONSTRAINT `fk_Persona_Genero1`
    FOREIGN KEY (`Genero_idGenero`)
    REFERENCES `GAMA`.`Genero` (`idGenero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`TipoUsuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`TipoUsuario` (
  `idTipoUsuario` INT NOT NULL,
  `tipoUsuario` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`AreaTrabajo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`AreaTrabajo` (
  `idAreaTrabajo` INT NOT NULL,
  `areaTrabajo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idAreaTrabajo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Usuario` (
  `idUsuario` VARCHAR(13) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `contrato` INT NOT NULL,
  `estado` INT NOT NULL,
  `Persona_idPersona` INT NOT NULL,
  `TipoUsuario_idTipoUsuario` INT NOT NULL,
  `AreaTrabajo_idAreaTrabajo` INT NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Persona1_idx` (`Persona_idPersona` ASC),
  INDEX `fk_Usuario_TipoUsuario1_idx` (`TipoUsuario_idTipoUsuario` ASC),
  INDEX `fk_Usuario_AreaTrabajo1_idx` (`AreaTrabajo_idAreaTrabajo` ASC),
  CONSTRAINT `fk_Usuario_Persona1`
    FOREIGN KEY (`Persona_idPersona`)
    REFERENCES `GAMA`.`Persona` (`idPersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_TipoUsuario1`
    FOREIGN KEY (`TipoUsuario_idTipoUsuario`)
    REFERENCES `GAMA`.`TipoUsuario` (`idTipoUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_AreaTrabajo1`
    FOREIGN KEY (`AreaTrabajo_idAreaTrabajo`)
    REFERENCES `GAMA`.`AreaTrabajo` (`idAreaTrabajo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Insumo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Insumo` (
  `idInsumo` INT NOT NULL AUTO_INCREMENT,
  `nombreInsumo` VARCHAR(45) NOT NULL,
  `fecha` DATE NOT NULL,
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `Proveedor_rtnProveedor` INT NOT NULL,
  `TipoInsumo_idTipoInsumo` INT NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idInsumo`),
  INDEX `fk_Insumo_Proveedor1_idx` (`Proveedor_rtnProveedor` ASC),
  INDEX `fk_Insumo_TipoInsumo1_idx` (`TipoInsumo_idTipoInsumo` ASC),
  INDEX `fk_Insumo_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Insumo_Proveedor1`
    FOREIGN KEY (`Proveedor_rtnProveedor`)
    REFERENCES `GAMA`.`Proveedor` (`rtnProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Insumo_TipoInsumo1`
    FOREIGN KEY (`TipoInsumo_idTipoInsumo`)
    REFERENCES `GAMA`.`TipoInsumo` (`idTipoInsumo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Insumo_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `GAMA`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = swe7
COMMENT = '								';


-- -----------------------------------------------------
-- Table `GAMA`.`Jornada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Jornada` (
  `idJornada` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(45) NOT NULL,
  `fechaInicial` DATE NOT NULL,
  `fechaFinal` DATE NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idJornada`),
  INDEX `fk_Jornada_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Jornada_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `GAMA`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`TipoProducto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`TipoProducto` (
  `idTipoProducto` INT NOT NULL,
  `TipoProducto` VARCHAR(45) NULL,
  PRIMARY KEY (`idTipoProducto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `nombreProducto` VARCHAR(45) NOT NULL,
  `cantidadDisponible` INT NOT NULL,
  `precioCosto` FLOAT NOT NULL,
  `impuesto15` FLOAT NOT NULL,
  `impuesto18` FLOAT NOT NULL,
  `descuento` FLOAT NOT NULL,
  `precioVenta` FLOAT NOT NULL,
  `estado` INT NOT NULL,
  `TipoProducto_idTipoProducto` INT NOT NULL,
  PRIMARY KEY (`idProducto`),
  INDEX `fk_Producto_TipoProducto1_idx` (`TipoProducto_idTipoProducto` ASC),
  CONSTRAINT `fk_Producto_TipoProducto1`
    FOREIGN KEY (`TipoProducto_idTipoProducto`)
    REFERENCES `GAMA`.`TipoProducto` (`idTipoProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`TipoCliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`TipoCliente` (
  `idTipoCliente` INT NOT NULL,
  `TipoCliente` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoCliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Cliente` (
  `idCliente` INT NOT NULL,
  `nombreCliente` VARCHAR(45) NOT NULL,
  `estado` INT NOT NULL,
  `direccion` VARCHAR(200) NOT NULL,
  `telefono` INT NULL,
  `TipoCliente_idTipoCliente` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_Cliente_TipoCliente1_idx` (`TipoCliente_idTipoCliente` ASC),
  CONSTRAINT `fk_Cliente_TipoCliente1`
    FOREIGN KEY (`TipoCliente_idTipoCliente`)
    REFERENCES `GAMA`.`TipoCliente` (`idTipoCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Factura` (
  `idFactura` VARCHAR(18) NOT NULL,
  `fecha` DATE NOT NULL,
  `subtotal` FLOAT NOT NULL,
  `importeExento` FLOAT NOT NULL,
  `importeGravado15` FLOAT NOT NULL,
  `importeGravado18` FLOAT NOT NULL,
  `isvTotal15` FLOAT NOT NULL,
  `isvTotal18` FLOAT NOT NULL,
  `descuentoTotal` FLOAT NOT NULL,
  `total` FLOAT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Cliente1_idx` (`Cliente_idCliente` ASC),
  INDEX `fk_Factura_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Factura_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `GAMA`.`Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `GAMA`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`DetalleFactura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`DetalleFactura` (
  `Factura_idFactura` INT NOT NULL,
  `Producto_idProducto` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `montoTotal` FLOAT NOT NULL,
  PRIMARY KEY (`Factura_idFactura`, `Producto_idProducto`),
  INDEX `fk_Factura_has_Producto_Producto1_idx` (`Producto_idProducto` ASC),
  INDEX `fk_Factura_has_Producto_Factura1_idx` (`Factura_idFactura` ASC),
  CONSTRAINT `fk_Factura_has_Producto_Factura1`
    FOREIGN KEY (`Factura_idFactura`)
    REFERENCES `GAMA`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_has_Producto_Producto1`
    FOREIGN KEY (`Producto_idProducto`)
    REFERENCES `GAMA`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GAMA`.`Log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GAMA`.`Log` (
  `idLog` INT NOT NULL AUTO_INCREMENT,
  `fechaSesion` DATE NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idLog`),
  INDEX `fk_Log_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Log_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `GAMA`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
