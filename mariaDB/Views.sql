/*
Vista para mostrar los datos de la reserva
Daniel Sentamans
*/
CREATE OR REPLACE VIEW mostrarReserva
AS SELECT re.codigo, re.fechaInicio, re.fechaFin, 'habitacion' AS 'habitacion/servicio', 
rhist.idHabitacion AS 'id', rhist.precio as precio, NULL AS fecha_servicio
FROM reservaHist rhist, reserva re, habitacion hab
WHERE rhist.CodReserva = re.codigo
AND hab.id = rhist.idHabitacion
UNION SELECT  re.codigo, re.fechaInicio, re.fechaFin, 'servicio' AS 'habitacion/servicio', 
reS.idServicio, reS.precio, reS.fecha
FROM reservaServicio reS, reserva re
WHERE re.codigo = reS.codReserva;



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
CREATE OR REPLACE VIEW reservas_clientes AS SELECT DISTINCT c.nif, c.nombre , c.apellidos, rh.CodReserva, IF(reservaPagada(rh.CodReserva), 'Pagada', 'Pendiente de pago') AS 'Estado de pago'
FROM reservaHist rh, cliente c where rh.idCliente = c.id;

/*
Vistas para ver las hacitaciones para minusvalidos
Juan Vercher
*/
CREATE OR REPLACE
VIEW Adaptada AS SELECT id 
FROM habitacion 
WHERE esAdaptada = 1;

