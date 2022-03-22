/*
Procedimiento para reservar una habitacion
*/
CREATE PROCEDURE introducirDatosReservaHabitacion(
    codReserva SERIAL,
    idOferta varchar(30),
    idCliente varchar(30),
    idHabitacion varchar(30),
    precio decimal(6,2),
    pagada boolean,
    nPersonas int(3)
)
BEGIN
    INSERT INTO reservaHist values(
        codReserva,
        idOferta,
        idCliente,
        idHabitacion,
        /*llamar a procedimiento para calcular el precio de la habitacion*/,
        'activa' ,
        pagada,
        nPersonas)
END

/*
Procedimiento para dar de alta un cliente/empleado
*/
CREATE PROCEDURE introducirDatosCliente(
    isEmployee boolean,
    nif varchar(30), nombre varchar(30), apellidos varchar(30), email varchar(30),telefono varchar(30),
    fechaNac DATE, nacionalidad varchar(30), cp varchar(30), ciudad varchar(30), paisResidencia varchar(30)
)
BEGIN
    IF isEmployee = true THEN
        INSERT INTO empleado(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
    ELSE THEN
        INSERT INTO cliente(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
        values(nif, nombre, apellidos , email, telefono,
        fechaNac, nacionalidad, cp, ciudad, paisResidencia)
END