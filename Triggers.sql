/*Trigger que actualizará el precio total de la habitación*/
CREATE TRIGGER PrecioTotalReservaHab(p_precio_hab DECIMAL, p_cod_reserva BIGINT) AFTER INSERT ON reservaHist 
FOR EACH ROW
BEGIN
	UPDATE reserva SET reserva.precioTotal = reserva.precioTotal + p_precio_hab WHERE reserva.codigo = p_cod_reserva;
	
END PrecioTotalReservaHab;

/*Trigger que actualizará el precio total de la reserva*/
CREATE TRIGGER PrecioTotalReservaServ(p_precio_serv DECIMAL, p_cod_reserva BIGINT) AFTER INSERT ON reservaServicio 
FOR EACH ROW
BEGIN
	UPDATE reserva SET reserva.precioTotal = reserva.precioTotal + p_precio_serv WHERE reserva.codigo = p_cod_reserva;
	
END PrecioTotalReservaServ;


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
