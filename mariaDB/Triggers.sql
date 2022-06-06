/*
Trigger que actualizará el precio total de la habitación
Daniel Sentamans
*/
DELIMITER |
CREATE OR REPLACE TRIGGER reservaHist_after_insert AFTER INSERT ON reservaHist FOR EACH ROW 
BEGIN
DECLARE v_oferta VARCHAR(30);

	SELECT of.codigo INTO v_oferta
	FROM oferta of WHERE of.id = NEW.idOferta;
	
	UPDATE reserva 
	SET reserva.precioTotal = reserva.precioTotal + get_precioHabitacion(NEW.idHabitacion, get_startdate(NEW.CodReserva), v_oferta) 
	WHERE reserva.codigo = NEW.CodReserva;
END;

/*
Trigger que actualizará el precio total de la reserva
Daniel Sentamans
*/
DELIMITER |
CREATE TRIGGER reservaServicio_after_insert AFTER INSERT ON reservaServicio FOR EACH ROW 
BEGIN
	UPDATE reserva 
	SET reserva.precioTotal = reserva.precioTotal + get_precioServicio(NEW.idServicio, NEW.fecha) 
	WHERE reserva.codigo = NEW.codReserva;
END;


/*
Trigger para asignar un empleado a un servicio contratado
A. TARI
*/
DELIMITER |
CREATE or REPLACE TRIGGER reservaServicio_BI_trigger
BEFORE INSERT ON reservaServicio
FOR EACH ROW
BEGIN
	IFNULL(NEW.idEmpleado) {
		SELECT e.id into @id FROM empleado e
		where idHotel = (SELECT idHotel from servicio s where id = NEW.idServicio)
		AND e.id NOT IN (SELECT idEmpleado from reservaServicio rs where fecha = NEW.fecha) LIMIT 1;
			
		/* FALTA DEVOLVER UN ERROR SI NO HAY EMPLEADO DISPONIBLE */
	
		SET NEW.idEmpleado = @id;
	}
END;


/*
Crea un id alternativo único para las reservaServicio
J. Palomar
*/
DELIMITER ;;
CREATE OR REPLACE TRIGGER before_insert_reserva
BEFORE INSERT ON reserva
FOR EACH ROW
BEGIN
  IF new.uuid IS NULL THEN
    SET new.uuid = uuid();
  END IF;
END
;;