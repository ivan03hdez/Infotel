/*
Vista para mostrar los datos de la reserva
Daniel Sentamans
*/
CREATE OR REPLACE VIEW mostrarReserva 
AS SELECT fechaInicio, fechaFin, precioTotal 
FROM reserva;

/*
Vista para mostrar los datos de los servicios reservados
Daniel Sentamans
*/
CREATE OR REPLACE VIEW mostrarReservaServicios 
AS SELECT fecha, codReserva, idEmpleado, precio
FROM reservaServicio;

/*
Vista para mostrar los datos de la habitación
Daniel Sentamans
*/
CREATE OR REPLACE VIEW mostrarDatosHabitacion
AS SELECT numero, vistas, estaLimpia, estaOcupada
FROM habitacion;

/*
Vista para obtener los codigos de reserva asociados a un cliente y su estado de pago
A. TARI
*/
CREATE VIEW reservas_clientes AS SELECT DISTINCT c.nif, c.nombre , c.apellidos, rh.CodReserva, IF(reservaPagada(rh.CodReserva), 'Pagada', 'Pendiente de pago') AS 'Estado de pago'
FROM reservaHist rh, cliente c where rh.idCliente = c.id;

/*
Vistas para ver las hacitaciones para minusvalidos
Juan Vercher
*/
CREATE OR REPLACE
VIEW Adaptada AS SELECT id 
FROM habitacion 
WHERE esAdaptada = 1;
/* Vista para ver las habitaciones libres por planta Juan Vercher*/

Create view habitaciones_libre  
as select numero, codhotel, substring(convert(numero,varchar(4)),1,1) 
as 'Planta' from habitacion where numero < 100>199 and esta ocupada = false
count numero

