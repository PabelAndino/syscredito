SELECT da.fecha as fecha_abono,h.fecha as fecha_primer_cuenta,cl.nombre as cliente,h.idhipoteca,h.monto,h.interes,

-- (CASE WHEN ah.idhipoteca=h.idhipoteca THEN 'Abono' WHEN ah.idhipoteca <= 0 THEN 'Primera Cuenta'  END) as estado

IF(ah.idhipoteca=h.idhipoteca,"Abono","Primera Cuenta") as estado

FROM hipoteca h INNER JOIN persona cl ON h.idcliente=cl.idpersona 
              INNER JOIN usuario us ON h.idusuario=us.idusuario LEFT JOIN abono_hipoteca ah ON ah.idhipoteca=h.idhipoteca LEFT JOIN detalle_abono_hipoteca da ON da.idabono=ah.idabono
              
              WHERE da.fecha < CURRENT_DATE