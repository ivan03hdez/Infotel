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
