# Trigger que actualizará el precio total de la habitación
# Daniel Sentamans
DELIMITER |
CREATE OR REPLACE TRIGGER PrecioTotalReservaHab_trigger 
AFTER INSERT ON reservaHist FOR EACH ROW
DECLARE v_precio_hab reservaHist.precio%TYPE;
DECLARE v_oferta oferta.codigo%TYPE;
BEGIN
SELECT
	SELECT of.codigo INTO v_oferta
	FROM oferta of WHERE of.id = idOferta;
	
	v_precio_hab := get_precioHabitacion(idHabitacion, fechaInicio, v_oferta);
	
	UPDATE reserva 
	SET reserva.precioTotal = reserva.precioTotal + v_precio_hab 
	WHERE reserva.codigo = CodReserva;
	
END PrecioTotalReservaHab_trigger;


# Trigger que actualizará el precio total de la reserva
# Daniel Sentamans
DELIMITER |
CREATE OR REPLACE TRIGGER PrecioTotalReservaServ_trigger 
AFTER INSERT ON reservaServicio FOR EACH ROW
DECLARE v_precio_serv reservaServicio.precio%TYPE;
BEGIN
	v_precio_serv := get_precioServicio(idServicio, fecha);
	
	UPDATE reserva 
	SET reserva.precioTotal = reserva.precioTotal + v_precio_serv 
	WHERE reserva.codigo = codReserva;
	
END PrecioTotalReservaServ_trigger;


# Trigger para asignar un empleado a un servicio contratado
# A. TARI

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
