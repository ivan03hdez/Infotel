CREATE TABLE IF NOT EXISTS hotel (
    id unsigned int(10) PRIMARY KEY,
    nombre varchar(30) NOT NULL,
    dirección varchar(30) NOT NULL,
    cp varchar(5) NOT NULL,
    ciudad varchar(30) NOT NULL,
    pais varchar(30) NOT NULL,
    nEstrellas integer(1),
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS habitacion (
    id unsigned int(10) PRIMARY KEY,
    idHotel int(10),
    idTipo int(10),
    numero int(3),
    vistas varchar(30),
    estaLimpia boolean,
    estaOcupada boolean,
    /*CONSTRAINT id PRIMARY KEY (id)*/,
    FOREIGN KEY (idHotel) REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idTipo) REFERENCES tipo(nombre) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tipo (
    id unsigned int(10) PRIMARY KEY,
    tipo varchar(30) NOT NULL,
    precioBase decimal(6,2) NOT NULL,
    tamanyo int(3) NOT NULL,
    /*CONSTRAINT id PRIMARY KEY (id)*/,
    FOREIGN KEY (idHotel) REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idTipo) REFERENCES tipo(nombre) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cliente (
    id unsigned int(10),
    nombre varchar(30),
    apellidos varchar(30),
    nif varchar(9),
    email varchar(30),
    teléfono varchar(30),
    fechaNac DATE,
    nacionalidad varchar(30),
    direccion varchar(30),
    cp varchar(30),
    ciudad varchar(30),
    paisResidencia varchar(30),
    /*CONSTRAINT id PRIMARY KEY (id)*/,
)
ENGINE=InnoDB;

/*CALCULO DE LA EDAD DEL CLIENTE*/
CREATE TRIGGER edad_insert before INSERT ON cliente
FOR EACH ROW BEGIN
SET NEW.edad = YEAR(NOW()) - YEAR(NEW.fechaNac);
END;


CREATE TABLE IF NOT EXISTS reserva (
    id unsigned int(10) PRIMARY KEY,
    idOferta int(10),
    idCliente int(10),
    idHabitacion int(10),
    idCalendario int(10),
    numReserva int(10),
    fechaInicio DATE,
    fechaFin DATE,
    status boolean,
    pagada boolean,
    nPersonas int(3),
    /*CONSTRAINT id PRIMARY KEY (id)*/,
    FOREIGN KEY (idOferta) REFERENCES oferta(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idCliente) REFERENCES cliente(id) ON UPDATE CASCADE ON DELETE CASCADE
    FOREIGN KEY (idHabitacion) REFERENCES habitacion(id) ON UPDATE CASCADE ON DELETE CASCADE
    FOREIGN KEY (idCalendario) REFERENCES calendario(id) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS temporada (
    nombre varchar(30),
    anyo int(10),
    multiplicador int(10),
    CONSTRAINT pkTemporada PRIMARY KEY (nombre, anyo),
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS calendario (
    fecha DATE,
    nombreTemporada varchar(30),
    anyoTemporada int(10)
    multiplicador int(10),
   FOREIGN KEY (nombreTemporada, anyoTemporada) REFERENCES temporada(nombre, anyo) ON UPDATE CASCADE ON DELETE CASCADE,
   CHECK YEAR(fecha) = anyoTemporada
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS empleado (
    id unsigned int PRIMARY KEY,
    idHotel int(10),
    nombre varchar(30)
    apellidos varchar(30),
    nif varchar(30),
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
    cuotaPatronal decimal(6,2),
   FOREIGN KEY (idHotel) REFERENCES hotel(id) ON UPDATE CASCADE ON DELETE CASCADE
)
ENGINE=InnoDB;

/*CALCULO DE LA EDAD DEL EMPLEADO*/
CREATE TRIGGER edad_insert before INSERT ON cliente
FOR EACH ROW BEGIN
SET NEW.edad = YEAR(NOW()) - YEAR(NEW.fechaNac);
END;

CREATE TABLE IF NOT EXISTS reservaServicio (
    fecha DATE,
    nombreTemporada varchar(30),
    anyoTemporada int(10)
    multiplicador int(10),
   FOREIGN KEY (nombreTemporada, anyoTemporada) REFERENCES temporada(nombre, anyo) ON UPDATE CASCADE ON DELETE CASCADE,
   CHECK YEAR(fecha) = anyoTemporada
)
ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS servicio (
    fecha DATE,
    nombreTemporada varchar(30),
    anyoTemporada int(10)
    multiplicador int(10),
   FOREIGN KEY (nombreTemporada, anyoTemporada) REFERENCES temporada(nombre, anyo) ON UPDATE CASCADE ON DELETE CASCADE,
   CHECK YEAR(fecha) = anyoTemporada
)
ENGINE=InnoDB;
/*CONSTRAINT fk_ventavend FOREIGN KEY (numvend) REFERENCES vendedor(numvend) ON UPDATE CASCADE ON DELETE CASCADE
CONSTRAINT pk_venta PRIMARY KEY (numvend, numarticulo)*/