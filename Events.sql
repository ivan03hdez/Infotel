/*
Cada año le aplicamos un 2% más al multiplicador por defecto de las temporadas, y después el administrador podrá
Modificarlo a su antojo si ve que algo no le cuadra
*/
DELIMITER $$
CREATE EVENT IF NOT EXISTS actualizarTemporadas ON SCHEDULE EVERY 1 YEAR STARTS DATE('2022-01-01')
DO
    INSERT INTO temporada(nombre, anyo, multiplicador)
    SELECT nombre, (anyo + 1) as anyo, (multiplicador * 1.02) as multiplicador
    from temporada 
    where temporada.anyo = YEAR(NOW());

$$
DELIMITER ;

/*
Al inicio del año se crea la tabla calendario al completo, rellenada según fechas y en base a la función get_temporada
J. PALOMAR
*/

DELIMITER $$
CREATE EVENT IF NOT EXISTS actualizarCalendario ON SCHEDULE EVERY 1 YEAR STARTS DATE('2022-01-01')

DO

INSERT INTO calendario
SELECT * from
	(SELECT 
		adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) fecha, 
	  	get_temporada(adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i)) AS 'nombreTemporada',
		YEAR(NOW()) AS 'anyoTemporada' 
	 FROM
		 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
		 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
		 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
		 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
		 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
	 WHERE fecha between MAKEDATE(year(now()), 1) and LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH));



$$
DELIMITER ;


/*
Todos los días se desactivan las ofertas que finalizan en ese día.
A.TARI
*/

CREATE OR REPLACE EVENT desactivarOfertasConFechaLimite
ON SCHEDULE EVERY 1 DAY STARTS DATE('2022-03-23 00:00:00')
DO
	UPDATE gi_infotel.oferta 
	SET activa = 0 
	WHERE activa = 1 AND fechaFin = DATE_FORMAT(NOW(), '%Y-%m-%d');


/*
Dos semanas antes de San Valentín (14 de febrero) se habilitará una oferta del 15% para ser utilizada hasta ese día (inclusive)
A.TARI
*/

CREATE OR REPLACE EVENT activarOfertaSanValentin
ON SCHEDULE EVERY 1 YEAR STARTS DATE('2023-02-01 00:00:00')
DO
	INSERT INTO gi_infotel.oferta(codigo, descuento, titulo, descripcion, fechaFin, activa) 
	VALUES(CONCAT('SV', DATE_FORMAT(NOW(), '%Y')), 15, CONCAT('San Valentín ', DATE_FORMAT(NOW(), '%Y')), 'Disfruta de un descuento especial por San Valentín' , DATE(CONCAT(DATE_FORMAT(NOW(),'%Y','-02-15'))), 1);




