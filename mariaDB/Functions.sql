/*
Función para la capacidad máxima de clientes que tiene la cadena de hoteles de la empresa
Ivan
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION CapacidadMaxClientes() RETURNS INT 
BEGIN
	DECLARE total_clientes INT;
		SELECT sum(nPers)
		INTO total_clientes
		FROM habitacion h LEFT JOIN tipo t ON h.idTipo = t.id;
	RETURN total_clientes;
END;
$$
DELIMITER ;

/*
Función para calcular los ingresos en un año
Ivan
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION obtenerIngresosAño (nac varchar(30)) RETURNS decimal(6,2)
BEGIN
	DECLARE sumIngresos decimal(6,2);

	SELECT SUM(precioTotal)
	INTO sumIngresos
	FROM reserva
	where fechaInicio >= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-01-01') and fechaFin <= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-12-31');

	RETURN sumIngresos;
END;
$$
DELIMITER ;
/*
Función para calcular porcentaje de clientes de un país concreto durante la vida de la empresa
Ivan
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION porcentajeNacionalidadClientesTotal (nac varchar(30)) RETURNS decimal(6,2)
BEGIN
	DECLARE sumNacionalidad decimal(6,2);
	DECLARE totalClientes int(10);

	SELECT COUNT(nif)
	INTO porcentaje
	FROM cliente
	where nacionalidad = nac;

	SELECT COUNT(DISTINCT nif)
	INTO totalClientes
	FROM cliente;

	RETURN (sumNacionalidad / totalClientes) * 100;
END;
$$
DELIMITER ;

/*
Función para calcular porcentaje de clientes de un país entre dos fechas
Ivan
*/
DELIMITER $$
DELIMITER $$
CREATE OR REPLACE FUNCTION porcentajeNacionalidadClientesEntreFechas(pais varchar(30), fecha1 DATE, fecha2 DATE) RETURNS decimal(6,2)
BEGIN
	DECLARE sumNacionalidad, totalClientes int(10);

	SELECT COUNT(nif)
	INTO sumNacionalidad
	FROM cliente c
	LEFT JOIN reservaHist rh ON c.id = rh.idCliente
	LEFT JOIN reserva r ON r.codigo = rh.CodReserva
	where c.id = rh.idCliente
		and c.nacionalidad = nac
		and r.fechaInicio >= fecha1
		and r.fechaFin <= fecha2;

	SELECT COUNT(DISTINCT nif)
	INTO totalClientes
	FROM cliente c
	LEFT JOIN reservaHist rh ON c.id = rh.idCliente
	LEFT JOIN reserva r ON r.codigo = rh.CodReserva
	where c.id = rh.idCliente
		and r.fechaInicio >= fecha1
		and r.fechaFin <= fecha2;

	RETURN (sumNacionalidad / totalClientes) * 100;
END;
$$
DELIMITER ;


/*
Función para obtener la edad de un cliente en base a su DNI
J. PALOMAR
*/

DROP FUNCTION IF EXISTS get_edad

DELIMITER $$
CREATE FUNCTION get_edad (v_nif VARCHAR(30) )
RETURNS int 

BEGIN 

DECLARE v_age INT;
DECLARE v_fechaNac DATE;

SELECT fechaNac INTO v_fechaNac FROM cliente cli WHERE cli.nif = v_nif;
SELECT DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),v_fechaNac)), '%Y')+0 INTO v_age;
RETURN v_age;
END;

$$
DELIMITER ;


/*
Función para obtener el precio de la habitación según fecha y oferta
J. PALOMAR
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION get_precioHabitacion (v_id BIGINT, v_startdate DATE, v_oferta VARCHAR(30) )
RETURNS DECIMAL(6,2) 

BEGIN 

DECLARE v_precioBase INT;
DECLARE v_multiplicador DECIMAL(6, 2);
DECLARE v_descuento DECIMAL(6,2);
DECLARE v_activa TINYINT;


SELECT precioBase INTO v_precioBase 
FROM tipo tp 
INNER JOIN habitacion hb ON tp.id = hb.idTipo
WHERE hb.id = v_id;

SELECT multiplicador INTO v_multiplicador
FROM  temporada tmp
INNER JOIN calendario cl ON tmp.nombre = cl.nombreTemporada AND tmp.anyo = cl.anyoTemporada
WHERE cl.fecha = v_startdate;

SELECT activa, descuento INTO v_activa, v_descuento 
FROM oferta of 
WHERE of.codigo = v_oferta;

IF v_activa = 1 THEN
	RETURN v_precioBase*v_multiplicador * (1 - (v_descuento/100));
ELSE
	RETURN v_precioBase*v_multiplicador;
END IF;

END;

/*
Función para obtener el precio del servicio según fecha
Daniel Sentamans
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION get_precioServicio (v_id BIGINT, v_startdate DATE)
RETURNS DECIMAL(6,2)

BEGIN 

DECLARE v_precioBase INT;
DECLARE v_multiplicador DECIMAL(6, 2);
 
SELECT serv.precio INTO v_precioBase 
FROM servicio serv 
WHERE serv.id = v_id;

SELECT multiplicador INTO v_multiplicador
FROM  temporada tmp
INNER JOIN calendario cl ON tmp.nombre = cl.nombreTemporada AND tmp.anyo = cl.anyoTemporada
WHERE cl.fecha = v_startdate;

RETURN v_precioBase*v_multiplicador;

END;

$$
DELIMITER ;

/*
Función para obtener la temporada de una fecha concreta en base a intervalos preestablecidos
J. PALOMAR
*/
DELIMITER $$
CREATE OR REPLACE FUNCTION get_temporada (v_date DATE)
RETURNS VARCHAR(10) 

