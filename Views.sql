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
