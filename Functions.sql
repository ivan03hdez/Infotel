/*Función para la capacidad máxima de clientes que tiene la cadena de hoteles de la empresa*/
CREATE FUNCTION IF NOT EXISTS CapacidadMaxClientes() RETURN INT IS
v_total_clientes INT;
BEGIN
	SELECT sum(nPers)
	INTO v_total_clientes
	FROM habitacion h LEFT JOIN tipo t ON h.idTipo = t.id;
	
	RETURN v_total_clientes;
END CapacidadMaxClientes;

/*Función para calcular los ingresos en un año*/
CREATE FUNCTION IF NOT EXISTS obtenerIngresosAño (nac varchar(30)) RETURN decimal(6,2)
BEGIN
	DECLARE sumIngresos decimal(6,2);

	SELECT SUM(precioTotal)
	INTO sumIngresos
	FROM reserva
	where fechaInicio >= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-01-01'); and fechaFin <= CONCAT(DATE_FORMAT(NOW(), '%Y'), '-12-31');

	RETURN sumIngresos;
END obtenerIngresosAño;

/*Función para calcular porcentaje de clientes de un país concreto durante la vida de la empresa*/
CREATE FUNCTION IF NOT EXISTS porcentajeNacionalidadClientesTotal (nac varchar(30)) RETURN decimal(6,2)
BEGIN
	DECLARE sumNacionalidad decimal(6,2), totalClientes int(10);
	SELECT COUNT(nif)
	INTO porcentaje
	FROM cliente
	where nacionalidad = nac;

	SELECT COUNT(nif)
	INTO totalClientes
	FROM cliente;

	RETURN (sumNacionalidad / totalClientes) * 100;
END porcentajeNacionalidadClientesTotal;

/*Función para calcular porcentaje de clientes de un país entre dos fechas*/
CREATE FUNCTION IF NOT EXISTS porcentajeNacionalidadClientesEntreFechas (pais varchar(30), fecha1 DATE, fecha2 DATE) RETURN decimal(6,2)
BEGIN
	DECLARE sumNacionalidad int(10), totalClientes int(10);
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
	LEFT JOIN reservaHist rh ON c.id = rh.idCliente
	LEFT JOIN reserva r ON r.codigo = rh.CodReserva
	where c.id = rh.idCliente
		and r.fechaInicio >= fecha1
		and r.fechaFin <= fecha2;

	RETURN (sumNacionalidad / totalClientes) * 100
END porcentajeNacionalidadClientesEntreFechas;