/*Evento el el que cada día se checkea la fecha de nacimiento, si las fechas coinciden aumentamos la edad en 1
CREATE EVENT checkFechaAnyos 
ON SCHEDULE EVERY 1 DAY
DO 
UPDATE cliente*/


/*
Cada año le aplicamos un 5% más al multiplicador por defecto, y después el administrador podrá
Modificarlo a su antojo si ve que algo no le cuadra
*/
CREATE EVENT IF NOT EXISTS actualizarTemporadas ON SCHEDULE EVERY 1 YEAR STARTS DATE('2022-01-01')
BEGIN
    INSERT INTO temporada(nombre, anyo, multiplicador)
    SELECT nombre, (anyo + 1) as anyo, (multiplicador * 1.05) as multiplicador
    from temporada 
    where temporada.anyo = YEAR(NOW());
END
