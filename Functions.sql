/*Función para la capacidad máxima de clientes que tiene la cadena de hoteles de la empresa*/
CREATE FUNCTION CapacidadMaxClientes() RETURN INT IS
v_total_clientes INT;
BEGIN
	SELECT COUNT(DISTINCT nif)
	INTO v_total_clientes
	FROM cliente;
	
	RETURN v_total_clientes;
END CapacidadMaxClientes;
