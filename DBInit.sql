/* SERIAL is the alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE.*/

CREATE TABLE IF NOT EXISTS hotel (
    id SERIAL PRIMARY KEY,
    nombre varchar(30) NOT NULL,
    dirección varchar(30) NOT NULL,
    cp varchar(5) NOT NULL,
    ciudad varchar(30) NOT NULL,
    pais varchar(30) NOT NULL,
    nEstrellas int(1),
    imagenCiudad BLOB
);

CREATE TABLE IF NOT EXISTS tipo (
    id SERIAL PRIMARY KEY,
    tipo varchar(30) NOT NULL,
    imagen BLOB,
    precioBase decimal(6,2) NOT NULL,
    tamanyo int(3) NOT NULL
);

CREATE TABLE IF NOT EXISTS habitacion (
    id SERIAL PRIMARY KEY,
    idHotel int(10) NOT NULL REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idTipo int(10) NOT NULL REFERENCES tipo(nombre) ON UPDATE CASCADE ON DELETE CASCADE,
    numero int(3),
    vistas varchar(30),
    estaLimpia boolean,
    estaOcupada boolean
);

CREATE TABLE IF NOT EXISTS cliente (
    id SERIAL PRIMARY KEY,
    nombre varchar(30),
    apellidos varchar(30),
    nif varchar(9),
    email varchar(30),
    telefono varchar(30),
    fechaNac DATE,
    nacionalidad varchar(30),
    direccion varchar(30),
    cp varchar(30),
    ciudad varchar(30),
    paisResidencia varchar(30),
    estaVacunado boolean
);

/*      CALCULO DE LA EDAD DEL CLIENTE
CREATE TRIGGER edad_insert before INSERT ON cliente
FOR EACH ROW BEGIN
SET NEW.edad = YEAR(NOW()) - YEAR(NEW.fechaNac);
END;
*/

CREATE TABLE IF NOT EXISTS oferta (
    id SERIAL PRIMARY KEY,
    codigo varchar(30),
    descuento decimal(6,2),
    titulo varchar(30),
    descripcion varchar(30)
);

CREATE TABLE IF NOT EXISTS reserva (
    codigo SERIAL PRIMARY KEY,
    fechaInicio DATE,
    fechaFin DATE,
    precioTotal decimal(6,2)
);

/*      CALCULO DEL PRECIO_TOTAL DE LA RESERVA
CREATE TRIGGER percioTotal_insert after INSERT ON reservaHist
BEGIN 
    UPDATE FROM reserva reserva.precioTotal = reserva.precioTotal + new where codigo = new.cod
END;
*/

CREATE TABLE IF NOT EXISTS reservaHist (
    id SERIAL PRIMARY KEY,
    idCodReserva BIGINT UNSIGNED NOT NULL REFERENCES reserva(codigo) ON UPDATE CASCADE ON DELETE CASCADE,
    idOferta BIGINT UNSIGNED NOT NULL REFERENCES oferta(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idCliente BIGINT UNSIGNED NOT NULL REFERENCES cliente(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idHabitacion BIGINT UNSIGNED NOT NULL REFERENCES habitacion(id) ON UPDATE CASCADE ON DELETE CASCADE,
    numReserva int(10),
    fechaInicio DATE,
    fechaFin DATE,
    precio decimal(6,2),
    status boolean,
    pagada boolean,
    nPersonas int(3)
);

CREATE TABLE IF NOT EXISTS temporada (
    nombre varchar(30),
    anyo int(10),
    multiplicador int(10),
    CONSTRAINT pkTemporada PRIMARY KEY (nombre, anyo)
);

CREATE TABLE IF NOT EXISTS calendario (
    fecha DATE,
    nombreTemporada varchar(30),
    anyoTemporada int(10),
    multiplicador int(10),
    CONSTRAINT fkTemporada FOREIGN KEY (nombreTemporada, anyoTemporada) REFERENCES temporada(nombre, anyo) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS empleado (
    id SERIAL PRIMARY KEY,
    idHotel BIGINT UNSIGNED NOT NULL REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    nombre varchar(30),
    apellidos varchar(30),
    nif varchar(30)/* CHECK((LEN(nif) = 9))*/,
    email varchar(30),
    telefono varchar(30),
    fechaNac DATE,
    nacionalidad varchar(30),
    direccion varchar(30),
    cp varchar(30),
    ciudad varchar(30),
    paisResidencia varchar(30),
    puestoTrabajo varchar(30),
    sueldoBruto decimal(6,2),
    retIRPF decimal(6,2),
    cuotaPatronal decimal(6,2)
);
/*       CALCULO DE LA EDAD DEL EMPLEADO
CREATE TRIGGER edad_insert before INSERT ON empleado
FOR EACH ROW BEGIN
    SET NEW.edad = YEAR(NOW()) - YEAR(NEW.fechaNac);
END;
*/

CREATE TABLE IF NOT EXISTS reservaServicio (
    fecha DATE,
    idServicio BIGINT UNSIGNED NOT NULL REFERENCES servicio(id) ON UPDATE CASCADE ON DELETE CASCADE,
    codReserva BIGINT UNSIGNED NOT NULL REFERENCES reserva(codigo) ON UPDATE CASCADE ON DELETE CASCADE,
    idEmpleado BIGINT UNSIGNED NOT NULL REFERENCES empleado(id) ON UPDATE CASCADE ON DELETE CASCADE,
    precio decimal(6,2)
);

CREATE TABLE IF NOT EXISTS servicio (
    id SERIAL PRIMARY KEY,
    idHotel BIGINT UNSIGNED NOT NULL REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    nombre varchar(30),
    descripcion varchar(30),
    precio decimal(6,2)
);