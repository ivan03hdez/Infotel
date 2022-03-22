/*Función para la capacidad máxima de clientes que tiene la cadena de hoteles de la empresa*/
DELIMITER $$
CREATE OR REPLACE FUNCTION CapacidadMaxClientes() RETURNS INT 
BEGIN
	DECLARE total_clientes INT;
		SELECT sum(nPers)
		INTO total_clientes
		FROM habitacion h LEFT JOIN tipo t ON h.idTipo = t.id;
	RETURN total_clientes;
END;
$$
DELIMITER ;

/*Función para calcular los ingresos en un año*/
DELIMITER $$
CREATE OR REPLACE FUNCTION obtenerIngresosAño (nac varchar(30)) RETURNS decimal(6,2)
BEGIN
	DECLARE sumIngresos decimal(6,2);

	SELECT SUM(precioTotal)
	INTO sumIngresos
	FROM reserva
	where fechaInicio >= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-01-01') and fechaFin <= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-12-31');

	RETURN sumIngresos;
END;
$$
DELIMITER ;
/*Función para calcular porcentaje de clientes de un país concreto durante la vida de la empresa*/
DELIMITER $$
CREATE OR REPLACE FUNCTION porcentajeNacionalidadClientesTotal (nac varchar(30)) RETURNS decimal(6,2)
BEGIN
	DECLARE sumNacionalidad decimal(6,2);
	DECLARE totalClientes int(10);

	SELECT COUNT(nif)
	INTO porcentaje
	FROM cliente
	where nacionalidad = nac;

	SELECT COUNT(DISTINCT nif)
	INTO totalClientes
	FROM cliente;

	RETURN (sumNacionalidad / totalClientes) * 100;
END;
$$
DELIMITER ;

/*Función para calcular porcentaje de clientes de un país entre dos fechas*/
DELIMITER $$
DELIMITER $$
CREATE OR REPLACE FUNCTION porcentajeNacionalidadClientesEntreFechas(pais varchar(30), fecha1 DATE, fecha2 DATE) RETURNS decimal(6,2)
BEGIN
	DECLARE sumNacionalidad, totalClientes int(10);

	SELECT COUNT(nif)
	INTO sumNacionalidad
	FROM cliente c
	LEFT JOIN reservaHist rh ON c.id = rh.idCliente
	LEFT JOIN reserva r ON r.codigo = rh.CodReserva
	where c.id = rh.idCliente
		and c.nacionalidad = nac
		and r.fechaInicio >= fecha1
		and r.fechaFin <= fecha2;

	SELECT COUNT(DISTINCT nif)
	INTO totalClientes
	FROM cliente c
	LEFT JOIN reservaHist rh ON c.id = rh.idCliente
	LEFT JOIN reserva r ON r.codigo = rh.CodReserva
	where c.id = rh.idCliente
		and r.fechaInicio >= fecha1
		and r.fechaFin <= fecha2;

	RETURN (sumNacionalidad / totalClientes) * 100;
END;
$$
DELIMITER ;
