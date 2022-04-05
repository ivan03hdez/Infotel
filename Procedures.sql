/*
Procedimiento para reservar una habitacion
Ivan
Procedimiento de Transaction Daniel
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE introducirDatosReservaHabitacion(
    codReserva BIGINT
    codOferta varchar(30),
    idCliente BIGINT,
    idHabitacion BIGINT
    pagada TINYINT,
    nPersonas int(3),
    out error tinyint unsigned
)
BEGIN
    DECLARE v_idTipo BIGINT;
    DECLARE idOferta BIGINT;
    DECLARE precioHab decimal(6,2);
    DECLARE exit handler for 1062
	  begin
	  set error = 1;
	   rollback;
	END;	
    
    START TRANSACTION;
    SET ERROR = 0;
	
    SELECT idTipo
    INTO v_idTipo
    from habitacion h
    INNER JOIN h.id = idHabitacion;
    SELECT SLEEP(5);
    
    SELECT get_precioHabitacion(v_idTipo, DATE(NOW()),codOferta) INTO precioHab;
	 SELECT SLEEP(5);

    SELECT id
    INTO idOferta
    from oferta o
    INNER JOIN o.codigo = codOferta;
    SELECT SLEEP(5);

    INSERT INTO reservaHist values(
        codReserva,
        idOferta,
        idCliente,
        idHabitacion,
        precioHab,
        'activa' ,
        pagada,
        nPersonas
    );
    COMMIT;
END;
$$
DELIMITER ;

/*
Procedimiento para reservar un servicio
Procedimiento de Transaction 
Daniel
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE introducirDatosReservaServicio(
    p_fecha DATE,
    p_idServicio BIGINT,
    p_codReserva BIGINT,
    p_idEmpleado BIGINT ,
    out error tinyint unsigned
)
BEGIN
    DECLARE precioServ decimal(6,2);
    DECLARE exit handler for 1062
	  begin
	  set error = 1;
	   rollback;
	END;	
    
    START TRANSACTION;
    SET ERROR = 0;
	
    SELECT get_precioServicio(p_idServicio, DATE(NOW())) 
	 INTO precioServ;
	 SELECT SLEEP(5);

    INSERT INTO reservaServicio values(
        DATE(NOW()),
        p_idServicio,
        p_codReserva,
        p_idEmpleado,
        precioServ,
        null
    );
    COMMIT;
END;
$$
DELIMITER ;


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