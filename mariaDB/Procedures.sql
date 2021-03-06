/*
Procedimiento para dar de alta un cliente/empleado
Ivan
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE introducirDatosPersona(
    isEmployee TINYINT,
    nif varchar(30), nombre varchar(30), apellidos varchar(30), email varchar(30),telefono varchar(30),
    fechaNac DATE, nacionalidad varchar(30), cp varchar(30), ciudad varchar(30), paisResidencia varchar(30)
)
BEGIN
    IF isEmployee = 1 THEN
        INSERT INTO empleado(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
    ELSE
        INSERT INTO cliente(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
    END IF;
END;
$$
DELIMITER ;

/*
Procedure para asignar la temporada entre dos fechas dadas:
    1) asigna cada dia entre las fechas a la temporada dada
    2) Si el dia no existe en la tabla calendario y/o temporada:
        - Si no existe la temporada en cuestion en la tabla temporada, crea una fila en la tabla temporada,
        asignamdo la temporada que falta en base al multiplicador del año pasado y un 5% más.
        - Si no existe el dia en la tabla calendario, se crea y asigna a la temporada.

Este procedure sera necesario para cuando el administrador modifique las temporadas y fechas a su gusto.
Ivan
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE set_temporada_entre_fechas(IN v_temporada VARCHAR(30), IN v_fecha_inicio DATE, IN v_fecha_fin DATE)
BEGIN
    /*UPDATE calendario
    SET nombreTemporada = v_temporada
    WHERE fecha BETWEEN v_fecha_inicio and v_fecha_fin;*/
    DECLARE date_difference int(5) DEFAULT DATEDIFF(v_fecha_fin, v_fecha_inicio);
    DECLARE v_fecha_aux DATE DEFAULT v_fecha_inicio;
    DECLARE existeCal TINYINT DEFAULT 0;
    DECLARE existeTemp TINYINT DEFAULT 0;

    WHILE date_difference >= 0 DO
        select 1 
            INTO existeCal
            from calendario c where c.fecha = v_fecha_aux;
        IF existeCal = 1 THEN
                update calendario
                set nombreTemporada = v_temporada
                where fecha = v_fecha_aux;
        ELSE
            select 1 
                INTO existeTemp
                from temporada t where t.nombre = v_temporada and t.anyo = YEAR(v_fecha_aux);
            IF existeTemp != 1 THEN
                insert into temporada(nombre, anyo)
                values (v_temporada, YEAR(v_fecha_aux));
                update temporada
                set multiplicador = (
                    SELECT multiplicador * 1.05
                    from temporada
                    where nombre = v_temporada and anyo = YEAR(v_fecha_inicio)
                    LIMIT 1)
                where nombre = v_temporada and anyo = YEAR(v_fecha_aux);
            END IF;
            insert into calendario(fecha, nombreTemporada, anyoTemporada)
            values(v_fecha_aux, v_temporada, YEAR(v_fecha_aux));
        END IF;
        set v_fecha_aux = adddate(v_fecha_aux, INTERVAL 1 DAY);
        set date_difference = date_difference - 1;
    END WHILE;
END;
$$
DELIMITER ;

/*
Procedure auxiliar de inserción de multiplicador 
J.PALOMAR
*/

DELIMITER $$
CREATE OR REPLACE PROCEDURE insert_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

DECLARE v_currentyear INT;
SELECT YEAR(NOW()) INTO v_currentyear;

INSERT INTO temporada (nombre, anyo, multiplicador) VALUES (v_temporada, v_currentyear, v_multiplicador);

END;

$$
DELIMITER ;

/*
Procedure auxiliar de actualización de multiplicador 
J.PALOMAR
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE update_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

	DECLARE v_currentyear INT;
	SELECT YEAR(NOW()) INTO v_currentyear;
	
	
	UPDATE temporada SET multiplicador = v_multiplicador WHERE nombre = v_temporada AND anyo = v_currentyear;

END;

$$
DELIMITER ;

/*
Procedure de establecimiento de multiplicador utilizando los procedures previos
J.PALOMAR
*/

DELIMITER $$
CREATE OR REPLACE PROCEDURE set_multiplicador (IN v_temporada VARCHAR(30), IN v_multiplicador DECIMAL(5, 2))

