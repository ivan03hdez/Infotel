/*
Procedimiento de Transaction para reservar una habitacion
Ivan / Daniel
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
Procedimiento de Transaction para reservar un servicio
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
