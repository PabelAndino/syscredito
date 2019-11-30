


INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `estado`) VALUES
(2, 'Cliente', 'General', 'CEDULA', 'general', '', 'general', '', 'Aceptado'),
(3, 'Proveedor', 'Parmalat', 'RUC', '9876543621654987', 'Managua Ritanda el mañanero 2 al lago', '228025546', 'parmalat@gmail.com', 'Aceptado'),
(4, 'Proveedor', 'ElsaSoft', 'RUC', '9898989898', 'Jalapa Nueva Segovia Sector 3', '86395313', 'pabelwitt@gmail.com', 'Aceptado'),
(5, 'Cliente', 'Francisco Castro', 'CEDULA', '48998124124', 'Jalapa Sector 4', '88996655', '', 'Aceptado'),
(6, 'Cliente', 'Armando', 'CEDULA', '456456456', 'Jalapa NS', '86395313', '', 'Aceptado'),
(7, 'Cliente', 'NED SALVADOR', 'CEDULA', '48923189888804', 'SECTOR 4', '88775566', 'nedabril@gmail.com', 'Aceptado');



INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Tania Arauz', 'CEDULA', '4568899770002N', '', '86158798', '', '', 'admin', 'admin', '1517613381.jpg', 1),
(20, 'Pabel', 'CEDULA', '489231089', 'Jalapa', '86395313', 'pabelwitt@gmail.com', 'Administrador', 'admin2', '123123', '1517276930.jpg', 1);

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Abono');


INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 20, 2);


INSERT INTO `categoria_hipoteca` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'CARTA DE VENTA', NULL, 1),
(2, 'EMPEÑO', NULL, 1),
(3, 'ESCRITURA', NULL, 1);


INSERT INTO `sector` (`idsector`, `sector`, `estado`) VALUES
(1, 'PRODUCTIVO', 'Aceptado'),
(2, 'COMERCIO', 'Aceptado'),
(3, 'SERVICIO', 'Aceptado'),
(4, 'AGROINDUSTRIA', 'Aceptado'),
(5, 'PERSONALES', 'Aceptado'),
(6, 'NECESIDAD INMEDIATA', 'Aceptado'),
(7, 'PEQUENA INDUSTRIA', 'Aceptado'),
(8, 'VIVIENDA', 'Aceptado'),
(9, 'ACTIVO FIJO', 'Aceptado');

INSERT INTO `cliente` (`idcliente`, `nombres`, `direccion`, `genero`, `estado_civil`, `tipo_documento`, `num_documento`, `igresos`, `tipo`, `estado`) VALUES
(1, 'Blanca Mendoza', 'JALAPA SECTOR NO 3 DEL ESTADIO DE BASE BALL 1 AL ESTE', 'Mujer', 'Soltero', 'CEDULA', '489776644330002N', NULL, 'Cliente', 'Aceptado'),
(2, 'Ana Chavarria', 'JALAPA SECTOR NO 3 DEL ESTADIO DE BASE BALL 1 AL ESTE', 'Mujer', 'Casado', 'CEDULA', '48977664433009L', NULL, 'Cliente', 'Aceptado'),
(3, 'Pabel Andino', 'SECTOR 3 FRENTE A LA ANTENA DE CLARO', 'Hombre', 'Casado', 'CEDULA', '4892310890002N', '800', 'Fiador', 'Aceptado');




INSERT INTO `socios` (`idsocios`, `nombres`, `direccion`, `tipo_documento`, `cedula_ruc`, `telefono`, `correo`, `estado`) VALUES
(1, 'Cesar Cruz', 'Jalapa Sector 3 Frente a antena Claro', 'Cedula', '4891412960002H', '88967856', 'cesarc@gmail.com', 'Aceptado');


DELIMITER //
CREATE TRIGGER trUpdateStockIngreso AFTER INSERT ON
detalle_ingreso
 FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad
 WHERE articulo.idarticulo = NEW.idarticulo ;
END
//
DELIMITER ;




 DELIMITER //
 
CREATE TRIGGER trUpdateStockVenta AFTER INSERT ON
detalle_venta
 
 FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad
 WHERE articulo.idarticulo = NEW.idarticulo;
 END
 //
 
 DELIMITER ;



 DELIMITER //
 
CREATE TRIGGER trUpdateStockVentaEliminada AFTER UPDATE ON
detalle_venta
 
 FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad
 WHERE articulo.idarticulo = NEW.idarticulo;
 END
 //
 
 DELIMITER ;


DELIMITER //

CREATE TRIGGER trUpdateStockVentaEliminadaDetalle AFTER UPDATE ON
venta
 
 FOR EACH ROW BEGIN
 IF NEW.estado='Anulado'
 THEN 

 UPDATE detalle_venta SET estado = 'Anulado'
 WHERE detalle_venta.idventa = NEW.idventa;
 END IF;
 END

 //
 
 DELIMITER ;









DELIMITER //

CREATE TRIGGER trUpdateStockIngresoEliminadaDetalle AFTER UPDATE ON
ingreso
 
 FOR EACH ROW BEGIN
 IF NEW.estado='Anulado'
 THEN 

 UPDATE detalle_ingreso SET estado = 'Anulado'
 WHERE detalle_ingreso.idingreso = NEW.idingreso;
 END IF;
 END


 //
 
DELIMITER //
 
CREATE TRIGGER trUpdateStockIngresoEliminada AFTER UPDATE ON
detalle_ingreso
 
 FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock - NEW.cantidad
 WHERE articulo.idarticulo = NEW.idarticulo;
 END
 //
 
 DELIMITER ;