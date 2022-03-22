/*Evento el el que cada día se checkea la fecha de nacimiento, si las fechas coinciden aumentamos la edad en 1
CREATE EVENT checkFechaAnyos 
ON SCHEDULE EVERY 1 DAY
DO 
UPDATE cliente*/


/*
Cada año le aplicamos un 2% más al multiplicador por defecto, y después el administrador podrá
Modificarlo a su antojo si ve que algo no le cuadra
*/
CREATE EVENT IF NOT EXISTS actualizarTemporadas ON SCHEDULE EVERY 1 YEAR STARTS DATE('2022-01-01')
BEGIN
    INSERT INTO temporada(nombre, anyo, multiplicador)
    SELECT nombre, (anyo + 1) as anyo, (multiplicador * 1.02) as multiplicador
    from temporada 
    where temporada.anyo = YEAR(NOW());
END


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