BEGIN 

	DECLARE v_currentyear INT;
	DECLARE v_exists INT;
	
	
	SELECT YEAR(NOW()) INTO v_currentyear;
	SELECT -1 INTO v_exists FROM temporada WHERE NOT EXISTS (SELECT * FROM temporada temp WHERE temp.anyo = v_currentyear AND temp.nombre = v_temporada);
	
	IF v_exists = -1 THEN
		CALL insert_multiplicador(v_temporada, v_multiplicador);
	ELSE
		CALL update_multiplicador(v_temporada, v_multiplicador);
	END IF;

END;

$$
DELIMITER ;


/*CALL set_multiplicador('Media', 1.5);*/

/*
Actualizar precios resrva servicio
J.PALOMAR
*/

DROP PROCEDURE IF EXISTS update_rvs_prices;

DELIMITER $$
create procedure update_rvs_prices()
begin
declare done int default false;
declare v_servicio INT;
declare v_reserva INT;
declare v_empleado INT;
declare v_precio DECIMAL(6,2);
declare cur cursor FOR SELECT idServicio, codReserva, idEmpleado, (mult.multiplicador*serv.precio) AS 'PrecioTotal' FROM reservaServicio rvs INNER JOIN (SELECT cl.fecha AS 'Fecha', multiplicador FROM  temporada tmp INNER JOIN calendario cl ON tmp.nombre = cl.nombreTemporada AND tmp.anyo = cl.anyoTemporada) mult ON mult.Fecha = rvs.fecha INNER JOIN  servicio serv ON idServicio = serv.id;
declare continue handler for not found set done = true;
open cur;
loop1: loop
  fetch cur into v_servicio,v_reserva,v_empleado,v_precio;
  if done then 
    leave loop1; 
  end if;
  -- try to update the next row
  update reservaServicio rvs set rvs.precio = v_precio where rvs.idServicio = v_servicio AND rvs.codReserva = v_reserva AND rvs.idEmpleado = v_empleado;
end loop loop1;
close cur;
END 

$$
DELIMITER ;


/*
Actualizar fechas resrva servicio
J.PALOMAR
*/

DELIMITER $$
create procedure update_rvs_dates()
begin
declare done int default false;
declare v_servicio INT;
declare v_reserva INT;
declare v_empleado INT;
declare v_fecha DATE;
declare cur cursor FOR SELECT idServicio, codReserva, idEmpleado, fechaInicio FROM reservaServicio rvs INNER JOIN reserva rv ON rv.Codigo = rvs.codReserva WHERE fecha = 0;
declare continue handler for not found set done = true;
open cur;
loop1: loop
  fetch cur into v_servicio,v_reserva,v_empleado,v_fecha;
  if done then 
    leave loop1; 
  end if;
  -- try to update the next row
  update reservaServicio rvs set rvs.fecha = v_fecha where rvs.idServicio = v_servicio AND rvs.codReserva = v_reserva AND rvs.idEmpleado = v_empleado;
end loop loop1;
close cur;
END 

$$
DELIMITER ;


/*
Actualizar fechas precios reservaHist
J.PALOMAR
*/

DROP PROCEDURE IF EXISTS update_rvh_prices;

DELIMITER $$
create procedure update_rvh_prices()
begin
declare done int default false;
declare v_id INT;
declare v_precio DECIMAL(6,2);
declare cur cursor FOR 
SELECT 
	rvh.id, (habprec.precioBase*mult.multiplicador * (1 - (of.descuento/100)*of.activa)) AS 'PrecioTotal'
FROM 
	reservaHist rvh
INNER JOIN 
	oferta of
ON 
	rvh.idOferta = of.id
INNER JOIN 
	reserva rv
ON 
	rvh.codReserva = rv.Codigo
INNER JOIN
	(SELECT cl.fecha AS 'Fecha', multiplicador 
	 FROM  temporada tmp
	 INNER JOIN calendario cl ON tmp.nombre = cl.nombreTemporada AND tmp.anyo = cl.anyoTemporada) mult
ON
	mult.Fecha = rv.fechaInicio
INNER JOIN
	(SELECT hab.id AS 'ID', precioBase AS 'PrecioBase' FROM habitacion hab INNER JOIN tipo tip ON hab.idTipo = tip.id) habprec
ON
	rvh.idHabitacion = habprec.ID
WHERE 
	rvh.precio = 0;
declare continue handler for not found set done = true;
open cur;
loop1: loop
  fetch cur into v_id,v_precio;
  if done then 
    leave loop1; 
  end if;
  -- try to update the next row
  update reservaHist rvh set rvh.precio = v_precio where rvh.id = v_id;
end loop loop1;
close cur;
END 

$$
DELIMITER ;


