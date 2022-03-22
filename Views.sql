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

# Vista para obtener los codigos de reserva asociados a un cliente y su estado de pago
# A. TARI
CREATE VIEW reservas_clientes AS SELECT DISTINCT c.nif, c.nombre , c.apellidos, rh.CodReserva, IF(reservaPagada(rh.CodReserva), 'Pagada', 'Pendiente de pago') AS 'Estado de pago'
FROM reservaHist rh, cliente c where rh.idCliente = c.id;