BEGIN 

	IF v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-07-01')) AND DATE(CONCAT(YEAR(NOW()), '-08-31'))
		OR v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-12-20')) AND DATE(CONCAT(YEAR(NOW()), '-12-31'))
		OR v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-01-01')) AND DATE(CONCAT(YEAR(NOW()), '-01-07'))
		OR v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-04-05')) AND DATE(CONCAT(YEAR(NOW()), '-04-20')) THEN
		RETURN 'Alta';
	ELSEIF v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-01-20')) AND DATE(CONCAT(YEAR(NOW()), '-03-20')) 
		OR v_date BETWEEN DATE(CONCAT(YEAR(NOW()), '-10-01')) AND DATE(CONCAT(YEAR(NOW()), '-11-30')) THEN
		RETURN 'Baja';
	ELSE
		RETURN 'Media';
	END IF;

END;

$$
DELIMITER ;

/*
Función para comprabar si una reserva está pagada o no. (Se utiliza en la vista reservas_clientes)
A. TARI
*/
DELIMITER |
CREATE OR REPLACE FUNCTION reservaPagada(v_codReserva BIGINT(20))
RETURNS bool
BEGIN
	DECLARE v_resultado int;
	SELECT 1 into v_resultado FROM reservaHist rh where CodReserva = v_codReserva  and pagada = 0;
	IF (v_resultado = 1) then
		RETURN false;
	ELSE
		RETURN true;
	END IF;
END;

/*
Función para obtener que porcentaje de clientes representan dentro de la cadena los que se encuentran en el intervalo de edad indicado.
A. TARI
*/

DELIMITER |
CREATE  or REPLACE FUNCTION porcentaje_clientes_intervalo_edad (v_min INT, v_max INT)
RETURNS decimal(4,2)
BEGIN
	DECLARE v_porcentaje DECIMAL(4,2);
	DECLARE v_totalClientes DECIMAL(12,2);
	DECLARE v_numeroClientesRango DECIMAL(12,2);
	
	SELECT COUNT(*) INTO v_totalClientes  FROM cliente;
	SELECT COUNT(*) INTO v_numeroClientesRango  FROM cliente WHERE get_edad(nif) >= v_min AND get_edad(nif) < v_max;	

	SET v_porcentaje := (v_numeroClientesRango/v_totalClientes)*100;
	
	RETURN v_porcentaje;
END;

/*
Funcion para calcular el precio de un servicio teniendo en cuenta la temporada, y las ofertas
Juan Vercher
*/
DELIMITER |
CREATE FUNCTION calculo_precio_servicio()
returns decimal(6,2)

BEGIN
declare ofert, pb, precioTotal decimal(6,2);
declare tempo decimal(5,2);


SELECT multiplicador from temporada tp, calendario c, reservaServicio rs 
WHERE tp.anyo = c.anyoTemporada 
AND c.nombreTemporada = tp.nombre AND rs.fecha = c.fecha into tempo;

SELECT o.descuento  FROM reservaServicio rs, reserva r, reservaHist rh,oferta o
WHERE rs.codReserva = r.codigo AND rh.CodReserva = r.codigo AND rh.idOferta = o.id into ofert;

SELECT s.precio FROM servicio s, reservaServicio rs
WHERE rs.idServicio = s.id into pb;

set precioTotal := (pb*tempo)-(pb* ofert);
return precioTotal;

END;

/*
Funcion para ver el porcentaje de ocupacion en una fecha
Juan Vercher
*/
DELIMITER |
CREATE FUNCTION ocupacion_fecha(f date)
returns decimal (6,2)

BEGIN

declare oc int ;
declare so int;
declare ocupacion decimal(6,2);

SELECT COUNT(*) into oc
FROM habitacion h, reservaHist rh, reserva r
WHERE h.id = rh.idHabitacion 
AND rh.CodReserva = r.codigo
AND r.fechaInicio <= f
AND r.fechaFin >= f
;

SELECT COUNT(*) into so
FROM habitacion ;

set ocupacion := ((oc/so) * 100);
RETURN ocupacion; 
END;