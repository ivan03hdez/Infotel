/*
Vista para mostrar los datos de la reserva
Daniel Sentamans
*/
CREATE OR REPLACE VIEW mostrarReserva AS
SELECT re.codigo, re.fechaInicio, re.fechaFin, re.date_diff, 'habitacion' AS 'habitacion/servicio', 
rhist.idHabitacion AS 'id', rhist.precio as precio, NULL AS fecha_servicio
FROM reservaHist rhist, reserva re, habitacion hab
WHERE rhist.CodReserva = re.codigo
AND hab.id = rhist.idHabitacion
UNION ALL
SELECT  re.codigo, re.fechaInicio, re.fechaFin, re.date_diff, 'servicio' AS 'habitacion/servicio', 
reS.idServicio, reS.precio, reS.fecha
FROM reservaServicio reS, reserva re
WHERE re.codigo = reS.codReserva;

/*
Columna calculada para saber la diferencia de días
Jorge Palomar
*/
ALTER TABLE reserva ADD COLUMN date_diff INT GENERATED ALWAYS AS (DATEDIFF(date_add(fechaFin, INTERVAL 1 DAY), FechaInicio)) STORED;
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

/*
Vista general del precio total por servicios y por habitaciones
Jorge Palomar
*/
CREATE OR REPLACE VIEW mostrarReservaAgrupadoPorTipo AS
SELECT codigo,mr.`habitacion/servicio`, SUM( precio * (IF(mr.`habitacion/servicio`='habitacion', mr.date_diff, 1))) AS 'Precio' FROM mostrarReserva mr GROUP BY mr.codigo, mr.`habitacion/servicio`;

