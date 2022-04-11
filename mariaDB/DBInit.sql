/* DROP TABLE IF EXISTS reservaServicio, reservaHist, habitacion, servicio, tipo, oferta, empleado, hotel, reserva, cliente, calendario, temporada; */

/* SERIAL is the alias for BIGINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE.*/
CREATE TABLE IF NOT EXISTS hotel (
    id SERIAL PRIMARY KEY,
    nombre varchar(30) NOT NULL,
    direccion varchar(30) NOT NULL,
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
    precioBase decimal(6,2),
    nPers int(3),
    tamanyo int(3)
);

CREATE TABLE IF NOT EXISTS habitacion (
    id SERIAL PRIMARY KEY,
    idHotel BIGINT UNSIGNED NOT NULL, CONSTRAINT fkHabHotel  FOREIGN KEY (idHotel)   REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idTipo BIGINT UNSIGNED NOT NULL, CONSTRAINT fkHabTIpo  FOREIGN KEY (idTipo)   REFERENCES tipo(id) ON UPDATE CASCADE ON DELETE CASCADE,
    numero int(3),
    vistas varchar(30),
    estaLimpia boolean,
    estaOcupada boolean,
    esAdaptada boolean
);

CREATE TABLE IF NOT EXISTS cliente (
    id SERIAL PRIMARY KEY,
    nombre varchar(30),
    apellidos varchar(30),
    nif varchar(30) UNIQUE NOT NULL,
    email varchar(30) UNIQUE NOT NULL ,
    telefono varchar(30),
    fechaNac DATE,
    nacionalidad varchar(30),
    direccion varchar(30),
    cp varchar(30),
    ciudad varchar(30),
    paisResidencia varchar(30),
    estaVacunado boolean
);

CREATE TABLE IF NOT EXISTS oferta (
    id SERIAL PRIMARY KEY,
    codigo varchar(30) NOT NULL,
    descuento decimal(6,2),
    titulo varchar(30),
    descripcion varchar(30),
    fechaFin DATE,
    activa boolean
);

CREATE TABLE IF NOT EXISTS reserva (
    codigo SERIAL PRIMARY KEY,
    fechaInicio DATE NOT NULL,
    fechaFin DATE NOT NULL,
    precioTotal decimal(6,2)
);

CREATE TABLE IF NOT EXISTS reservaHist (
    id SERIAL PRIMARY KEY,
    CodReserva BIGINT UNSIGNED  NOT NULL, CONSTRAINT fkResCod FOREIGN KEY (CodReserva) REFERENCES reserva(codigo) ON UPDATE CASCADE ON DELETE CASCADE,
    idOferta BIGINT UNSIGNED, CONSTRAINT fkResOferta FOREIGN KEY (idOferta) REFERENCES oferta(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idCliente BIGINT UNSIGNED NOT NULL, CONSTRAINT fkResCliente FOREIGN KEY (idCliente) REFERENCES cliente(id) ON UPDATE CASCADE ON DELETE CASCADE,
    idHabitacion BIGINT UNSIGNED NOT NULL, CONSTRAINT fkResHabitacion FOREIGN KEY (idHabitacion) REFERENCES habitacion(id) ON UPDATE CASCADE ON DELETE CASCADE,
    precio decimal(6,2),
    status boolean,
    pagada boolean,
    nPersonas int(3)
);

CREATE TABLE IF NOT EXISTS temporada (
    nombre varchar(30),
    anyo int(10),
    multiplicador decimal(6,3),
    CONSTRAINT pkTemporada PRIMARY KEY (nombre, anyo)
);

CREATE TABLE IF NOT EXISTS calendario (
    fecha DATE,
    nombreTemporada varchar(30),
    anyoTemporada int(10),
    CONSTRAINT fkTemporada FOREIGN KEY (nombreTemporada, anyoTemporada) REFERENCES temporada(nombre, anyo) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS empleado (
    id SERIAL PRIMARY KEY,
    idHotel BIGINT UNSIGNED NOT NULL, CONSTRAINT fkEmpleadoHotel FOREIGN KEY (idHotel) REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    nombre varchar(30),
    apellidos varchar(30),
    nif varchar(30) UNIQUE NOT NULL,
    email varchar(30) UNIQUE NOT NULL,
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

CREATE TABLE IF NOT EXISTS servicio (
    id SERIAL PRIMARY KEY,
    idHotel BIGINT UNSIGNED NOT NULL, CONSTRAINT fkHotel FOREIGN KEY (idHotel) REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    nombre varchar(30),
    descripcion varchar(30),
    precioBase decimal(6,2)
);

CREATE TABLE IF NOT EXISTS reservaServicio (
    fecha DATE,
    idServicio BIGINT UNSIGNED NOT NULL, CONSTRAINT fkReservaServicio FOREIGN KEY (idServicio) REFERENCES servicio(id) ON UPDATE CASCADE ON DELETE CASCADE,
    codReserva BIGINT UNSIGNED NOT NULL, CONSTRAINT fkReserva FOREIGN KEY (codReserva) REFERENCES reserva(codigo) ON UPDATE CASCADE ON DELETE CASCADE,
    idOferta BIGINT UNSIGNED, CONSTRAINT fkServicioOferta FOREIGN KEY (idOferta) REFERENCES oferta(id) ON UPDATE CASCADE ON DELETE CASCADE,,
    idEmpleado BIGINT UNSIGNED, CONSTRAINT fkServicioEmpleado FOREIGN KEY (idEmpleado) REFERENCES empleado(id) ON UPDATE CASCADE ON DELETE CASCADE,
    precio decimal(6,2)
);