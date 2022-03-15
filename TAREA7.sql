

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

/*Función para la capacidad máxima de clientes que tiene la cadena de hoteles de la empresa*/
CREATE FUNCTION CapacidadMaxClientes() RETURN INT IS
v_total_clientes INT;
BEGIN
	SELECT COUNT(DISTINCT nif)
	INTO v_total_clientes
	FROM cliente;
	
	RETURN v_total_clientes;
END CapacidadMaxClientes;

/*View para mostrar los datos de la reserva*/
CREATE VIEW mostrarReserva 
AS SELECT fechaInicio, fechaFin, precioTotal 
FROM reserva;

/*View para mostrar los datos de los servicios reservados*/
CREATE VIEW mostrarReservaServicios 
AS SELECT fecha, codReserva, idEmpleado, precio
FROM reservaServicio;

/*View para mostrar los datos de la habitación*/
CREATE VIEW mostrarDatosHabitacion
AS SELECT numero, vistas, estaLimpia, estaOcupada
FROM habitacion;

/*Evento el el que cada día se checkea la fecha de nacimiento, si las fechas coinciden aumentamos la edad en 1
CREATE EVENT checkFechaAnyos 
ON SCHEDULE EVERY 1 DAY
DO 
UPDATE cliente*/


