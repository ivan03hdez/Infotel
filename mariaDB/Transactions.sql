/*
Procedimiento de Transaction para reservar una habitacion
Jorge Palomar/Daniel
*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE introducirDatosReservaHabitacion(
    p_identificador CHAR(6),
    p_idCliente BIGINT,
	 p_idhabitacion BIGINT,
	 p_startdate DATE,
    p_nPersonas int(3)
)
   
BEGIN
	
	   DECLARE v_precioHab decimal(6,2);
	   DECLARE v_codReserva BIGINT;
		/*DECLARE EXIT HANDLER FOR SQLEXCEPTION, NOT FOUND, SQLWARNING
    
	    BEGIN
	    
	        ROLLBACK;
	        GET DIAGNOSTICS CONDITION 1 @`errno` = MYSQL_ERRNO, @`sqlstate` = RETURNED_SQLSTATE, @`text` = MESSAGE_TEXT;
	        SET @full_error = CONCAT('ERROR ', @`errno`, ' (', @`sqlstate`, '): ', @`text`);
	        # SELECT track_no, @full_error;
	    
	    END;*/
	   
   	START TRANSACTION;
   	
	   	SELECT Codigo INTO v_codReserva FROM reserva rv WHERE rv.Identificador =  p_identificador LIMIT 1;
	   	# SELECT SLEEP(5);
	   
	   	SELECT get_precioHabitacionSinOferta(p_idhabitacion, p_startdate) INTO v_precioHab;
	   	# SELECT SLEEP(5);
	   	
			
	
		   INSERT INTO 
			reservaHist (CodReserva, idCliente, idHabitacion, precio, pagada, status, nPersonas)	 
			VALUES(
		        v_codReserva,
		        p_idCliente,
		        p_idhabitacion,
		        v_precioHab,
		        0,
		        1,
		        p_nPersonas
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
    p_hotel BIGINT,
    p_nombreservicio VARCHAR(30),
	 p_identificador CHAR(6),
	 p_idempleado BIGINT,
	 p_startdate DATE
)
   
BEGIN
	
	   DECLARE v_precioSer decimal(6,2);
	   DECLARE v_codReserva BIGINT;
	   DECLARE v_idservicio BIGINT;
		/*DECLARE EXIT HANDLER FOR SQLEXCEPTION, NOT FOUND, SQLWARNING
    
	    BEGIN
	    
	        ROLLBACK;
	        GET DIAGNOSTICS CONDITION 1 @`errno` = MYSQL_ERRNO, @`sqlstate` = RETURNED_SQLSTATE, @`text` = MESSAGE_TEXT;
	        SET @full_error = CONCAT('ERROR ', @`errno`, ' (', @`sqlstate`, '): ', @`text`);
	        # SELECT track_no, @full_error;
	    
	    END;*/
	   
   	START TRANSACTION;
   	
	   	SELECT Codigo INTO v_codReserva FROM reserva rv WHERE rv.Identificador =  p_identificador LIMIT 1;
	   	# SELECT SLEEP(5);
	   	
	   	SELECT id INTO v_idservicio FROM servicio WHERE idHotel=p_hotel AND nombre LIKE CONCAT('%',p_nombreservicio,'%') LIMIT 1;
	   	# SELECT SLEEP(5);
	   	
	   	SELECT get_precioServicio(v_idservicio, p_startdate) INTO v_precioSer;
	   	# SELECT SLEEP(5);
	   	
	
		   INSERT INTO 
			reservaServicio (fecha, idServicio, codReserva, idEmpleado, precio)	 
			VALUES(
		        p_startdate,
		        v_idservicio,
		        v_codReserva,
		        p_idempleado,
				  v_precioSer
		   );
		
		COMMIT;
	
END;

$$
DELIMITER ;

